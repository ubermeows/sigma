<?php

namespace App\Jobs;

use App\Models\Clip;
use App\Dtos\RawClip;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use App\Actions\RetrieveOrCreateClip;
use App\Actions\RetrieveOrCreateGame;
use Illuminate\Queue\SerializesModels;
use App\Actions\RetrieveOrCreateCreator;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class StoreClip implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        protected RawClip $rawClip,
    ){}

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if ($this->clipAlreadySave()) {
            return;
        }

        $this->store();
    }

    protected function clipAlreadySave(): bool
    {
        return Clip::where('tracking_id', $this->rawClip->id)->exists(); 
    }

    protected function store()
    {
        DB::transaction(function () {

            $game = app(RetrieveOrCreateGame::class)
                ->execute($this->rawClip);

            $creator = app(RetrieveOrCreateCreator::class)
                ->execute($this->rawClip);
                
            app(RetrieveOrCreateClip::class)->execute(
                rawClip: $this->rawClip, 
                game: $game, 
                creator: $creator
            );
        }); 
    }
}
