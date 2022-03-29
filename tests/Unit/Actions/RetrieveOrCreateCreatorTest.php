<?php

namespace Tests\Unit\Actions;

use Tests\TestCase;
use App\Dtos\RawClip;
use App\Models\Creator;
use App\Actions\RetrieveOrCreateCreator;
use Illuminate\Foundation\Testing\DatabaseMigrations; 

class RetrieveOrCreateCreatorTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function retrieve_creator()
    {
        $creator = Creator::factory()->create();

        $creatorRetrieved = app(RetrieveOrCreateCreator::class)->execute(new RawClip(
            creator_id: $creator->tracking_id,
        ));

        $this->assertFalse($creatorRetrieved->wasRecentlyCreated);
        $this->assertTrue($creator->is($creatorRetrieved));
    }

    /**
     * @test
     */
    public function create_creator()
    {
        $creator = app(RetrieveOrCreateCreator::class)->execute(new RawClip(
            creator_id: '519157370',
            creator_name: 'Bill__g8',
        ));

        $this->assertTrue($creator->wasRecentlyCreated);
        $this->assertDatabaseHas('creators', [
            'tracking_id' => '519157370',
            'name' => 'Bill__g8',
        ]);
    }
}
