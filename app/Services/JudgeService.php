<?php

namespace App\Services;

use Illuminate\Support\Str;

class JudgeService
{
    public function adjudicate(string $title): bool
    {
        return (bool) preg_match('#(\[.*\]|\｢.*\｣|\｢.*\]|\[.*\｣)#', $title);
    }
}
