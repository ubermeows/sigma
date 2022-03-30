<?php

namespace App\Services;

use Illuminate\Support\Str;

class JudgeService
{
    public function adjudicate(string $title, int $duration): bool
    {
        $parts = [
            $this->suspiciousTitle($title),
            $this->suspiciousDuration($duration),
        ];

        return in_array(true, $parts, true);
    }

    protected function suspiciousTitle(string $title): bool
    {
        return (bool) preg_match('#(\[.*\]|｢.*｣)#', $title);
    }

    protected function suspiciousDuration(int $duration): bool
    {
        return $duration === 60;
    }
}
