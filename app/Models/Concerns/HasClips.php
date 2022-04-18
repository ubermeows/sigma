<?php

namespace App\Models\Concerns;

use App\Models\Clip;
use App\Enums\ClipStates;

trait HasClips
{
    public function clips()
    {
        return $this->hasMany(Clip::class);
    }

    public function activeClips()
    {
        return $this
            ->clips()
            ->where('state', ClipStates::Active);
    }
}
