<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Cookie;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthController
 * @package App\Http\Controllers\Api
 */
class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function register(RegisterRequest $request): Response
    {
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name'  => $request->input('last_name'),
            'email'      => $request->input('email'),
            'password'   => Hash::make($request->input('password')),
        ]);

        return response(new UserResource($user), Response::HTTP_CREATED);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function login(Request $request): Response
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response([
                'error' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        /** @var User $user */
        $user = Auth::user();

        $jwt = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $jwt, 60 * 24);

        return response([
            'jwt' => $jwt
        ])->withCookie($cookie);
    }

    /**
     * @return Application|ResponseFactory|\Illuminate\Http\Response
     */
    public function logout(): Response
    {
        $cookie = Cookie::forget('jwt');

        return response([
            'message' => 'success'
        ])->withCookie($cookie);
    }

    /**
     * @param Request $request
     * @return UserResource
     */
    public function user(Request $request): UserResource
    {
        $user = $request->user();
        return new UserResource($user);
    }

}
