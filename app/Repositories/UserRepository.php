<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Base\BaseRepository;

class UserRepository extends BaseRepository{
    /**
     * Get the model of repository
     *
     * @return string
     */
    public function getModel()
    {
        return User::class;
    }
}
