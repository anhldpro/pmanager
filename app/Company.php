<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'user_id',
    ];

    public function projects(){
        return $this->hasMany('App\Project');
    }

    public function comments(){
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function user(){
        return $this->belongsTo('App\User');
    }
}
