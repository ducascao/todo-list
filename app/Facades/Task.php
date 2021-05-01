<?php

namespace App\Facades;

use App\Services\Interfaces\TaskServiceInterface;
use Illuminate\Support\Facades\Facade;

class Task extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TaskServiceInterface::class;
    }
}
