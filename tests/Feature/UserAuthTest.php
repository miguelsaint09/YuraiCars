<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserAuthTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_can_access_login_screen(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
