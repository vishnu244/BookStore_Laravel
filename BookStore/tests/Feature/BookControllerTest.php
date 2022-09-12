<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAddBook()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
            "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('POST', '/api/addBook',[
            'name' => 'Vishnu',
            'description' => 'Description',
            'image' => google.PNG,
            'author' => 'vardhan', 
            'price' => 114, 
            'quantity' => 1,
            
        ]);
        $response->assertStatus(201);
    }

    public function testDisplayBooks()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('get', '/api/displayBooks',[
            
        ]);
        $response->assertStatus(201);
    }

    public function testDeleteBookApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('delete', '/api/deleteBookID/1',[
            
        ]);
        $response->assertStatus(201);
    }

    public function testSearchBookApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('get', '/api/searchBook',[
            'value'=>"manoj"
        ]);
        $response->assertStatus(405);
    }

    public function testSortOnPriceLowToHigh()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
            "Authorization" => 'Bearer 6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('get', '/api/sortByPriceLowToHigh',[
            
        ]);
        $response->assertStatus(201);
    }

    public function testSortOnPriceHighToLow()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
            "Authorization" => 'Bearer 6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('get', '/api/sortByPriceHighToLow',[
            
        ]);
        $response->assertStatus(201);
    }

    public function testUpdateQuantityById()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" =>'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('post', '/api/updateQuantityById',[
            'id'=>2,
            'quantity'=>20
        ]);
        $response->assertStatus(200);
    }
}