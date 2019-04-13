<?php


namespace Tests\Feature;

use App\Model\PasswordReset;
use App\Model\User;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use Tests\TestCase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ResetPasswordTest extends TestCase
{
    public function testResetPassowrRequestSuccessfully()
    {
        Notification::fake();

        $email = 'test@test.com';

        factory(User::class)->create([
            'email'    => $email,
            'password' => bcrypt('toptal123'),
            'verified' => true,
        ]);

        $resetEmail = [
            'email' => $email,
        ];

        $this->json('post', '/api/password/create', $resetEmail)
            ->assertStatus(200)
            ->assertJson(['status' => true]);

        Notification::assertSentTo(
            User::latest()->first(),
            PasswordResetRequest::class
        );
    }

    public function testResetExistEmailRequestFailed()
    {
        $email = 'test@test.com';

        $resetEmail = [
            'email' => $email,
        ];

        $response = $this->json('post', '/api/password/create', $resetEmail);
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);

        $result = json_decode($response->getContent(), true);

        $this->assertEquals(false, $result['status']);
    }

    public function testResetMailTokenSuccessfully()
    {
        $token = str_random(60);

        factory(PasswordReset::class)->create([
            'email' => 'test@test.com',
            'token' => $token,
        ]);

        $this->json('get', "/api/password/find/{$token}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'data',
            ]);
    }

    public function testResetMailTokenFailed()
    {
        $token = str_random(60);

        factory(PasswordReset::class)->create([
            'email' => 'test@test.com',
            'token' => 'testFailedToken',
        ]);

        $this->json('get', "/api/password/find/{$token}")
            ->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
            ]);
    }

    public function testResetMailTokenExpired()
    {
        $expired_date = date("Y-m-d H:i:s", strtotime("-2 day"));
        $token = str_random(60);

        factory(PasswordReset::class)->create([
            'email'      => 'test@test.com',
            'token'      => $token,
            'updated_at' => $expired_date,
        ]);

        $response = $this->json('get', "/api/password/find/{$token}");
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
            ]);

        $result = json_decode($response->getContent(), true);
        $this->assertEquals(false, $result['status']);
    }

    public function testResetPasswordSuccessfully()
    {
        Notification::fake();

        $email = 'test@test.com';
        $token = str_random(60);
        $newPassword = str_random(10);

        $this->_createUser($email);
        $this->_createPasswordReset($email, $token);

        $resetData = [
            'email'                 => $email,
            'token'                 => $token,
            'password'              => $newPassword,
            'password_confirmation' => $newPassword,
        ];

        $response = $this->json('post', '/api/password/reset', $resetData);

        $response->assertStatus(200)->assertJson(['status' => true]);

        Notification::assertSentTo(
            User::latest()->first(),
            PasswordResetSuccess::class
        );
    }

    public function testResetPasswordTokenIsInvalid()
    {
        $email = 'test@test.com';
        $token = str_random(60);
        $newPassword = str_random(10);

        $this->_createUser($email);
        $this->_createPasswordReset($email, $token);

        $resetData = [
            'email'                 => $email,
            'token'                 => 'testIsInvaliedToken',
            'password'              => $newPassword,
            'password_confirmation' => $newPassword,
        ];

        $response = $this->json('post', '/api/password/reset', $resetData);

        $response->assertStatus(200)->assertJson([
            'status'  => false,
            'message' => 'This password reset token is invalid.',
        ]);
    }

    public function testResetPasswordEmailNotFounded()
    {
        $email = 'test@test.com';
        $token = str_random(60);
        $newPassword = str_random(10);

        $this->_createUser($email);
        $this->_createPasswordReset($email, $token);
        $resetData = [
            'email'                 => 'testNotFoundEmail@test.com',
            'token'                 => $token,
            'password'              => $newPassword,
            'password_confirmation' => $newPassword,
        ];

        $response = $this->json('post', '/api/password/reset', $resetData);

        $response->assertStatus(200)->assertJson([
            'status'  => false,
            'message' => 'We can\'t find a user with that email address.',
        ]);
    }

    private function _createUser($email)
    {
        return factory(User::class)->create([
            'email'    => $email,
            'password' => bcrypt('toptal123'),
            'verified' => true,
        ]);
    }

    private function _createPasswordReset($email, $token)
    {
        return factory(PasswordReset::class)->create([
            'email' => $email,
            'token' => $token,
        ]);
    }
}
