<?php

namespace SamarZouinekh\LaravelAuthApi\Tests\Feature;

use Laravel\Passport\Passport;
use SamarZouinekh\LaravelAuthApi\Models\ApiUser;
use SamarZouinekh\LaravelAuthApi\Tests\TestCase;

// use PHPUnit\Framework\TestCase;

class GetUserTest extends TestCase
{
    /** @test */
    public function try_to_get_the_logged_user_without_authenticating()
    {
        $response = $this->getJson('api/v1/getUser');

        $response->assertStatus(401);
    }

    /** @test */
    public function try_to_get_the_logged_user_with_authenticating()
    {
        $user = ApiUser::create([
            'name' => $this->faker->name,
            'email' => $this->faker->safeEmail,
            'password' => bcrypt('password'),
        ]);

        Passport::actingAs($user, [], 'apiauth');

        $response = $this->getJson('api/v1/getUser');

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'base_url',
            'status',
            'message',
            'data' => [
                'id',
                'name',
                'email',
            ],
        ]);
    }
}
