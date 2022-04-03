<?php

namespace App\Actions;

use App\Dtos\RawClip;
use App\Models\Creator;
use Illuminate\Support\Str;

class RetrieveOrCreateCreator
{
    public function execute(RawClip $rawClip): Creator
    {
        return Creator::firstOrCreate(
            [
                'tracking_id' => $rawClip->creatorId,
            ],
            [
                'name' => $rawClip->creatorName,
                'slug' => Str::slug($rawClip->creatorName),
            ],
        );
    }
}
