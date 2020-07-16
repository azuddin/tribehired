<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guard = [];

    public function post()
    {
        return $this->belongsTo('App\Post');
    }
}
