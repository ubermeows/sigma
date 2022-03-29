<?php

namespace App\Managers\Twitch\Drivers;

use Http;
use App\Dtos\RawClip;
use App\Dtos\RawGame;
use App\Dtos\Interval;
use App\Dtos\RawClipId;
use App\Dtos\BearerToken;
use Illuminate\Support\Collection;
use App\Managers\Twitch\Contracts\Driver;
use Illuminate\Http\Client\PendingRequest;

class RawApi implements Driver
{
    public function __construct(
        protected array $config,
    ){}

    public function getBearerToken(): BearerToken
    {
        $url = $this->config['endpoints']['oauth2'] 
            . '?client_id=' . $this->config['client_id']
            . '&client_secret=' . $this->config['client_secret']
            . '&grant_type=client_credentials';

        $response = Http::post($url);

        $attributes = $response->json();

        return new BearerToken(
            value: $attributes['access_token'],
            expiresIn: $attributes['expires_in'],
        );
    }

    public function getClips(Interval $interval): Collection
    {
        $url = $this->config['endpoints']['clips'] 
            . '?broadcaster_id=' . $this->config['broadcaster_id']
            . '&first=50'
            . '&started_at=' . $interval->startedAt->toIso8601ZuluString()
            . '&ended_at=' . $interval->endedAt->toIso8601ZuluString();

        $items = $this->callClient($url);

        return collect($items)
            ->map(fn($item) => new RawClip($item));
    }

    public function getClip(RawClipId $rawClipId): RawClip
    {
        $url = $this->config['endpoints']['clips'] 
            . '?id=' . $rawClipId->value;

        $items = $this->callClient($url);

        return new RawClip($items[0]);
    }

    public function getGame(RawClip $rawClip): RawGame
    {
        $url = $this->config['endpoints']['games'] 
            . '?id=' . $rawClip->gameId;

        $items = $this->callClient($url);

        return new RawGame($items[0]);
    }

    protected function callClient(string $url): array
    {
        $client = $this->getClient();

        $response = $client->get($url);

        $attributes = $response->json();

        return $attributes['data'];
    }

    protected function getClient(): PendingRequest
    {
        $headers = [
            'Client-Id' => $this->config['client_id'],
        ];

        $bearerToken = $this->getBearerToken();

        return Http::withToken($bearerToken->value)
            ->withHeaders($headers);
    }
}
