<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends User
{
	protected $table ='Teacher' ;
    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }

    public function PostsToValidate()
	{
		    return $this->belongsToMany('App\Post' , 'valide')->withPivot('Reserve');
	}

	public function MentoredStudents()
	{
		return $this->hasMany('App\Student' , 'Promoteur_interne_id');
	}

	public function CommissionDeValidation()
	{
		return $this->belongsTo('App\CommissionDeValidation');
	}


}
