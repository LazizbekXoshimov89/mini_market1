<?php

namespace Tests\Feature;

use App\Models\Market;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    


     public function test_category_create_qilish(): void
    {
        $user = User::create([
            'full_name' => Str::random(10),
            'username' => Str::random(10),
            'password' => Hash::make(123)
        ]);
        $token = $user->createToken('auth-token')->plainTextToken;

        $market = Market::create([
            'title' => Str::random(10),
            'adress' => Str::random(50),
            'active' => true,
            'start_date' => date('Y-m-d'),
            'user_id' => $user->id
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->post('/api/category/create',
         [
                "title" => Str::random(10),
                "active" => true,
                "market_id" => 1 //$market->id
            ]);

        $response->assertStatus(201);
    }



}
