<?php

namespace Tests\Feature\Owner;

use App\Models\Owner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OwnerDestroyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function ownerCanBeDeleted()
    {
        $owner = Owner::factory()->create([
            'type' => 'private',
            'identifier' => '788.037.060-97'
        ]);

        $response = $this->actingAs($this->getUser())->json('DELETE', route('api.owners.destroy', $owner));

        $response->assertNoContent(204);

        $this->assertDatabaseMissing('owners', $owner->getAttributes());
    }
}
