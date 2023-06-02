<?php

namespace SamarZouinekh\LaravelAuthApi\Tests\Feature;

use SamarZouinekh\LaravelAuthApi\Models\ApiUser;
use SamarZouinekh\LaravelAuthApi\Tests\TestCase;

// use PHPUnit\Framework\TestCase;

class LoginTest extends TestCase
{
    /** @test */
    public function try_to_successfully_login()
    {
        ApiUser::create([
            'name' => $this->faker->name,
            'email' => $email = $this->faker->safeEmail,
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('api/v1/login', [
            'email' => $email,
            'password' => 'password',
        ]);

        $response->assertStatus(200);
    }

    /** @test */
    public function try_to_successfully_login_using_social()
    {
        ApiUser::create([
            'name' => $this->faker->name,
            'email' => $email = $this->faker->safeEmail,
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('api/v1/login/social', [
            'name' => $this->faker->name,
            'provider_name' => 'facebook',
            'provider_id' => $this->faker->randomNumber(),
            'email' => $email,
        ]);

        $response->assertStatus(201);
    }
}
