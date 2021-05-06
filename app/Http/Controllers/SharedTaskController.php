<?php

namespace App\Http\Controllers;

use App\Facades\Task;
use App\Facades\TaskItem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SharedTaskController
{
    public function update(Request $request, String $code)
    {
        $task = Task::query(['share_code' => $code])->first();
        Task::save($request->all(), $task->id);
    }

    public function getItems(int $id)
    {
        return TaskItem::query(['task_id' => $id])->get();
    }

    public function getTaskByShareCode(String $code)
    {
        return Task::query(['share_code' => $code])->with('items')->get();
    }

    public function addItem(Request $request, $code)
    {
        $task = Task::query(['share_code' => $code])->first();
        TaskItem::save([
            'description' => $request->description,
            'done' => 0,
            'task_id' => $task->id
        ]);
    }

    public function updateItem(Request $request, Int $id)
    {
        return TaskItem::save($request->all(), $id);
    }

    public function verifySharedCode(String $code)
    {
        $searchTask = Task::query(['share_code' => $code])->with('items')->get();

        if ($searchTask) {
            return Inertia::render('SharedTask', [
                'code' => $code
            ]); 
        }
    }
}
