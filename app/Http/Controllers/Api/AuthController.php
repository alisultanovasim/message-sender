<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @OA\Post (
     *     path="/api/auth/register",
     *     tags={"Auth"},
     *     summary="Register to continue",
     *     @OA\RequestBody (
     *     required=true,
     *     @OA\JsonContent(
     *     @OA\Examples(
     *        summary="Register",
     *        example = "Register",
     *       value = {
     *           "name": "Penah",
     *           "email": "penah@gmail.com",
     *           "password": "penah122",
     *           "password_confirmation": "penah122",
     *           "c_id": "12",
     *         },
     *      )
     *     ),
     *     @OA\Schema (
     *     type="integer",
     * )
     * ),
     *     @OA\Response(
     *     response=201,
     *     description="User registered",
     * ),
     * ),
     */
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed',
            'c_id'=>'required|integer|min:1'
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);
        $user->update(['last_active'=>date('Y-m-d H:i')]);

        $accessToken = $user->createToken('authToken')->accessToken;

        return response([ 'user' => $user, 'access_token' => $accessToken]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     * @OA\Post (
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     summary="Login to continue",
     *     @OA\RequestBody (
     *     required=true,
     *     @OA\JsonContent(
     *     @OA\Examples(
     *        summary="Login",
     *        example = "Login",
     *       value = {
     *           "email": "penah@gmail.com",
     *           "password": "penah122"
     *         },
     *      )
     *     ),
     *     @OA\Schema (
     *     type="integer"
     * )
     * ),
     *     @OA\Response(
     *     response=200,
     *     description="User registered",
     *     @OA\JsonContent(
     *     type="object",
     *     @OA\Examples(
     *        summary="Response Example 1",
     *        example = "Response Example 1",
     *       value = {
     *           "user": {
                            "id": "7",
                            "name": "Penah",
                            "email": "penah@gmail.com",
                            "email_verified_at": "null",
                            "last_active": "2022-11-20 16:43",
                            "created_at": "2022-11-18T22:03:22.000000Z",
                            "updated_at": "2022-11-20T12:43:22.000000Z",
                            "c_id": "1"
                            },
                    "access_token": "newtokenstring"
     *         },
     *      ),
     *     @OA\Examples(
     *        summary="Response Example 2",
     *        example = "Response Example 2",
     *       value = {
     *           "user": {
                            "id": "7",
                            "name": "Penah",
                            "email": "penah@gmail.com",
                            "email_verified_at": "null",
                            "last_active": "2022-11-20 16:43",
                            "created_at": "2022-11-18T22:03:22.000000Z",
                            "updated_at": "2022-11-20T12:43:22.000000Z",
                            "c_id": "1"
                            },
                    "access_token": "newtokenstring"
                     *         },
     *      )
     * )
     * ),
     * ),
     */

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            return response()->json(['message' => 'Invalid Credentials'],Response::HTTP_BAD_REQUEST);
        }
        auth()->user()->update(['last_active'=>date('Y-m-d H:i')]);

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return response(['user' => auth()->user(), 'access_token' => $accessToken]);

    }
}
