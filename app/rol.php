<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    public function user()
    {
        return $this->hasMany('App\user');
    }

}