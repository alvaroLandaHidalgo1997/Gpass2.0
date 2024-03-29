<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $fillable = [
        'name'];

    public function user()
    {
        return $this->belongsTo('App\user');
    }

    public function password()
    {
        return $this->hasMany('App\Password');
    }
}
