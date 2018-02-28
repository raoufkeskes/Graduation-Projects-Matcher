<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Annee_universitaire extends Model
{
	
	protected $table = 'annee_universitaire' ;
    protected $primaryKey = 'annee';
    public    $incrementing = false ;
    public    $timestamps = false;

    

    public function students()
	{
		    return $this->belongsToMany('App\Student' , 'cursus' , 'annee_universitaire_id' , 'student_id'  )
		    ->withPivot('Moyenne') ;
	}
}
