<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskItem extends Model
{
    protected $fillable = [
        'description',
        'task_id',
        'done',
    ];
}
