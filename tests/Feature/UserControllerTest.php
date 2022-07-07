<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_login()
    {
        $response = $this->post(route('login'), [
            'email' => 'ekacandrika@gmail.com',
            'password' => 'password'
        ]);

        $response->assertStatus(200);
    }

    public function test_register()
    {

        $response = $this->post(route('register'), [
            'name' => 'ekacandrika',
            'email' => 'eka_candrika@gmail.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(201);
    }
}
