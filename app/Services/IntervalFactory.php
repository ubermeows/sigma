<?php

namespace App\Services;

use Carbon\Carbon;
use App\Dtos\Interval;

class IntervalFactory
{
    public static function currentDay(): Interval
    {
        return new Interval(
            startedAt: Carbon::now()->startOfDay(),
            endedAt: Carbon::now()->endOfDay(),
        );
    }

    public static function currentWeek(): Interval
    {
        return new Interval(
            startedAt: Carbon::now()->startOfWeek(),
            endedAt: Carbon::now()->endOfDay(),
        );
    }
}
