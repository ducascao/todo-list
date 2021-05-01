<?php

namespace App\Services;

use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Services\Interfaces\TaskServiceInterface;

class TaskService extends BaseService implements TaskServiceInterface
{
    /**
     * TaskService constructor
     *
     * @param TaskRepositoryInterface $taskserviceRepository
     */
    public function __construct(TaskRepositoryInterface $taskserviceRepository)
    {
        parent::__construct($taskserviceRepository);
    }
}
