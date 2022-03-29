<?php

namespace App\Dtos;

use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class Interval extends DataTransferObject
{
    public Carbon $startedAt;
    public Carbon $endedAt;
}
