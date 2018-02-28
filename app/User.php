<?php

namespace App;

use App\Notifications\UserResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table='User' ;
    protected $fillable = [
        'username', 'email', 'password', 'telephone' 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new UserResetPassword($token));
    }



    public function userable()
    {
        return $this->morphTo();
    }

    public function Posts()
    {
        return $this->hasMany('App\Post', 'poster_id');
    }

     public function Notifications()
    {
        return $this->hasMany('App\Notification', 'user_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
