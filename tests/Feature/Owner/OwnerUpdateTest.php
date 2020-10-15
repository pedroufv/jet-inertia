<?php

namespace Tests\Feature\Owner;

use App\Helpers\Sanitizer;
use App\Models\Owner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OwnerUpdateTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function checkOnwerUpdateRequiredValidation()
    {
        $owner = Owner::factory()->create([
            'type' => 'private',
            'identifier' => '788.037.060-97'
        ]);

        $response = $this->actingAs($this->getUser())->json('PUT', route('api.owners.update', $owner), []);

        $response->assertJsonValidationErrors('name');
        $response->assertJsonValidationErrors('email');
        $response->assertJsonValidationErrors('type');
        $response->assertJsonValidationErrors('identifier');
    }

    /**
     * @test
     */
    public function checkEmailValidation()
    {
        $owner = Owner::factory()->create([
            'type' => 'private',
            'identifier' => '788.037.060-97'
        ]);

        $response = $this->actingAs($this->getUser())->json('PUT', route('api.owners.update', $owner), ['email' => 'invalid-email']);

        $response->assertJsonValidationErrors([
            'email' => __('validation.email', ['attribute' => 'email']),
        ]);
    }

    /**
     * @test
     */
    public function checkCPFValidation()
    {
        $owner = Owner::factory()->create([
            'type' => 'private',
            'identifier' => '788.037.060-97'
        ]);

        $response = $this->actingAs($this->getUser())->json('PUT', route('api.owners.update', $owner), ['type' => 'private', 'identifier' => '000.000.000-00']);

        $response->assertJsonValidationErrors([
            'identifier' => __('validation.cpf', ['attribute' => 'identifier']),
        ]);
    }

    /**
     * @test
     */
    public function checkCNPJValidation()
    {
        $owner = Owner::factory()->create([
            'type' => 'legal',
            'identifier' => '66.642.293/0001-19'
        ]);

        $response = $this->actingAs($this->getUser())->json('PUT', route('api.owners.update', $owner), ['type' => 'legal', 'identifier' => '00.000.000/0000-00']);

        $response->assertJsonValidationErrors([
            'identifier' => __('validation.cnpj', ['attribute' => 'identifier']),
        ]);
    }

    /**
     * @test
     */
    public function privateOwnerCanBeUpdated()
    {
        $owner = Owner::factory()->create([
            'type' => 'private',
            'identifier' => '788.037.060-97'
        ]);

        $ownerFake = Owner::factory()->make([
            'type' => 'private',
            'identifier' => '386.930.750-12'
        ]);

        $response = $this->actingAs($this->getUser())->json('PUT', route('api.owners.update', $owner), $ownerFake->toArray());

        $response->assertOk();

        $data = $ownerFake->getAttributes();
        $data['identifier'] = Sanitizer::onlyDigits($data['identifier']);

        $this->assertDatabaseHas('owners', $data);
    }

    /**
     * @test
     */
    public function legalOwnerCanBeUpdated()
    {
        $owner = Owner::factory()->create([
            'type' => 'legal',
            'identifier' => '66.642.293/0001-19'
        ]);

        $ownerFake = Owner::factory()->make([
            'type' => 'legal',
            'identifier' => '28.717.313/0001-84'
        ]);

        $response = $this->actingAs($this->getUser())->json('PUT', route('api.owners.update', $owner), $ownerFake->toArray());

        $response->assertOk();

        $data = $ownerFake->getAttributes();
        $data['identifier'] = Sanitizer::onlyDigits($data['identifier']);

        $this->assertDatabaseHas('owners', $data);
    }
}
