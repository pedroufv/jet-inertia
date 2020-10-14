<?php

namespace Tests\Feature\Estate;

use App\Models\Estate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EstateIndexTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function estatesListIsPaginated()
    {
        Estate::factory()->count(30)->create();

        $response = $this->json('GET', route('estates.index'));

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'state',
                    'city',
                    'neighborhood',
                    'street',
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
