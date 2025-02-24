<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(UserRegisterRequest $request)
    {
        $user = User::create([
            "full_name" => $request->full_name,
            "username" => $request->username,
            "password" => Hash::make($request->password),
        ]);
        return response()->json(["message" => "foydalanuvchi yaratildi"], 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(UserLoginRequest $request)
    {
        if (strlen($request->username) == 0 || strlen($request->password) == 0)
            return 'error';

        $user = User::where('username', $request->get('username'))->first();
        if (!$user)
            return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);
        if (!Hash::check($request->get('password'), $user->password))
            return response()->json(['message' => 'Login yoki Parol noto\'g\'ri'], 400);

        $token = $user->createToken('auth-token')->plainTextToken;

        User::where('id', $user->id)->update([
            "remember_token" => $token,
        ]);

        return response()->json(["token" => "$token"], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::find($id);
        if (!$user)
            return response()->json(['message' => 'Foydalanuvchi topilmadi'], 404);
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
