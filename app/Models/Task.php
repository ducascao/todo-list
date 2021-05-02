<?php

namespace App\Models;

use App\Facades\TaskItem;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'description',
        'user_id',
    ];

    public function items()
    {
        return $this->hasMany(TaskItem::class);
    }
}
