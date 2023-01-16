<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class GoogleLoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
        
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function callback()
    {
        try {
            $user = Socialite::driver('google')->user();
       
            $finduser = User::where('google_id', $user->id)->first();
       
            if ( $finduser ) {
                if(!Auth::check()){
                    Auth::login($finduser);
                }
                if(empty($finduser->password)){
                    return redirect()->route('login.google-show-fill-infomation');
                }
      
                return redirect()->intended('/');
       
            } else {
                $newUser = User::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id'=> $user->id,
                    'avatar' => $user->avatar,
                ]);
      
                Auth::login($newUser);
      
                return redirect()->route('login.google-show-fill-infomation');
            }
      
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

     /**
     * Show fill infomation form.
     *
     * @return void
     */
    public function showFillInfomation()
    {
        return view('auth.fill');
    }

     /**
     * Fill infomation.
     *
     * @return void
     */
    public function fillInfomation(Request $request )
    {
        $password = $request->post('password');
        $display_name = $request->post('display_name');
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'display_name' => ['required', 'string', 'max:255'],
        ]);
        if(Auth::check()){
            $id = Auth::id();
            $user = User::where('id',$id)->first();
            $user->password = Hash::make($password);
            $user->display_name = $display_name;
            $user->save();
        }

        return redirect()->route('home');
    }
}