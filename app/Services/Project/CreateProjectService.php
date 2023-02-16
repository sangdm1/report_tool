<?php

namespace App\Services\Project;

use App\Repositories\ProjectRepository;
use App\Repositories\MemberRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
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
            $authRole = Auth::user()->role;
            if ($authRole > 2) {
                return $this->baseResponse(__('messages.project_msg_001'), [], 400);
            }
            $members = $this->data['member'];
            unset($this->data['member']);
            DB::beginTransaction();

            $project = $this->repository->create($this->data);
            $project->members()->sync($members);

            DB::commit();
            return $this->successResponse(__('messages.creat_msg_001'), []);
        } catch (Exception $e) {
            DB::rollBack();

            return $this->errorResponse($e->getMessage(), []);
        }
    }
}
