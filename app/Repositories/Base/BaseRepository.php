<?php

namespace App\Repositories\Base;

use Illuminate\Database\Eloquent\ModelNotFoundException;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    protected $model;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->resetModel();
    }

    /**
     * Get the model of repository
     *
     * @return string
     */
    abstract public function getModel();

    public function resetModel()
    {
        $instance = $this->app->make($this->getModel());

        if (!$instance instanceof Model) {
            throw new ModelNotFoundException('User not found');
        }

        return $this->model = $instance;
    }

    /**
     * Get all data of repository
     *
     * @param array $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        return $this->model->all();
    }

    /**
     * Retrieve first data by multiple fields
     * @param $where
     * @param array $columns
     * @return mixed
     * @throws RepositoryException
     */
    public function firstWhere($where)
    {
        $model = $this->model->where($where)->first();
        $this->resetModel();

        return $model;
    }

    /**
     * Update the existed model
     *
     * @param mixed $id
     * @param array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $attributes)
    {
        $result = $this->model->findOrFail($id);
        $result->fill($attributes);
        $result->save();

        $this->resetModel();

        return $result;
    }

}
