<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    public function register(RegisterRequest $request)
    {
        $onlyRequest = $request->only(['username','email', 'password','mobile','token']);
        $onlyRequest['password'] = bcrypt(request('password'));

        $user = User::create($onlyRequest);
        return new UserResource($user);
    }
}
