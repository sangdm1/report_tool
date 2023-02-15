<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Project\CreateProjectRequest;

use App\Services\Project\CreateProjectService;
use App\Services\Project\DetailProjectService;
use App\Services\Project\UpdateProjectService;

class ProjectController extends Controller
{

    /**
     * Store a newly created resource in DB.
     *
     * @param CreateProjectRequest $request
     * @return void
     */
    public function store(CreateProjectRequest $request)
    {
        return resolve(CreateProjectService::class)->setData($request->validated())->handle();
    }

    /**
     * Display the specified DB.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return resolve(DetailProjectService::class)->setData(['id' => $id])->handle();
    }

    /**
     * Update the specified resource in DB.
     *
     * @param CreateProjectRequest $request
     * @param int $id
     * @return Response
     */
    public function update(CreateProjectRequest $request, $id)
    {
        return resolve(UpdateProjectService::class)->setRequest($request)->handle($id);
    }
}
