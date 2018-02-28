<?php 

use App\Deadline ;
namespace App\Http\traits ;

trait limit_text_Trait
{
     function limit_text($text, $limit)
    {
      if (str_word_count($text, 0) > $limit) 
      {
          $words = str_word_count($text, 2);
          $pos = array_keys($words);
          $text = substr($text, 0, $pos[$limit]) . '...';
      }
      return $text;
    }

     function randomString($length = 6) {
      $str = "";
      $characters = array_merge(range('A','Z'), range('a','z'));
      $max = count($characters) - 1;
      for ($i = 0; $i < $length; $i++) {
        $rand = mt_rand(0, $max);
        $str .= $characters[$rand];
      }
      return $str;
    }

}










 