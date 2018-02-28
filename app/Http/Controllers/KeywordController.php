<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Keyword;

class KeywordController extends Controller
{

    public function allkeywords()
    {
    	$keywords = Keyword::get() ;
    	return response()->json(['keywords' => $keywords ]);
    }

   

}
