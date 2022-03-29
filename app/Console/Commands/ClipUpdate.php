<?php

namespace App\Console\Commands;

use App\Models\Clip;
use App\Jobs\UpdateClip;
use Illuminate\Console\Command;

class ClipUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clip:update';

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
        $clips = Clip::active()->get();

        $clips->map(function ($clip) {
            UpdateClip::dispatch($clip)->onQueue('clip-update');
        });

        return Command::SUCCESS;
    }
}
