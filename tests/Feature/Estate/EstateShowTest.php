<?php

namespace Tests\Feature\Estate;

use App\Models\Estate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EstateShowTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function estateCanBeDisplayed()
    {
        $estate = Estate::factory()->create();

        $response = $this->json('GET', route('estates.show', $estate));

        $response->assertJsonStructure([
            'data' => [
                'state',
                'city',
                'neighborhood',
                'street',
                'created_at',
                'updated_at',
            ],
        ]);

        $response->assertOk();
    }
}
