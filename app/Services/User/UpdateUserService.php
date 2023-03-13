<?php

namespace App\Services\User;

use App\Enums\UserRole;
use App\Repositories\UserRepository;
use App\Services\BaseService;

class UpdateUserService extends BaseService
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
            $data = $this->data;
            $user = auth()->user();
            $isDev = $user->role == UserRole::MEMBER;

            if ($isDev && (isset($data['role']) || isset($data['status']) || isset($data['id']))
                || !$isDev && (isset($data['name']) || isset($data['display_name']) || isset($data['email']) || isset($data['avatar']))
            ) {
                return $this->errorResponse(__('Permission denied'));
            }

            $userId = $isDev ? $user->id : $data['id'];
            unset($data['id']);

            $this->repository->update($userId, $data);

            return $this->successResponse(__('Update success'));
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage());
        }
    }
}
