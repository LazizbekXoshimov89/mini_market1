<?php

namespace App\Http\Controllers;

use App\Http\Interfaces\UserInterface;
use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(
        private UserInterface $userRepository
    )
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function register(UserRegisterRequest $request)
    {
        return $this->userRepository->register($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function login(UserLoginRequest $request)
    {
        return $this->userRepository->login($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->userRepository->show($id);
        // $user = User::find($id);
        // if (!$user)
        //     return response()->json(['message' => 'Foydalanuvchi topilmadi'], 404);
        // return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {

        return $this->userRepository->update( $request,  $id);
        // $authUser = Auth::user();
        // if ($authUser->id == $id) {

        //     User::where('id', $id)
        //         ->update([
        //             'password' => $request->password,
        //             'full_name' => $request->full_name,
        //         ]);
        //     return response()->json(['message' => 'Ma\'lumot muvofaqqiyatli yangilandi!'], 200);
        // } else {
        //     // Error message to'g'rilansin
        //     return response()->json(['message' => 'Boshqa foydalanuvchining ma\'lumotlarini o\'zgartira olmaysiz!'], 403);
        // }
    }
}
