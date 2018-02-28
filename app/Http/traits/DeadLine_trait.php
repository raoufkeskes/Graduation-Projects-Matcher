<?php 


namespace App\Http\traits ;

use App\Deadline ;

trait DeadLine_Trait
{
    
     function DeadlineCheck ($GoodPhase)
    {
          
          $currentDate = time() ;
          
        if ($this->check ( $currentDate , $GoodPhase ))
           return false ;
        ($this->check ( $currentDate , 'Soumission' )) ;
        if ($this->check ( $currentDate , 'Soumission' ))
          return [ 'page' => 'errors.Soumission'  , 'data' => $this->getInterval('Soumission')] ;
        if ($this->check ( $currentDate , 'Validation' ))
         return [ 'page' => 'errors.Validation'  , 'data' => $this->getInterval('Validation')] ;
        if ($this->check ( $currentDate , 'Candidature' ))
          return [ 'page' => 'errors.Candidature'  , 'data' => $this->getInterval('candidature')] ;
                 
    }

     function check($date , $Phase )
    {

       $deadline = Deadline::where('Phase', $Phase )->first() ;
       return  ( $date>= strtotime($deadline->Date_debut)  &&  $date <= strtotime($deadline->Date_fin) ) ;
    }

    function getInterval($Phase)
    {
      setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
      $deadline = Deadline::where('Phase',  $Phase )->first() ; 
      return  ['Date_debut' => strftime('%A %d %B %Y ' , strtotime($deadline->Date_debut) ) , 'Date_fin' => strftime('%A %d %B %Y' , strtotime($deadline->Date_fin) ) ] ;
    } 



}
