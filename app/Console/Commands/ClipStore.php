<?php

namespace App\Console\Commands;

use App\Jobs\StoreClip;
use Illuminate\Console\Command;
use App\Services\IntervalFactory;
use App\Managers\Twitch\TwitchManager;

class ClipStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clip:store';

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
        $interval = IntervalFactory::currentDay();

        $clips = app(TwitchManager::class)
            ->driver('rawapi')
            ->getClips($interval);

        $clips->map(function ($clip) {
            StoreClip::dispatch($clip)->onQueue('clip-store');
        });

        return Command::SUCCESS;
    }
}
