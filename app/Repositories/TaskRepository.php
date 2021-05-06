<?php

namespace App\Repositories;

use App\Models\Task;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TaskRepositoryInterface;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    /**
     * TaskRepository constructor
     */
    public function __construct(Task $model)
    {
        parent::__construct($model);
    }

    public function restoreData()
    {
        $this->model->onlyTrashed()->restore();
    }
}
