<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskUser extends Model
{
    protected $table = "task_user";
    //
    protected $fillable = [
        'task_id',
        'user_id'
    ];

    public function task(){
        return $this->belongsTo('App\Task');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
