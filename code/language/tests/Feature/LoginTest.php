<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function testRequiredEmailAndLogin()
    {
        $this->json('POST', 'api/login')
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'email'    => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ],
            ]);
    }

    public function testUserUnVerifiedLoginFailed()
    {
        $user = factory(\App\Model\User::class)->create([
            'email'    => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);

        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'email' => ['These credentials do not match our records.']
                ],
            ]);

    }

    public function testUserLoginSuccessfully()
    {
        $user = factory(\App\Model\User::class)->create([
            'email'    => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
            'verified' => true,
        ]);

        $payload = ['email' => 'testlogin@user.com', 'password' => 'toptal123'];

        $this->json('POST', 'api/login', $payload)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'updated_at',
                    'api_token',
                ],
            ]);

    }
}
