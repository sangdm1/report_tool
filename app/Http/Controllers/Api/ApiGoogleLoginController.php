<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class ApiGoogleLoginController extends Controller
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
}
