<?php

namespace Tests\Feature;

use App\Models\category;
use App\Models\Market;
use App\Models\Product_variant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tests\TestCase;

class ProductVariantTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_product_variant_create_qilish(): void
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

        $category = category::create([
                "title" => Str::random(10),
                "active" => true,
                "market_id" => 1 //$market->id
        ]);



        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->post('/api/product/create',
        [
               "title" => Str::random(10),
               "category_id" => $category->id,
               "active" => true,
           ]);

       $response->assertStatus(201);
    }

    public function test_product_variant_show_qilish()
    {
        $user = User::create([
            'full_name' => Str::random(10),
            'username' => Str::random(10),
            'password' => Hash::make(123)
        ]);
        $token = $user->createToken('auth-token')->plainTextToken;



        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->get('/api/product/show');


       $response->assertStatus(200);


    }

    public function test_product_variant_changeActive_qilish()
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

        Log::error(json_encode($market, JSON_PRETTY_PRINT));

        $category = category::create([
                "title" => Str::random(10),
                "active" => true,
                "market_id" => 1 //$market->id
        ]);

        $product = Product_variant::create([
            "title" => Str::random(10),
            "category_id" => $category->id,
            "active" => true,
        ]);

           $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->put('/api/product/changeActive/'.$product->id,
           [
               $product->active =! $product->active,
               $product->save()
           ]);

           $response->assertStatus(200);
    }

}




