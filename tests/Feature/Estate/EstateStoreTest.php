<?php

namespace Tests\Feature\Estate;

use App\Models\Estate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EstateStoreTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function checkEstateCreateRequiredValidation()
    {
        $response = $this->json('POST', route('estates.store'), []);

        $response->assertJsonValidationErrors('state');
        $response->assertJsonValidationErrors('city');
        $response->assertJsonValidationErrors('neighborhood');
        $response->assertJsonValidationErrors('street');
    }

    /**
     * @test
     */
    public function estateCanBeCreated()
    {
        $estateFake = Estate::factory()->make();

        $response = $this->json('POST', route('estates.store'), $estateFake->toArray());

        $response->assertCreated();

        $this->assertDatabaseHas('estates', $estateFake->getAttributes());
    }
}
