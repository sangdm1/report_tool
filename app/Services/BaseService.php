<?php

namespace App\Services;

use Illuminate\Support\Collection;
use App\Traits\ApiResponse;


abstract class BaseService
{
    use ApiResponse;

    /**
     * @var boolean
     */
    protected bool $collectsData = false;

    /**
     * Set the data
     *
     * @param mixed $data
     * @return self
     */
    public function setData($data)
    {
        $this->data = ($data instanceof Collection || ! $this->collectsData) ? $data : new Collection($data);

        return $this;
    }
}
