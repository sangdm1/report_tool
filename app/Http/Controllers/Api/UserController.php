<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Validator;

use App\Http\Requests\User\ListUserRequest;

use App\Services\User\ListUserService;

use App\Models\User;

use App\Enums\UserRole;


class UserController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @param ListUserRequest $request
     * @return JsonResponse
     */
    public function index(ListUserRequest $request)
    {
        return resolve(ListUserService::class)->setData($request->all())->handle();
    }

//    /**
//     * Update the specified resource in DB.
//     *
//     * @param CreateNewRequest $request
//     * @param int $id
//     * @return Response
//     */
//    public function update(CreateNewRequest $request, $id)
//    {
//        return resolve(UpdateNewService::class)->setRequest($request)->setNewById($id)->handle();
//    }

    public function setRole(Request $request)
    {
        $user = Auth::user();
        $userId = Auth::id();
        $userRole = $user->role;
        $memId = $request->input('id');
        $newMemRole = $request->input('role');
        $memUser = User::where('id', $memId)->first();
        $oldMemRole = $memUser->role;

        if ($userRole == UserRole::ADMIN->value) {
            if ($userId != $memId && $newMemRole != UserRole::ADMIN->value) {
                return $this->handleSetRole($memUser, $newMemRole);
            }
        } else if ($userRole == UserRole::PM->value) {
            if (($userId != $memId) && !in_array($newMemRole, [UserRole::ADMIN->value, UserRole::PM->value]) && !in_array($oldMemRole, [UserRole::ADMIN->value, UserRole::PM->value])) {
                return $this->handleSetRole($memUser, $newMemRole);
            }
        } else if ($userRole == UserRole::LEADER->value) {
            if (($userId != $memId) && !in_array($newMemRole, [UserRole::ADMIN->value, UserRole::PM->value, UserRole::LEADER->value]) && !in_array($oldMemRole, [UserRole::ADMIN->value, UserRole::PM->value, UserRole::LEADER->value])) {
                return $this->handleSetRole($memUser, $newMemRole);
            }
        }

        return response()->json([
            'message' => 'Base can not update role',
        ]);
    }

    protected function handleSetRole($memUser, $newMemRole)
    {
        $memUser->role = $newMemRole;
        $memUser->save();
        return response()->json([
            'message' => 'Base successfully update role',
            'user' => $memUser,
        ]);
    }

//    public function index()
//    {
//        $users = Base::all();
//        return response()->json($users);
//    }

    public function handleActive()
    {
        $user = Auth::user();
//        dd(Auth);
        $userRole = $user->role;
        if ($userRole == UserRole::ADMIN->value) {
            echo('ok');
        }
    }
}
