<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url', 'body', 'user_id', 'commentable_id', 'commentable_type'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function commentable(){
        return $this->morphTo();
    }


}
