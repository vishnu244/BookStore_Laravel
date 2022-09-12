<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAddBookTocartApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('post', '/api/addBookTocart',[
            'book_id'=>1,
            'book_quantity'=>1
        ]);
        $response->assertStatus(200);
    }

    public function testUpdateBookInCartApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" =>'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('post', '/api/updateBookInCart',[
            'id'=>4,
            'book_id'=>1,
            'book_quantity'=>2
        ]);
        $response->assertStatus(200);
    }

    public function testUpdateQuantityInCartApi()//////////////////
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer 6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('post', '/api/updateQuantityInCart',[
            'id'=>1,
            'book_quantity'=>1
        ]);
        $response->assertStatus(200);
    }

    public function testGetAllBooksApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('get', '/api/displayAllBooksInCart',[
            'user_id'=>1
        ]);
        $response->assertStatus(201);
    }
 
    public function testDeleteBookFromCartApi()/////////////////
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('delete', '/api/removeBookFromCart',[
            'id'=>4
        ]);
        $response->assertStatus(200);
    }
}