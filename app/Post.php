<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function user()
    {
      return $this->belongsTo('App\User');
      //post belongs to a user, that's why we go to the user file.
    }

    public function likes()
    //post can have multiple likes
    {
      return $this->hasMany('App\Like');
    }
}
