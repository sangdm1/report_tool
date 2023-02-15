<?php

namespace App\Services\Report;

use App\Repositories\ReportRepository;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Exception;

class CreateReportService extends BaseService
{
    public function __construct(ReportRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Logic to handle the data
     */
    public function handle()
    {
        try {
            $this->repository->create($this->data);
            return $this->successResponse(__('messages.creat_msg_001'), []);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), []);
        }
    }
}
