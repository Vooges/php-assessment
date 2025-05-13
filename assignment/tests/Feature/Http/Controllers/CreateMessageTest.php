<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateMessageTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee(config('app.name'));
        $response->assertSee('Plaats hier je bericht');
        $response->assertSee('Versleutel bericht');
    }
}
