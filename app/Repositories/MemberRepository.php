<?php

namespace App\Repositories;

use App\Models\Member;
use App\Repositories\Base\BaseRepository;

class MemberRepository extends BaseRepository
{
    /**
     * Get the model of repository
     *
     * @return string
     */
    public function getModel()
    {
        return Member::class;
    }
}
