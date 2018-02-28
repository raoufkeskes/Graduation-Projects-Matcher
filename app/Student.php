<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Student extends User
{
	protected $table ='Student' ;
	
    public function user()
    {
        return $this->morphOne('App\User', 'userable');
    }

    public function specia()
    {
        return $this->belongsTo('App\Specialite' , 'specialite' ,'spec');
    }

    public function Binome()
	{
		    return $this->hasOne('App\Student' , 'id' ,'Binome_id');
	}

    public function Promoteur_interne()
	{
		    return $this->belongsTo('App\Teacher' , 'Promoteur_interne_id');
	}

	public function Promoteur_externe()
	{
		    return $this->belongsTo('App\Representant' , 'Promoteur_externe_id');
	}

    public function requestedPosts()
	{
		    return $this->belongsToMany('App\Post' , 'Postule')->withPivot('is_Blocked','created_at') ;
	}


	public function AcceptedPost()
	{
		    return $this->belongsTo('App\Post' ,  'AcceptedPost_id');
	}

	public function Cursus()
	{
		    return $this->belongsToMany('App\annee_universitaire' , 'Cursus' , 'student_id', 'annee_universitaire_id' )->withPivot('Moyenne') ;
	}

	public function BinomeRequesters()
	{
		    return $this->belongsToMany('App\Student' , 'demande_binome' ,'student1_id' , 'student2_id') ;
	}




}
