<?php

namespace Tests\Feature\Owner;

use App\Models\Owner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OwnerIndexTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function ownersListIsPaginated()
    {
        Owner::factory()->count(30)->create();

        $response = $this->json('GET', route('owners.index'));

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'name',
                    'email',
                    'type',
                    'identifier',
                ]
            ],
            'links' => ['first', 'last', 'prev', 'next'],
            'meta' => [
                'current_page', 'last_page', 'from', 'to',
                'path', 'per_page', 'total'
            ]
        ]);

        $response->assertOk();
    }
}
