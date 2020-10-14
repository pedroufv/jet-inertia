<?php

namespace Tests\Feature\Estate;

use App\Models\Estate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EstateDestroyTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function estateCanBeDeleted()
    {
        $estate = Estate::factory()->create();

        $response = $this->json('DELETE', route('estates.destroy', $estate));

        $response->assertNoContent(204);

        $this->assertSoftDeleted('estates', $estate->getAttributes());
    }
}
