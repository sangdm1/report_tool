<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Project\CreateProjectRequest;

use App\Services\Project\CreateProjectService;
use App\Services\Project\DetailProjectService;


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
}
