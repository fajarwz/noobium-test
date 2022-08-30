<?php

namespace App\Http\Controllers;

use App\Models\User;
use Socialite;
use JWTAuth;

class GoogleAuthController extends Controller
{
    public function getUrl()
    {
        return response()->json([
            'meta' => [
                'code' => 200,
                'status' => 'success',
                'message' => 'Google Sign In Url fetched successfully.',
            ],
            'data' => [
                'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
            ],
        ]);
    }

    public function callback()
    {
        $user = Socialite::driver('google')->with(['access_type' => 'offline'])->stateless()->user();

        if (!$user)
        {
            return response()->json([
                'meta' => [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'Login with Google failed.',
                ],
                'data' => [],
            ], 500);
        }

        $finduser = User::where('social_id', $user->id)->first();
        $token = '';

        if ($finduser)
        {
            $token = auth()->login($finduser);

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Signed in successfully.',
                ],
                'data' => [
                    'user' => [
                        'name' => $finduser->name,
                        'email' => $finduser->email,
                        'picture' => $finduser->picture,
                    ],
                    'access_token' => [
                        'token' => $token,
                        'type' => 'Bearer',
                        'expires_in' => auth()->factory()->getTTL() * 60,
                    ],
                ],
            ]);
        }
        else
        {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => bcrypt('my-google'),
                'picture' => $user->avatar,
                'social_id' => $user->id,
                'social_type' => 'google',
            ]);

            $token = auth()->login($newUser);

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Signed in successfully.',
                ],
                'data' => [
                    'user' => [
                        'name' => $newUser->name,
                        'email' => $newUser->email,
                        'picture' => $newUser->picture,
                    ],
                    'access_token' => [
                        'token' => $token,
                        'type' => 'Bearer',
                        'expires_in' => auth()->factory()->getTTL() * 60,
                    ],
                ],
            ]);
        }

        return response()->json([
            'meta' => [
                'code' => 500,
                'status' => 'error',
                'message' => 'Login with Google failed.',
            ],
            'data' => [],
        ], 500);
    }

    public function withToken($token)
    {
        $tokenParts = explode(".", $token);  
        
        $tokenPayload = base64_decode($tokenParts[1]);
        
        $jwtPayload = json_decode($tokenPayload, true);

        $finduser = User::where('social_id', $jwtPayload['sub'])->first();
        $token = '';

        if ($finduser)
        {
            $token = auth()->login($finduser);

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Signed in successfully.',
                ],
                'data' => [
                    'user' => [
                        'name' => $finduser->name,
                        'email' => $finduser->email,
                        'picture' => $finduser->picture,
                    ],
                    'access_token' => [
                        'token' => $token,
                        'type' => 'Bearer',
                        'expires_in' => auth()->factory()->getTTL() * 60,
                    ],
                ],
            ]);
        }
        else
        {
            $newUser = User::create([
                'name' => $jwtPayload['name'],
                'email' => $jwtPayload['email'],
                'password' => bcrypt('my-google'),
                'picture' => $jwtPayload['picture'],
                'social_id' => $jwtPayload['sub'],
                'social_type' => 'google',
            ]);

            $token = auth()->login($newUser);

            return response()->json([
                'meta' => [
                    'code' => 200,
                    'status' => 'success',
                    'message' => 'Signed in successfully.',
                ],
                'data' => [
                    'user' => [
                        'name' => $newUser->name,
                        'email' => $newUser->email,
                        'picture' => $newUser->picture,
                    ],
                    'access_token' => [
                        'token' => $token,
                        'type' => 'Bearer',
                        'expires_in' => auth()->factory()->getTTL() * 60,
                    ],
                ],
            ]);
        }

        return response()->json([
            'meta' => [
                'code' => 500,
                'status' => 'error',
                'message' => 'Login with Google failed.',
            ],
            'data' => [],
        ], 500);
    }
}
