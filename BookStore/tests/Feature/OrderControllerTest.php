<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPlaceOrderApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
            "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('post', '/api/placeOrder',[
                'cartId_json' => [3,4],
                'address_id' => 2
        ]);
        $response->assertStatus(500);
    }

    public function testCancelOrderApi()//////////
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('post', '/api/cancelOrder',[
                'order_id'=>'1'
        ]);
        $response->assertStatus(200);
    }

}