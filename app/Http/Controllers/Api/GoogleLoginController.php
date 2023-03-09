<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class GoogleLoginController extends Controller
{
    use ApiResponse;

    public function redirect()
    {
        return $this->successResponse('success', [
            'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl()
        ]);
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $findUser = User::where('google_id', $googleUser->id)->first();

            if ($findUser) {
                $token = Auth::login($findUser);
            } else {
                $newUser = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id'=> $googleUser->id,
                    'avatar' => $googleUser->avatar,
                ]);

                $token = Auth::login($newUser);
            }

            return $this->successResponse('success', [
                'access_token' => $token,
                'token_type' => 'bearer',
//                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => Auth::user()
            ]);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage());
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
