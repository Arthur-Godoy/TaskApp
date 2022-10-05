<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Task;

class Board extends Model
{
    use HasFactory;


    public function tasks(){
        return $this->hasMany('App\Models\Task');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
