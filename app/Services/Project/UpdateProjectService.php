<?php

namespace App\Services\Project;

use App\Enums\UserRole;
use App\Repositories\ProjectRepository;
use App\Services\BaseService;
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
            if (auth()->user()->role === UserRole::MEMBER) {
                return $this->errorResponse(__('messages.project_msg_001'));
            }

            if ($this->data['form_report']) {
                $this->data['form_report'] = json_encode($this->data['form_report']);
            }

            $members = array_merge($this->data['member'] ?? [], $this->data['manager'] ?? []);
            unset($this->data['member'], $this->data['manager']);

            DB::beginTransaction();
            $project = $this->repository->update($id, $this->data);
            $project->members()->syncWithPivotValues($members, ['updated_at' => now()]);
            DB::commit();

            return $this->successResponse(__('Update success'));
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->errorResponse($exception->getMessage());
        }
    }
}
