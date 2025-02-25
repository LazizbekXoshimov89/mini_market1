<?php

namespace App\Http\Interfaces;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Requests\UserUpdateRequest;

interface UserInterface
{
    public function register(UserRegisterRequest $request);

    public function login(UserLoginRequest $request);

    public function show(string $id);

    public function update(UserUpdateRequest $request, string $id);
}
