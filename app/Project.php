<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'user_id', 'company_id', 'days'
    ];

    public function company(){
        return $this->belongsTo('App\Company');
    }

    public function comments(){
        return $this->morphMany('App\Comment', 'commentable');
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }
}
