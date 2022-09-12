<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WishlistControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAddBookToWishlistApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('post', '/api/addBookToWishlist',[
            'cart_id'=>1,
            'book_id'=>3
        ]);
        $response->assertStatus(200);
    }

    public function testDisplayBooksFromWishlists()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('get', '/api/displayBooksFromWishlists',[
        ]);
        $response->assertStatus(201);
    }

    public function testRemoveBookFromWishlists()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('delete', '/api/removeBookFromWishlists',[
            'id'=>3
        ]);
        $response->assertStatus(201);
    }

}