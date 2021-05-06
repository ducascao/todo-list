<?php

namespace App\Http\Controllers;

use App\Facades\Task;
use App\Facades\TaskItem;
use App\Mail\ShareTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Inertia\Inertia;

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

    public function restoreTasks()
    {
        Task::restoreData();
    }

    public function getItems(int $id)
    {
        return TaskItem::query(['task_id' => $id])->get();
    }

    public function getTasksByUser(Int $id)
    {
        return Task::query(['user_id' => $id])->with('items')->get();
    }

    public function getTaskByShareCode(String $code)
    {
        return Task::query(['share_code' => $code])->with('items')->get();
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

    public function sendSharedCode(Request $request, $id)
    {
        $emails = explode(',', $request->emails);

        $shareCode = Str::random(32);
        Task::save(['share_code' => $shareCode], $id);

        foreach ($emails as $email) {
            Mail::to(trim($email))->send(new ShareTask($shareCode));   
        }
    }
}
