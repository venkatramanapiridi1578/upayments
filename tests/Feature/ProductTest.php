<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Product;
use App\User;

class ProductTest extends TestCase
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

    public function testProductCreatedSuccessfully()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');   
        $productData = [
            "name" => "Product-1",
            "price" => 25,
            "category" => "Category-1",
            "description" => "Test Description",
            "avatar" => "avatar1"
        ];

        $this->json('POST', 'api/product', $productData, ['Accept' => 'application/json'])
            ->assertStatus(201)
            ->assertJsonStructure([
                "product" => [
                    'name',
                    'price',
                    'category',
                    'description',
                    'avatar',
                    'id',
                    'created_at',
                    'updated_at',
                ],               
                "message"
            ]);
    }
   
}
