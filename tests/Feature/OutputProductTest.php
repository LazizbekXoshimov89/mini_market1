<?php

namespace Tests\Feature;

use App\Models\category;
use App\Models\Invoice;
use App\Models\Partner;
use App\Models\Product_variant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class OutputProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_OutputProduct_qilish(): void
    {
        DB::beginTransaction();
        $user = User::create([
            'full_name' => Str::random(10),
            'username' => Str::random(10),
            'password' => Hash::make(123)
        ]);
        $token = $user->createToken('auth-token')->plainTextToken;

        $partner = Partner::create([
            "title" => Str::random(10),
            "phone" => '+998' . rand(90, 99) . rand(10000000, 9999999),
            "active" => true,
        ]);

        $invoice = Invoice::create([
            "partner_id" => $partner->id,
            "date_time" => now(),
            "total_value" => 0,
            "comment" => Str::random(10),
            "type" => "output",
            "status" => "continue",
        ]);

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
            '/api/outputProduct/create',
            [
                'invoice_id' => $invoice->id,
                'comment' => Str::random(10),
                'products' => [
                    [
                        "product_variant_id" => $product->id,
                        "count" => 1,
                    ]
                ]
            ]
        );


    $response->assertStatus(200);

        DB::rollBack();
    }
}
