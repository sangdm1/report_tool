<?php

namespace App\Services\Report;

use App\Repositories\ReportRepository;
use App\Services\BaseService;

class DeleteReportService extends BaseService
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
            $report = $this->repository->firstWhere(['id' => $id]);
            if(!$report){
                return $this->errorResponse(__('Báo cáo không tồn tại'), []);
            }
            $report->delete();

            return $this->successResponse(__('Xóa báo cáo thành công'), []);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), []);
        }
    }
}
