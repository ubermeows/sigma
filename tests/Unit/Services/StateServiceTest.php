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
            [true, 'Le BASTONNISTES INTERNATIONAL｢streamer: LMF｣'],
        ];
    }
}
