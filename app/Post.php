<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $table = 'Post' ; 

	public function keywords()
	{
		    return $this->belongsToMany('App\Keyword' , 'keyword_post' , 'post_id' , 'keyword_id'  );
	}

	 public function Poster()
    {
        return $this->belongsTo('App\User', 'poster_id');
    }
    
    public function specialites()
	{
		    return $this->belongsToMany('App\Specialite'    , 'post_specialite' , 'post_id', 'specialite_id' );
	}

	public function Validators()
	{
		    return $this->belongsToMany('App\Teacher' , 'valide')->withPivot('Reserve') ;
	}

	public function StudentsRequesters()
	{
		    return $this->belongsToMany('App\Student' ,'Postule')->withPivot('is_Blocked','created_at') ;
	}
	public function FinalAssignedStudents()
	{
		    return $this->hasMany('App\Student' , 'AcceptedPost_id');
	}

	public function comments()
	{
		return $this->hasMany('App\Comment');
	}

}
