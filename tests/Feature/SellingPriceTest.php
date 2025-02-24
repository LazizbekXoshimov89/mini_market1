<?php

namespace Tests\Feature;

use App\Models\category;
use App\Models\Invoice;
use App\Models\Market;
use App\Models\Partner;
use App\Models\Product_variant;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Tests\TestCase;

class SellingPriceTest extends TestCase
{
    /**
     * A basic feature test example.
     */


    public function test_SellingPrice_create_qilish(): void
    {
        DB::beginTransaction();
        $user = User::create([
            'full_name' => Str::random(10),
            'username' => Str::random(10),
            'password' => Hash::make(123)
        ]);
        $token = $user->createToken('auth-token')->plainTextToken;

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

        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])->post(
            '/api/sellingPrice/create',
            [
                "product_variant_id" => $product->id,
                "price" => "5000",
                "start_date"=> "1900-01-01",
                "end_date"=> "1900-01-01",
                "active"=> $product->active,
                "market_id"=> 1,
            ]
        );

        //Log::error(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE ));
        $response->assertStatus(201);

        DB::rollBack();
    }

}
