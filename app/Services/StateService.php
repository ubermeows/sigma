<?php

namespace App\Services;

use App\Dtos\RawClip;
use App\Enums\ClipStates;
use App\Services\JudgeService;

class StateService
{
    public function __construct(
        protected JudgeService $judgeService,
    ){}

    public function define(RawClip $rawClip): ClipStates
    {
        $isSuspicious = $this->judgeService->adjudicate(
            title: $rawClip->title,
        );

        return match ($isSuspicious) {
            true => ClipStates::Suspect,
            false => ClipStates::Active,
        };
    }
}
