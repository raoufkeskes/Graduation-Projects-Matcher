<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;



class VisitorController extends Controller
{
     public function index()
    {
    			  
			      return view('welcome') ;      
    }
    
     public function send_message(Request $request){
        
            $validator = Validator::make($request->all(),[
              'nom' => 'required|min:4|max:30|regex:/^[a-zA-Z0-9-_\s]+$/',
              'email' => 'required|email|max:50',
              'subject' => 'max:100',
              'message' =>'max:5000',
                                                         ]);

             if($validator->fails())
             {
               return redirect()->back()->withInput($request->all())->withErrors($validator);
             }
           
            $nom = Input::get('nom');
            $email = Input::get('email');
            $subject = Input::get('subject');
            $message = Input::get('message');

            DB::table('message')->insert(
                ['Nom' => $nom, 
                 'Email' => $email, 
                 'Subject' => $subject,
                 'Message' => $message]);

          Session::flash('success' , 'Votre message a été envoyé. Merci!');
          return redirect('/');

      }

    
}
