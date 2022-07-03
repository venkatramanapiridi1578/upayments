<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Cart;
use App\User;

class CartTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function testAddtoCartSuccessfully()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');   
        $cartData = [
            "session_id" => rand(10000,99999),
            "product_id" => 1,
            "qty" => 2
        ];

        $this->json('POST', 'api/cart', $cartData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "cart" => [
                    'session_id',
                    'product_id',
                    'user_id',
                    'qty',                    
                    'id',
                    'created_at',
                    'updated_at',
                ],               
                "message"
            ]);
    }
}
