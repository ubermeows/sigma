<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Clip;
use App\Dtos\RawClip;
use App\Dtos\Interval;
use App\Jobs\StoreClip;
use Carbon\CarbonPeriod;
use App\Services\JudgeService;
use Illuminate\Console\Command;
use App\Services\IntervalFactory;
use Illuminate\Support\Collection;
use App\Managers\Twitch\TwitchManager;
use App\Exceptions\ResponseIsEmptyException;

class ClipCollect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clip:collect {startedAt} {endedAt?}';

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
        $intervals = $this->getIntervals();

        foreach ($intervals as $interval) {

            try {

                $clips = $this->getClips($interval);

                $this->advise($interval, $clips);

                $clips
                    ->reject(fn($clip) => $this->clipIsSuspect($clip))
                    ->reject(fn($clip) => $this->clipAlreadySave($clip))
                    ->map(function ($clip) {
                        StoreClip::dispatch($clip)->onQueue('clip-store');
                    });

            } catch (ResponseIsEmptyException $e) {}
        }

        return Command::SUCCESS;
    }

    protected function getIntervals(): array
    {
        $period = $this->getPeriod();

        $intervals = [];

        foreach ($period as $startedAt) {

            $endedAt = $startedAt->clone()->endOfMonth()->endOfDay();

            $intervals[] = IntervalFactory::custom($startedAt, $endedAt);
        }

        return $intervals;
    }

    protected function getPeriod(): CarbonPeriod
    {
        $startedAt = $this->argument('startedAt');
        $endedAt = $this->argument('endedAt') ?? Carbon::today();

        return CarbonPeriod::create(
            $startedAt, 
            '1 month', 
            $endedAt,
        );
    }

    protected function getClips(Interval $interval): Collection
    {
        return app(TwitchManager::class)
            ->driver('rawapi')
            ->getClips($interval);
    }

    protected function clipIsSuspect(RawClip $clip): bool
    {
        return app(JudgeService::class)->adjudicate($clip->title);
    }

    protected function clipAlreadySave(RawClip $clip): bool
    {
        return Clip::where('tracking_id', $clip->id)->exists(); 
    }

    protected function advise(Interval $interval, Collection $clips): void
    {
        $parts = [
            $interval->startedAt->format('Y-m-d'),
            $interval->endedAt->format('Y-m-d'),
            $clips->count(),
        ];

        $sentence = sprintf('%s - %s : %s clips found !', ... $parts);

        $this->info($sentence);
    }
}
