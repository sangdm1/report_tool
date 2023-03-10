<?php

namespace App\Services\Project;

use App\Enums\UserRole;
use App\Repositories\ProjectRepository;
use App\Repositories\MemberRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\DB;
use Exception;

class CreateProjectService extends BaseService
{
    public function __construct(ProjectRepository $repository, MemberRepository $memberRepository)
    {
        $this->repository       = $repository;
        $this->memberRepository = $memberRepository;
    }

    /**
     * Logic to handle the data
     */
    public function handle()
    {
        try {
            if (auth()->user()->role === UserRole::MEMBER) {
                return $this->errorResponse(__('messages.project_msg_001'));
            }

            if ($this->data['form_report']) {
                $this->data['form_report'] = json_encode($this->data['form_report']);
            }

            $members = array_merge($this->data['member'], $this->data['manager']);
            unset($this->data['member'], $this->data['manager']);

            DB::beginTransaction();
            $project = $this->repository->create($this->data);
            $project->members()->syncWithPivotValues($members, ['created_at' => now(), 'updated_at' => now()]);
            DB::commit();

            return $this->successResponse(__('messages.creat_msg_001'));
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return $this->errorResponse($e->getMessage());
        }
    }
}
