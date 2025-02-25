<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\UserInterface;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Product_variant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{
    public function __construct(
        private User $user,
        private Hash $hash,
        private Product_variant $product_variant
    ) {}

    public function register(UserRegisterRequest $request)
    {
        $user = $this->user::create([
            "full_name" => $request->full_name,
            "username" => $request->username,
            "password" => $this->hash::make($request->password),
        ]);
        return response()->json(["message" => "foydalanuvchi yaratildi"], 201);
    }

    public function login(UserLoginRequest $request)
    {
        if (strlen($request->username) == 0 || strlen($request->password) == 0)
            return 'error';

        $user = $this->user::where('username', $request->get('username'))->first();
        if (!$user)
            return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);
        if (!$this->hash::check($request->get('password'), $user->password))
            return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);

        $token = $user->createToken('auth-token')->plainTextToken;

        $this->user::where('id', $user->id)->update([
            "remember_token" => $token,
        ]);

        return response()->json(["token" => "$token"], 201);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user)
            return response()->json(['message' => 'Foydalanuvchi topilmadi'], 404);
        return response()->json($user, 200);
    }

    public function update(UserUpdateRequest $request, string $id)
    {
        $authUser = Auth::user();
        if ($authUser->id == $id) {

            User::where('id', $id)
                ->update([
                    'password' => $request->password,
                    'full_name' => $request->full_name,
                ]);
            return response()->json(['message' => 'Ma\'lumot muvofaqqiyatli yangilandi!'], 200);
        } else {
            // Error message to'g'rilansin
            return response()->json(['message' => 'Boshqa foydalanuvchining ma\'lumotlarini o\'zgartira olmaysiz!'], 403);
        }
    }
}
