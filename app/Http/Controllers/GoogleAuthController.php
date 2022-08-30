<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class GoogleAuthController extends Controller
{
    public function signIn(Request $request)
    {
        $request = $request->json()->all();

        $tokenParts = explode('.', $request['token']);

        $tokenPayload = base64_decode($tokenParts[1]);

        $jwtPayload = json_decode($tokenPayload, true);

        if($jwtPayload === null)
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

        $finduser = User::where('social_id', $jwtPayload['sub'])->first();

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
}
