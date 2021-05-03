<?php

namespace App\Models;

use App\Models\TaskItem;
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
