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
            "user_id" =>$user->id,
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
    public function testDeleteItemfromCart()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $cart = factory(Cart::class)->create([
            "session_id" => rand(10000,99999),
            "product_id" => 1,
            "user_id" =>$user->id,
            "qty" => 2
        ]);

        $this->json('DELETE', 'api/cart/' . $cart->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200);
    }
    public function testEditCartItemSuccessfully()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $cart = factory(Cart::class)->create([
            "session_id" => rand(10000,99999),
            "product_id" => 1,
            "user_id" =>$user->id,
            "qty" => 2
        ]);

        $payload = [
            "session_id" => rand(10000,99999),
            "product_id" => 5,
            "user_id" =>$user->id,
            "qty" => 2
        ];

        $this->json('PATCH', 'api/cart/' . $cart->id , $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
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

    public function testCartItemsListedSuccessfully()
    {

        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        
        factory(Cart::class)->create([
            "session_id" => rand(10000,99999),
            "product_id" => 1,
            "user_id" =>$user->id,
            "qty" => 2
        ]);

        factory(Cart::class)->create([
            "session_id" => rand(10000,99999),
            "product_id" => 2,
            "user_id" =>$user->id,
            "qty" => 4
        ]);

        $this->json('GET', 'api/cart', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "carts" => [
                        [
                            'session_id',
                            'product_id',
                            'user_id',
                            'qty',                    
                            'id',
                            'created_at',
                            'updated_at',
                        ],
                        [
                            'session_id',
                            'product_id',
                            'user_id',
                            'qty',                    
                            'id',
                            'created_at',
                            'updated_at',
                        ]
                    ],               
                "message"
            ]);
    }
}
