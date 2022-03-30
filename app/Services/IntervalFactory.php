<?php

namespace App\Services;

use Carbon\Carbon;
use App\Dtos\Interval;

class IntervalFactory
{
    public static function custom(Carbon $startedAt, Carbon $endedAt): Interval
    {
        return new Interval(
            startedAt: $startedAt,
            endedAt: $endedAt,
        );
    }

    public static function currentDay(): Interval
    {
        return self::custom(
            startedAt: Carbon::now()->startOfDay(),
            endedAt: Carbon::now()->endOfDay(),
        );
    }

    public static function currentWeek(): Interval
    {
        return self::custom(
            startedAt: Carbon::now()->startOfWeek(),
            endedAt: Carbon::now()->endOfDay(),
        );
    }
}
