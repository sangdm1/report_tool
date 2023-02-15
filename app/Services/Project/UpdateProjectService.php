<?php

namespace App\Services\Project;

use App\Repositories\ProjectRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UpdateProjectService extends BaseService
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
                return $this->baseResponse(__('messages.project_msg_001'), [], 400);
            }
            $members = $this->data['member'] ?? [];
            unset($this->data['member']);
            DB::beginTransaction();
            $project = $this->repository->update($id, $this->data);
            $project->members()->sync($members);
            DB::commit();

            return $this->successResponse(__('Update success'), []);
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception->getMessage(), []);
        }
    }
}
