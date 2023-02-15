<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Http\Requests\Project\CreateProjectRequest;

use App\Services\Project\CreateProjectService;


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
}
