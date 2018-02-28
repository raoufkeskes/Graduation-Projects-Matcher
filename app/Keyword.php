<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Keyword extends Model
{
	
	protected $table = 'Keyword' ;
    protected $primaryKey = 'keyword';
    public    $incrementing = false ;
    public    $timestamps = false;

    

    public function posts()
	{
		    return $this->belongsToMany('App\Post' , 'keyword_post' , 'keyword_id', 'post_id' );
	}
}
