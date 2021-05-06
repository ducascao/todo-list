<?php

namespace App\Services;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Services\Interfaces\TaskServiceInterface;

class TaskService extends BaseService implements TaskServiceInterface
{
    /**
     * TaskService constructor
     *
     * @param TaskRepositoryInterface $taskServiceRepository
     */
    public function __construct(TaskRepositoryInterface $taskServiceRepository)
    {
        parent::__construct($taskServiceRepository);
    }

    public function restoreData()
    {
        $this->repository->restoreData();
    }
}
