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
            if (!$user = $this->repository->firstWhere(['id' => $this->data['id']])) {
                return $this->errorResponse(__('User not found'));
            }

            return $this->successResponse('', (new UserResource($user))->resolve());
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }
}
