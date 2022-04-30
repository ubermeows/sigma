<?php

namespace App\Console\Commands\Clip;

use App\Models\Clip;
use App\Jobs\UpdateClip;
use App\Enums\ClipStates;
use Illuminate\Console\Command;

class UpdateRecentSuspect extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clip:update-recent-suspect';

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
        $clips = Clip::where('state', ClipStates::Suspect)
            ->where('published_at', '>', now()->subHours(3))
            ->get();

        $clips->map(function ($clip) {
            UpdateClip::dispatch($clip)->onQueue('clip-update');
        });

        return Command::SUCCESS;
    }
}
