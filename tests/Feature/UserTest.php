<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_register_qilish(): void
    {
        $response = $this->post('/api/user/register', [
            'full_name' => Str::random(10),
            'username' => Str::random(10),
            'password' => Str::random(10)
        ]);
        $response->assertStatus(201);
    }

    public function test_user_login_qilish() {
        $user = User::create([
            'full_name' => Str::random(10),
            'username' => Str::random(10),
            'password' => Hash::make(123)
        ]);
        $response = $this->post('/api/user/login', [
            'username' => $user->username,
            'password' => '123'
        ]);
        $response->assertStatus(201);
    }

    public function test_user_update_qilish() {
        $user = User::create([
            'full_name' => Str::random(10),
            'username' => Str::random(10),
            'password' => Hash::make(123)
        ]);
        $token = $user->createToken('auth-token')->plainTextToken;
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
        ->put('/api/user/update/'. $user->id, [
            'full_name' => Str::random(20),
            'password' => Hash::make(123)
        ]);
        $response->assertStatus(200);
    }

    public function test_user_update_qilish_integration() {
        $user = User::create([
            'full_name' => Str::random(10),
            'username' => Str::random(10),
            'password' => Hash::make(123)
        ]);
        $token = $user->createToken('auth-token')->plainTextToken;
        $newFullname = Str::random(20);
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->put('/api/user/update/'. $user->id, [
            'full_name' => $newFullname,
            'password' => Hash::make(123)
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'full_name' => $newFullname
        ]);
        $response->assertStatus(200);
    }
}
