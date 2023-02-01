<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;

class ApiUserController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            // 'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }


    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized']);
        }

        return $this->createNewToken($token);
    }

    public function setRole(Request $request){
        $user = Auth::user();
        $userId = Auth::id();
        $userRole = $user->role;
        $memId = $request->input('id');
        $newMemRole = $request->input('role');
        $memUser = User::where('id', $memId)->first();
        $oldMemRole = $memUser->role;
       
        if($userRole == 1){
            if($userId != $memId && $newMemRole != 1){
                return $this->handleSetRole($memUser, $newMemRole);
            }
        }else if($userRole == 2){
            if(($userId != $memId) && !in_array($newMemRole, [1,2]) && !in_array($oldMemRole, [1,2])){
                return $this->handleSetRole($memUser, $newMemRole);
            }
        }else if($userRole == 3){
            if(($userId != $memId) && !in_array($newMemRole, [1,2,3]) && !in_array($oldMemRole, [1,2,3])){
                return $this->handleSetRole($memUser, $newMemRole);
            }
        }

        return response()->json([
            'message' => 'User can not update role',
        ]);
    }

    protected function handleSetRole($memUser, $newMemRole){
        $memUser->role = $newMemRole;
        $memUser->save();
        return response()->json([
            'message' => 'User successfully update role',
            'user' => $memUser,
        ]);
    }

    public function users()
    {
        $user = Auth::user();
        if($user->role == 1){
            $users = User::all();
            return response()->json($users); 
        }
    }
}
