<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Representant extends Model
{
    protected $table ="Representant" ;

    public function Company()
    {
    	return $this->belongsTo('App\Company');
    }

    public function MentoredStudents()
	{
		return $this->hasMany('App\Student' , 'Promoteur_externe_id');
	}
}

