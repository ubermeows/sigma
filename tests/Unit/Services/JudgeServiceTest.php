<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\JudgeService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class JudgeServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider adjudicateDataProvider
     */
    public function adjudicate(bool $expected, string $title)
    {
        $isSuspicious = app(JudgeService::class)->adjudicate($title);

        $this->assertEquals($expected, $isSuspicious);
    }

    protected function adjudicateDataProvider(): array
    {
        return [
            [false, 'legit title'],
            [true, 'aa[bb]'],
            [true, 'merci ｢Spidaire]'],
            [true, 'merci [Spidaire｣'],
            [true, 'Le BASTONNISTES 𝙀𝙓𝙏𝙍𝙀𝙈𝙀 ｢streamer: LMF｣'],
        ];
    }
}
