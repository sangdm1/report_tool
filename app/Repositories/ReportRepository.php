<?php

namespace App\Repositories;

use App\Models\Report;
use App\Repositories\Base\BaseRepository;

class ReportRepository extends BaseRepository
{
    /**
     * Get the model of repository
     *
     * @return string
     */
    public function getModel()
    {
        return Report::class;
    }
}
