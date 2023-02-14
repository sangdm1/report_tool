<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;


class GoogleLoginController extends Controller
{
    public function redirect()
    {
        return Response::json([
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    public function callback()
    {
        try {
            $googleUser  = Socialite::driver('google')->stateless()->user();

            $finduser = User::where('google_id', $googleUser->id)->first();

            if ( $finduser ) {
                $token = Auth::login($finduser);
            } else {
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id'=> $googleUser->id,
                    'avatar' => $googleUser->avatar,
                ]);

                $token = Auth::login($newUser);
            }
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                // 'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => Auth::user()
            ]);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function fillInformation(Request $request ): JsonResponse
    {
        $password = $request->post('password');
        $display_name = $request->post('display_name');
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'string', 'min:8'],
            'display_name' => ['required', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 404);
        }

        $id = Auth::id();
        $user = User::where('id',$id)->first();
        $user->password = Hash::make($password);
        $user->display_name = $display_name;
        $user->save();
        return response()->json([
            'message' => 'Base successfully fill password',
            'user' => $user,
        ]);
    }
}
