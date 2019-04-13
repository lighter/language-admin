<?php

namespace Tests\Feature;

use App\Model\User;
use App\Model\VerifyUser;
use App\Notifications\VerifyUserMail;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    public function testsRegistersSuccessfully()
    {
        Notification::fake();

        $payload = [
            'name'                  => 'John',
            'email'                 => 'john@toptal.com',
            'password'              => 'toptal123',
            'password_confirmation' => 'toptal123',
        ];

        $this->json('post', '/api/register', $payload)
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

        Notification::assertSentTo(
            User::latest()->first(),
            VerifyUserMail::class
        );
    }

    public function testRegistersAndVerifiedSuccessfully()
    {
        $user = factory(User::class)->create([
            'email'    => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);

        $verifyUser = factory(VerifyUser::class)->create([
            'user_id' => $user->id,
        ]);

        $verifyUserData = [
            'token' => $verifyUser->token,
        ];

        $response = $this->json('post', '/api/user/verify', $verifyUserData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);

        $result = json_decode($response->getContent(), true);

        $this->assertEquals(true, $result['status']);
    }

    public function testRegistersAndRepeatVerifiedSuccessfully()
    {
        $user = factory(User::class)->create([
            'email'    => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
            'verified' => true,
        ]);

        $verifyUser = factory(VerifyUser::class)->create([
            'user_id' => $user->id,
        ]);

        $verifyUserData = [
            'token' => $verifyUser->token,
        ];

        $response = $this->json('post', '/api/user/verify', $verifyUserData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);

        $result = json_decode($response->getContent(), true);

        $this->assertEquals(true, $result['status']);
        $this->assertEquals('Your e-mail is already verified. You can now login.', $result['message']);
    }

    public function testRegistersVerifiedFailed()
    {
        $user = factory(User::class)->create([
            'email'    => 'testlogin@user.com',
            'password' => bcrypt('toptal123'),
        ]);

        $verifyUser = factory(VerifyUser::class)->create([
            'user_id' => $user->id,
        ]);

        $verifyUserData = [
            'token' => 'abcde12345',
        ];

        $response = $this->json('post', '/api/user/verify', $verifyUserData);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);

        $result = json_decode($response->getContent(), true);

        $this->assertEquals(false, $result['status']);
    }

    public function testsRequiresPasswordEmailAndName()
    {
        $this->json('post', '/api/register')
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'name'     => ['The name field is required.'],
                    'email'    => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ],
            ]);
    }

    public function testsRequirePasswordConfirmation()
    {
        $payload = [
            'name'     => 'John',
            'email'    => 'john@toptal.com',
            'password' => 'toptal123',
        ];

        $this->json('post', '/api/register', $payload)
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'password' => ['The password confirmation does not match.'],
                ],
            ]);
    }
}
