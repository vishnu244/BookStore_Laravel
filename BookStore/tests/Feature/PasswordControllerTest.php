<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PasswordControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testForgotPasswordApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" => 'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('post', '/api/forgotPassword',[
            'email'=>"mightyvishnumec244@gmail.com"
        ]);
        $response->assertStatus(201);
    }

    public function testResetApi()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Appilication/json',
             "Authorization" =>'Bearer  6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
            ])->json('post', '/api/resetPassword',[
            'email'=>"mightyvishnumec244@gmail.com",
            "password"=>"Vishnu@123",
            "token"=>"5x7xfgGhlV"
        ]);
        $response->assertStatus(200);
    }
}