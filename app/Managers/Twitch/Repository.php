<?php

namespace App\Managers\Twitch;

use App\Dtos\RawClip;
use App\Dtos\RawGame;
use App\Dtos\Interval;
use App\Dtos\TrackingId;
use App\Dtos\BearerToken;
use Illuminate\Support\Collection;
use App\Managers\Twitch\Contracts\Driver;

class Repository
{
    protected $driver;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    public function getBearerToken(): BearerToken
    {
        return $this->driver->getBearerToken();
    }

    public function getClips(Interval $interval): Collection
    {
        return $this->driver->getClips($interval);
    }

    public function getClip(TrackingId $trackingId): RawClip
    {
        return $this->driver->getClip($trackingId);
    }

    public function getGame(RawClip $rawClip): RawGame
    {
        return $this->driver->getGame($rawClip);
    }
}
