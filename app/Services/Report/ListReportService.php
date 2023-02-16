<?php

namespace App\Services\Report;

use App\Repositories\ReportRepository;
use App\Services\BaseService;

class ListReportService extends BaseService
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
        $response = $this->repository->getAll();
        return $this->successResponse(
            'success', $response->toArray()
        );
        return $this->repository->getAll();
    }
}
