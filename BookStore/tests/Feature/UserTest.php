<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    //Testcase case for Successful registration
    public function testregistration()/////////////////////
    {
        $response = $this->json('POST', '/api/registration', [
            'role' => 'Admin',            
            'first_name' => 'Vishnu',
            'last_name' => 'Vardhan',  
            'phoneNumber' => '5678987654',
            'email' => 'abc123@gmail.com',
            'password' => 'Vishnu@123',   
            'confirmPassword' => 'Vishnu@123'    
        ]);
        $response->assertStatus(201);
    }

    // Testcase for successfull Login
    public function test_login()
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('POST', '/api/login',
            [
                "email" => "vishnu@gmail.com",
                "password" => "Vishnu@123"
            ]
        );
        $response->assertStatus(200);
    }

    // Testcase for successfull Logout
    public function test_Logout()//////////////////////
    {
        $response = $this->withHeaders([
            'Content-Type' => 'Application/json',
        ])
        ->json('POST', '/api/logout', [
            "token" => '6|1hJav49MDuSQJW3w6UJ6TOUwN2TudJdjQpAZiBFP'
        ]);

        $response->assertStatus(200)->assertJson(['message' => 'Logged Out Successfully']);
    }
}
