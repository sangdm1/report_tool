<?php

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Base\BaseRepository;

class ProjectRepository extends BaseRepository
{
    /**
     * Get the model of repository
     *
     * @return string
     */
    public function getModel()
    {
        return Project::class;
    }
}
