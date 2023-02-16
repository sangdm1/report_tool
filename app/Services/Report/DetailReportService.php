<?php

namespace App\Services\Report;

use Illuminate\Http\Response;

use App\Http\Resources\Report\ReportResource;

use App\Repositories\ReportRepository;

use App\Services\BaseService;

class DetailReportService extends BaseService
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
            $report = $this->repository->firstWhere(['id' => $this->data['id']]);
            if (!$report) {
                return $this->baseResponse('Không tồn tại báo cáo có id '.$this->data['id'], [], Response::HTTP_NOT_FOUND);
            }
            $reportResource = new ReportResource($report);

            return $this->successResponse('', ['project' => $reportResource]);
        } catch (\Exception $exception) {
            return $this->errorResponse($exception->getMessage(), []);
        }
    }
}
