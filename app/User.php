<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements Authenticatable
{
  use \Illuminate\Auth\Authenticatable;
  public function posts()
  {
    return $this->hasMany('App\Post');
    //can have more than 1 post
  }

  public function likes()
  //post can have multiple likes
  {
    return $this->hasMany('App\Like');
  }
}
