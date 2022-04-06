<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Dtos\RawClip;
use App\Enums\ClipStates;
use App\Services\StateService;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class StateServiceTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     * @dataProvider defineDataProvider
     */
    public function define(ClipStates $expected, string $title)
    {
        $rawClip = new RawClip(
            title: $title,
        );

        $state = app(StateService::class)->define($rawClip);

        $this->assertEquals($expected, $state);
    }

    protected function defineDataProvider(): array
    {
        return [
            [ClipStates::Active, 'legit title'],
            [ClipStates::Suspect, 'aa[bb]'],
            [ClipStates::Suspect, 'merci ｢Spidaire]'],
            [ClipStates::Suspect, 'merci [Spidaire｣'],
            [ClipStates::Suspect, 'Le BASTONNISTES ｢streamer: LMF｣'],
        ];
    }
}
