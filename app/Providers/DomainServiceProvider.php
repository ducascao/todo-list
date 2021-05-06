<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/** API Maker: imports */
use App\Services\Interfaces\TaskItemServiceInterface;
use App\Services\TaskItemService;
use App\Services\Interfaces\TaskServiceInterface;
use App\Services\TaskService;

class DomainServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /** API Maker: Binds */
        $this->app->bind(TaskItemServiceInterface::class, TaskItemService::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
