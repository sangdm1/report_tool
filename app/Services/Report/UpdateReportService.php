<?php

namespace App\Services\Report;

use App\Repositories\ReportRepository;
use App\Services\BaseService;

class UpdateReportService extends BaseService
{
    public function __construct(ReportRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Logic to handle the data
     */
    public function handle($id)
    {
        try {
            $this->repository->update($id, $this->data);
            return $this->successResponse(__('Cập nhật báo cáo thành công'), []);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), []);
        }
    }
}
