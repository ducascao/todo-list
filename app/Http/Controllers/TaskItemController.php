<?php

namespace App\Http\Controllers;

use App\Facades\TaskItem;
use Illuminate\Http\Request;

class TaskItemController
{
    public function index()
    {
        return TaskItem::list();
    }

    public function show(int $id)
    {
        return TaskItem::get($id);
    }

    public function store(Request $request)
    {
        return TaskItem::save($request->all());
    }

    public function update(Request $request, int $id)
    {
        return TaskItem::save($request->all(), $id);
    }

    public function destroy(int $id)
    {
        TaskItem::delete($id);
    }
}
