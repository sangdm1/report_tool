<?php

namespace App\Services\Project;

use App\Repositories\ProjectRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class DeleteProjectService extends BaseService
{
    public function __construct(ProjectRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Logic to handle the data
     */
    public function handle($id)
    {
        try {
            $authRole = Auth::user()->role;

            if ($authRole > 2) {
                return $this->baseResponse(__('User này không có quyền xóa dự án'), [], 400);
            }

            $project = $this->repository->firstWhere(['id' => $id]);
            if(!$project){
                return $this->errorResponse(__('Dự án không tồn tại'), []);
            }
            $project->delete();

            return $this->successResponse(__('Dự án xóa thành công'), []);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), []);
        }
    }
}
