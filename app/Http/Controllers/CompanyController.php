<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\traits\Promoteur ;

class CompanyController extends Controller
{
    use Promoteur ;
     public function __construct(Request $request )
    {
        $this->middleware(['web', 'user', 'auth:company']);
    }

}
