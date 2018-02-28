<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialite extends Model
{
    protected $table = 'Specialite' ;
    protected $primaryKey = 'spec';
    public $incrementing = false;
    public $timestamps = false;
    

    public function posts()
	{
		    return $this->belongsToMany('App\Post' , 'post_specialite' , 'specialite_id', 'post_id' );
	}

}
