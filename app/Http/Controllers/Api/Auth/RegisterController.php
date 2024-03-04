<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\User;
use App\Notifications\UserRegisterNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function __invoke(Request $request): \Illuminate\Http\JsonResponse
    {
        $request->validate([
            'name'             => 'required',
            'username'         => 'required',
            'email'            => 'required|email',
            'password'         => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::query()->create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'username' => $request->username,
        ]);

        $user->notify(new UserRegisterNotification(Str::random(60)));

        $response = (new LoginController)($request);

        return response()->json($response->getOriginalContent());
    }
}
