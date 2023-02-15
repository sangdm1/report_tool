<?php

namespace App\Services\Project;

use App\Repositories\ProjectRepository;
use App\Services\BaseService;

class ListProjectService extends BaseService
{
    public function __construct(ProjectRepository $repository)
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
