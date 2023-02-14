<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator;

use App\Http\Requests\User\ListUserRequest;
use App\Http\Requests\User\CreateUserRequest;

use App\Services\User\ListUserService;
use App\Services\User\UpdateUserService;

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

    /**
     * Update the specified resource in DB.
     *
     * @param CreateUserRequest $request
     * @param int $id
     * @return Response
     */
    public function update(CreateUserRequest $request, $id)
    {
        return resolve(UpdateUserService::class)->setRequest($request)->handle($id);
    }
}
