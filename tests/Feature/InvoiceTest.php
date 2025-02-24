<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class InvoiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    public function test_invoice_create_qilish(): void
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
            "phone"=> '+998'.rand(90,99).rand(10000000,9999999),
            "active" => true,
        ]);

        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->post('/api/invoice/create',
        [
               "partner_id" => $partner->id,
               "date_time" => now(),
               "total_value" => 10000,
               "comment" => Str::random(10),
               "type" => Arr::random(["input", "output"]),
               "status" => "continue",
           ]);

       $response->assertStatus(201);
       DB::rollBack();
    }


}
