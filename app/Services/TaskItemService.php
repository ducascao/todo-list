<?php

namespace App\Services;

use App\Repositories\Interfaces\TaskItemRepositoryInterface;
use App\Services\Interfaces\TaskItemServiceInterface;

class TaskItemService extends BaseService implements TaskItemServiceInterface
{
    /**
     * TaskItemService constructor
     *
     * @param TaskItemRepositoryInterface $taskitemserviceRepository
     */
    public function __construct(TaskItemRepositoryInterface $taskitemserviceRepository)
    {
        parent::__construct($taskitemserviceRepository);
    }
}
