<?php

namespace App\Services\User;

use App\Http\Resources\User\UserResource;

use App\Repositories\UserRepository;

use App\Services\BaseService;

class DetailUserService extends BaseService
{
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Logic to handle the data
     */
    public function handle()
    {
        try {
            $user = $this->repository->firstWhere(['id' => $this->data['id']]);
            if (!$user) {
                return $this->baseResponse('[]', [], Response::HTTP_NOT_FOUND);
            }
            $userResource = new UserResource($user);

            return $this->successResponse('', ['user' => $userResource]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), []);
        }
    }
}
