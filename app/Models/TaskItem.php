<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TaskItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'description',
        'task_id',
        'done',
    ];
}
