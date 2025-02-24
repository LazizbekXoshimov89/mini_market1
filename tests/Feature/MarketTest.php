<?php

namespace Tests\Feature;

use App\Models\Market;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class MarketTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_market_create_qilish(): void
    {
        $user = User::create([
            'full_name' => Str::random(10),
            'username' => Str::random(10),
            'password' => Hash::make(123)
        ]);
        $token = $user->createToken('auth-token')->plainTextToken;
        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->post('/api/market/create',
         [
                "title" => Str::random(10),
                "adress" => Str::random(50),
                "active" => 1,
                "start_date" => date('Y-m-d'),
                "user_id" => $user->id ]);
        $response->assertStatus(201);
    }



    public function test_market_show_qilish(): void
    {
        $user = User::create([
            'full_name' => Str::random(10),
            'username' => Str::random(10),
            'password' => Hash::make(123)
        ]);
        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->post('/api/market/create',
         [
                "title" => Str::random(10),
                "adress" => Str::random(50),
                "active" => 1,
                "start_date" => date('Y-m-d'),
                "user_id" => $user->id ]);
        $response = $this->get('/api/market/show');

        $response->assertStatus(200);
    }

    public function test_market_changeActive_qilish()
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
            'user_id' => $user->id ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->put('/api/market/changeActive/'.$market->id,
        [
            $market->active =! $market->active,
            $market->save()
        ]);

        $response->assertStatus(200);
    }
    
}
