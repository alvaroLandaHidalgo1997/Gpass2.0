<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;


class User extends Model
{   
    
    protected $table = 'user';

    public function password()
    {
        return $this->hasMany('App\Password');
    }

    public function category()
    {
        return $this->hasMany('App\category');
    }

    public function rol()
    {
        return $this->belongsTo('App\user');
    }
    

}
