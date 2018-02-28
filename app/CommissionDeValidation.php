<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommissionDeValidation extends Model
{
    protected $table ="commission_de_validation" ;

    public function Teachers()
    {
    	return $this->hasMany('App\Teacher');
    }
}
