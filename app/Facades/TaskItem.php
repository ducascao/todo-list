<?php

namespace App\Facades;

use App\Services\Interfaces\TaskItemServiceInterface;
use Illuminate\Support\Facades\Facade;

class TaskItem extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TaskItemServiceInterface::class;
    }
}
