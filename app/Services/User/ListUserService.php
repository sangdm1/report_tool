<?php

namespace App\Services\User;

use App\Repositories\UserRepository;
use App\Services\BaseService;

class ListUserService extends BaseService
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
        $response = $this->repository->getAll();
        return $this->successResponse(
            'success', $response->toArray()
        );
        return $this->repository->getAll();
    }
}
