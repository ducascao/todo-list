<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/** API Maker: imports */
use App\Repositories\Interfaces\TaskItemRepositoryInterface;
use App\Repositories\TaskItemRepository;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\TaskRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /** API Maker: Binds */
        $this->app->bind(TaskItemRepositoryInterface::class, TaskItemRepository::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
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
