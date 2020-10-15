<?php

namespace Tests\Feature\Estate;

use App\Helpers\Sanitizer;
use App\Models\Estate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EstateUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function checkEstateUpdateRequiredValidation()
    {
        $estate = Estate::factory()->create();

        $response = $this->actingAs($this->getUser())->json('PUT', route('api.estates.update', $estate), []);

        $response->assertJsonValidationErrors('state');
        $response->assertJsonValidationErrors('city');
        $response->assertJsonValidationErrors('neighborhood');
        $response->assertJsonValidationErrors('street');
    }

    /**
     * @test
     */
    public function estateCanBeUpdated()
    {
        $estate = Estate::factory()->create();

        $estateFake = Estate::factory()->make();

        $response = $this->actingAs($this->getUser())->json('PUT', route('api.estates.update', $estate), $estateFake->toArray());

        $response->assertOk();

        $this->assertDatabaseHas('estates', $estateFake->toArray());
    }
}
