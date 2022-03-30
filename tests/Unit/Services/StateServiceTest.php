<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\JudgeService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class StateServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider adjudicateDataProvider
     */
    public function adjudicate(bool $expected, string $title, int $duration)
    {
        $isSuspicious = app(JudgeService::class)->adjudicate($title, $duration);

        $this->assertEquals($expected, $isSuspicious);
    }

    protected function adjudicateDataProvider(): array
    {
        return [
            [true, 'legit title', 60],
            [true, 'aa[bb]', 15],
            [true, 'aa[bb]', 60],
            [true, 'Le BASTONNISTES INTERNATIONAL TOUR 𝙀𝙓𝙏𝙍𝙀𝙈𝙀 ｢streamer: LMF｣', 15],
            [false, 'legit title', 15],
        ];
    }
}
