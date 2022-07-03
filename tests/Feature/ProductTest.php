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
    public function testRetrieveProductSuccessfully()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $product = factory(Product::class)->create([
            "name" => "Product-1",
            "price" => 25,
            "category" => "Category-1",
            "description" => "Test Description",
            "avatar" => "avatar1"
        ]);

        $this->json('GET', 'api/product/' . $product->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200)
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
    public function testProductUpdatedSuccessfully()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $product = factory(Product::class)->create([
            "name" => "Product-1",
            "price" => 25,
            "category" => "Category-1",
            "description" => "Test Description",
            "avatar" => "avatar1"
        ]);

        $payload = [
            "name" => "Product-2",
            "price" => 50,
            "category" => "Category-2",
            "description" => "Test Description 2 ",
            "avatar" => "avatar2"
        ];

        $this->json('PATCH', 'api/product/' . $product->id , $payload, ['Accept' => 'application/json'])
            ->assertStatus(200)
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
    public function testDeleteProduct()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $product = factory(Product::class)->create([
            "name" => "Product-1",
            "price" => 25,
            "category" => "Category-1",
            "description" => "Test Description",
            "avatar" => "avatar1"
        ]);

        $this->json('DELETE', 'api/product/' . $product->id, [], ['Accept' => 'application/json'])
            ->assertStatus(200);
    }



    public function testProductListedSuccessfully()
    {

        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        factory(Product::class)->create([
            "name" => "Product-1",
            "price" => 25,
            "category" => "Category-1",
            "description" => "Test Description",
            "avatar" => "avatar1"
        ]);

        factory(Product::class)->create([
            "name" => "Product-2",
            "price" => 15,
            "category" => "Category-2",
            "description" => "Test Description 2",
            "avatar" => "avatar2"
        ]);

        $this->json('GET', 'api/product', ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                "products" => [
                        [
                            'name',
                            'price',
                            'category',
                            'description',
                            'avatar',
                            'id',
                            'created_at',
                            'updated_at',
                        ],
                        [
                            'name',
                            'price',
                            'category',
                            'description',
                            'avatar',
                            'id',
                            'created_at',
                            'updated_at',
                        ]
                    ],               
                "message"
            ]);
    }

   
}
