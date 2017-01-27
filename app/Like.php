<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
      //which user gave this like/dislike
    }

    public function post()
    {
      return $this->belongsTo('App\Post');
    }
}
