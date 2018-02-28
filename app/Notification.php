<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	
	protected $table = 'Notification' ;
    public    $timestamps = false;

     public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
