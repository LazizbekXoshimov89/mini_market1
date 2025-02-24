<?php

namespace Tests\Feature;

use App\Models\Partner;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class PartnerTest extends TestCase
{
    /**
     * A basic feature test example.
     */


    public function test_partner_create_qilish(): void
    {
        DB::beginTransaction();
        $user = User::create([
            'full_name' => Str::random(10),
            'username' => Str::random(10),
            'password' => Hash::make(123)
        ]);
        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->post('/api/partner/create',
        [
               "title" => Str::random(10),
               "phone"=> '+998'.rand(90,99).rand(10000000,9999999),
               "active" => true,
           ]);

       $response->assertStatus(201);
       DB::rollback();
    }

    public function test_partner_show_qilish(): void
    {
        $user = User::create([
            'full_name' => Str::random(10),
            'username' => Str::random(10),
            'password' => Hash::make(123)
        ]);
        $token = $user->createToken('auth-token')->plainTextToken;

        $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->get('/api/partner/show');

         $response->assertStatus(200);
    }

    public function test_Partner_changeActive_qilish()
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

           $response = $this->withHeaders(['Authorization' => 'Bearer '. $token])->put('/api/partner/changeActive/'.$partner->id,
           [
               $partner->active =! $partner->active,
               $partner->save()
           ]);

      $response->assertStatus(200);
       DB::rollback();
    }
}
