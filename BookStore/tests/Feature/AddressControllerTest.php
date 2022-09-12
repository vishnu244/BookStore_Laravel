<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AddressControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testAddAddressApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
            "Authorization" =>'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('post', '/api/addAddress',[
                "address" => 'Kanuru',
                "landmark" => "Sivalayam",
                "city" => "Vijayawada",
                "state" => "Andhra Pradesh",
                "pincode" => "456789",
                "address_type" => "Home"
        ]);
        $response->assertStatus(201);
    }

    public function testUpdateAddressApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
            "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('post', '/api/updateAddressById',[
                'id'=>2,
                "address" => 'Kanuru',
                "landmark" => "Sivalayam",
                "city" => "Hyderabad",
                "state" => "Telangana",
                "pincode" => "987655",
                "address_type" => "Home"
        ]);
        $response->assertStatus(201);
    }

    public function testGetAllAddressesApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
            "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('get', '/api/displayAllAddresses',[
               
        ]);
        $response->assertStatus(201);
    }

    public function testDeleteAddressApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('delete', '/api/deleteAddressByID',[
               'id'=>2
        ]);
        $response->assertStatus(201);
    }
}