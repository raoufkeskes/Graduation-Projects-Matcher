<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table ='comment' ;

    public function Commentator()
    {
    	return $this->belongsTo('App\User' , 'user_id');
    }
    public function Post()
    {
    	return $this->belongsTo('App\Post');
    }

}
