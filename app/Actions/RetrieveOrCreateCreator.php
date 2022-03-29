<?php

namespace App\Actions;

use App\Dtos\RawClip;
use App\Models\Creator;

class RetrieveOrCreateCreator
{
    public function execute(RawClip $rawClip): Creator
    {
        return Creator::firstOrCreate(
            [
                'raw_id' => $rawClip->creatorId,
            ],
            [
                'name' => $rawClip->creatorName,
            ],
        );
    }
}
