<?php

namespace Tests\Feature\Owner;

use App\Helpers\Sanitizer;
use App\Models\Owner;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OwnerStoreTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @test
     */
    public function checkOnwerCreateRequiredValidation()
    {
        $response = $this->json('POST', route('owners.store'), []);

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
        $ownerFake = Owner::factory()->make([
            'email' => 'invalid-email',
        ]);

        $response = $this->json('POST', route('owners.store'), $ownerFake->toArray());

        $response->assertJsonValidationErrors([
            'email' => __('validation.email', ['attribute' => 'email']),
        ]);
    }

    /**
     * @test
     */
    public function checkCPFValidation()
    {
        $ownerFake = Owner::factory()->make([
            'type' => 'private',
            'identifier' => '000.000.000-00'
        ]);

        $response = $this->json('POST', route('owners.store'), $ownerFake->toArray());

        $response->assertJsonValidationErrors([
            'identifier' => __('validation.cpf', ['attribute' => 'identifier']),
        ]);
    }

    /**
     * @test
     */
    public function checkCNPJValidation()
    {
        $ownerFake = Owner::factory()->make([
            'type' => 'legal',
            'identifier' => '00.000.000/0000-00'
        ]);

        $response = $this->json('POST', route('owners.store'), $ownerFake->toArray());

        $response->assertJsonValidationErrors([
            'identifier' => __('validation.cnpj', ['attribute' => 'identifier']),
        ]);
    }

    /**
     * @test
     */
    public function privateOwnerCanBeCreated()
    {
        $ownerFake = Owner::factory()->make([
            'type' => 'private',
            'identifier' => '788.037.060-97'
        ]);

        $response = $this->json('POST', route('owners.store'), $ownerFake->toArray());

        $response->assertCreated();

        $data = $ownerFake->getAttributes();
        $data['identifier'] = Sanitizer::onlyDigits($data['identifier']);

        $this->assertDatabaseHas('owners', $data);
    }

    /**
     * @test
     */
    public function legalOwnerCanBeCreated()
    {
        $ownerFake = Owner::factory()->make([
            'type' => 'legal',
            'identifier' => '66.642.293/0001-19'
        ]);

        $response = $this->json('POST', route('owners.store'), $ownerFake->toArray());

        $response->assertCreated();

        $data = $ownerFake->getAttributes();
        $data['identifier'] = Sanitizer::onlyDigits($data['identifier']);

        $this->assertDatabaseHas('owners', $data);
    }
}
