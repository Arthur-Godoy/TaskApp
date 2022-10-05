<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Board;
use App\Models\SubTask;

class Task extends Model
{
    use HasFactory;

    public function board(){
        return $this->belongsTo('App\Models\Board');
    }

    public function subtasks(){
        return $this->hasMany('App\Models\SubTask');
    }
}
