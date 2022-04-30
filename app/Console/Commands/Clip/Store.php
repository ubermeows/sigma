<?php

namespace App\Console\Commands\Clip;

use Carbon\Carbon;
use App\Models\Clip;
use App\Dtos\RawClip;
use App\Dtos\Interval;
use App\Jobs\StoreClip;
use Illuminate\Console\Command;
use App\Services\IntervalFactory;
use Illuminate\Support\Collection;
use App\Managers\Twitch\TwitchManager;
use App\Exceptions\ResponseIsEmptyException;

class Store extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clip:store {--startedAt=} {--endedAt=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {

            $clips = $this->getClips();

            $clips
                ->reject(fn($clip) => $this->clipAlreadySave($clip))
                ->map(function ($clip) {
                    StoreClip::dispatch($clip)->onQueue('clip-store');
                });

        } catch (ResponseIsEmptyException $e) {
            $this->info('no clips, maybe later ...');
        }

        return Command::SUCCESS;
    }

    protected function getClips(): Collection
    {
        $interval = $this->getInterval();

        return app(TwitchManager::class)
            ->driver('rawapi')
            ->getClips($interval);
    }

    protected function clipAlreadySave(RawClip $clip): bool
    {
        return Clip::where('tracking_id', $clip->id)->exists(); 
    }

    protected function getInterval(): Interval
    {
        $startedAt = $this->getDate('startedAt', 'startOfDay');
        $endedAt = $this->getDate('endedAt', 'endOfDay');

        return IntervalFactory::custom($startedAt, $endedAt);
    }

    protected function getDate(string $option, string $end): Carbon
    {
        $date = $this->option($option);

        $carbon = ($date) 
            ? Carbon::createFromFormat('Y-m-d', $date)
            : Carbon::now();

        return $carbon->{$end}();
    }
}
