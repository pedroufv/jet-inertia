<?php

namespace Tests\Feature\Owner;

use App\Models\Owner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OwnerShowTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function ownerCanBeDisplayed()
    {
        $owner = Owner::factory()->create([
            'type' => 'private',
            'identifier' => '788.037.060-97'
        ]);

        $response = $this->json('GET', route('owners.show', $owner));

        $response->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'email',
                'type',
                'identifier',
                'created_at',
                'updated_at',
            ],
        ]);

        $response->assertOk();
    }
}
