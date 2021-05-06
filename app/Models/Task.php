<?php

namespace App\Models;

use App\Models\TaskItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'description',
        'user_id',
        'share_code'
    ];

    public function items()
    {
        return $this->hasMany(TaskItem::class);
    }
}
