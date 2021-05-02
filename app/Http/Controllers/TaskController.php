<?php

namespace App\Http\Controllers;

use App\Facades\Task;
use App\Facades\TaskItem;
use Illuminate\Http\Request;

class TaskController
{
    public function index()
    {
        return Task::list();
    }

    public function show(int $id)
    {
        return Task::get($id);
    }

    public function store(Request $request)
    {
        return Task::save($request->all());
    }

    public function update(Request $request, int $id)
    {
        return Task::save($request->all(), $id);
    }

    public function destroy(int $id)
    {
        Task::delete($id);
    }

    public function getItems(int $id)
    {
        return TaskItem::query(['task_id' => $id])->get();
    }
}
