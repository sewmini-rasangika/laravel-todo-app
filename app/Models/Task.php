<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['task', 'date', 'time', 'priority', 'note', 'is_done'];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'is_done' => 'boolean',
    ];
}
