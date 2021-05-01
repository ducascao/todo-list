<?php

namespace App\Repositories;

use App\Models\TaskItem;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\TaskItemRepositoryInterface;

class TaskItemRepository extends BaseRepository implements TaskItemRepositoryInterface
{
    /**
     * TaskItemRepository constructor
     */
    public function __construct(TaskItem $model)
    {
        parent::__construct($model);
    }
}
