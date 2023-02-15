<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Report\CreateReportRequest;
use App\Services\Report\CreateReportService;

class ReportController extends Controller
{
    /**
     * Store a newly created resource in DB.
     *
     * @param CreateReportRequest $request
     * @return void
     */
    public function store(CreateReportRequest $request)
    {
        return resolve(CreateReportService::class)->setData($request->validated())->handle();
    }
}
