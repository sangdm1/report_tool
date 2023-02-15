<?php

namespace App\Services\Project;

use Illuminate\Http\Response;

use App\Http\Resources\Project\ProjectResource;

use App\Repositories\ProjectRepository;

use App\Services\BaseService;

class DetailProjectService extends BaseService
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
            $project = $this->repository->firstWhere(['id' => $this->data['id']]);
            if (!$project) {
                return $this->baseResponse('Không tồn tại dự án có id '.$this->data['id'], [], Response::HTTP_NOT_FOUND);
            }
            $projectResource = new ProjectResource($project);

            return $this->successResponse('', ['project' => $projectResource]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), []);
        }
    }
}
