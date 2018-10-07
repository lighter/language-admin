<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LogoutTest extends TestCase
{
    public function testUserIsLoggedOutProperly()
    {
        $user = factory(\App\Model\User::class)->create(['email' => 'user@test.com']);
        $token = $user->generateToken();
        $headers = ['Authorization' => "Bearer $token"];

        $this->json('POST', '/api/logout', [], $headers)->assertStatus(200);

        $user = \App\Model\User::find($user->id);

        $this->assertEquals(null, $user->api_token);
    }

//    public function testUserWithNullToken()
//    {
//        // Simulating login
//        $user = factory(\App\Model\User::class)->create(['email' => 'user@test.com']);
//        $token = $user->generateToken();
//        $headers = ['Authorization' => "Bearer $token"];
//
//        // Simulating logout
//        $user->api_token = null;
//        $user->save();
//
//        $this->json('get', '/api/articles', [], $headers)->assertStatus(401);
//    }
}