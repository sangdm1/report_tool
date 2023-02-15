<?php

namespace App\Services\Project;

use App\Repositories\ProjectRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class CreateProjectService extends BaseService
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
        try {
            $authRole = Auth::user()->role;
            if ($authRole > 2) {
                return $this->baseResponse(__('messages.project_msg_001'), [], 400);
            }
            $this->repository->create($this->data);
            return $this->successResponse(__('messages.creat_msg_001'), []);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), []);
        }
    }
}
