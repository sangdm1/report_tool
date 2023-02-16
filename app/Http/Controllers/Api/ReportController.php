<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Report\CreateReportRequest;
use App\Http\Requests\Report\ListReportRequest;

use App\Services\Report\DetailReportService;
use App\Services\Report\CreateReportService;
use App\Services\Report\UpdateReportService;
use App\Services\Report\ListReportService;
use App\Services\Report\DeleteReportService;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param ListReportRequest $request
     * @return JsonResponse
     */
    public function index(ListReportRequest $request)
    {
        return resolve(ListReportService::class)->setData($request->all())->handle();
    }

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

    /**
     * Display the specified DB.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return resolve(DetailReportService::class)->setData(['id' => $id])->handle();
    }

    /**
     * Update the specified resource in DB.
     *
     * @param CreateReportRequest $request
     * @param int $id
     * @return Response
     */
    public function update(CreateReportRequest $request, $id)
    {
        return resolve(UpdateReportService::class)->setRequest($request)->handle($id);
    }

    /**
     * Remove the specified resource from DB.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return resolve(DeleteReportService::class)->handle($id);
    }
}
