<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends User
{
	protected $table ='Company' ;

    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }

    public function Representants()
    {
    	return $this->hasMany('App\Representant');
    }
}
