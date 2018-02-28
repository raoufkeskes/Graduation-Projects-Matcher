<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Admin;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Hash;
use App\Company;
use App\Student;
use App\User;
use App\Teacher;
use App\Post;
use App\Message;
use App\Valide;
use App\CommissionDeValidation;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Show the application dashboard.
     *
     * @return \\Http\Response
     */

    /* Dashboard */
    public function index()
    {   

        $pourcentage_entreprises = 0;
        $pourcentage_etudiants = 0;
        $pourcentage_enseignants = 0;
        $pourcentage_sujets_valide = 0;
        $pourcentage_sujets_non_valide = 0;
        $pourcentage_etudiants_avec_sujet = 0;
        $pourcentage_etudiants_sans_sujet = 0;
        $pourcentage_sujet_sans_comission = 0;

        $entreprises_inscrites=User::where('user.is_Activated','=','1')
                   ->where('user.userable_type','=','Company')
                   ->count();

        $entreprises_non_approuve=User::where('user.is_Activated','=','1')
                   ->where('user.is_Approved','=','0')
                   ->where('user.userable_type','=','Company')
                   ->count();

        if($entreprises_inscrites != 0)
        {
          $pourcentage_entreprises=(int)($entreprises_non_approuve*100/$entreprises_inscrites);
        }

        $etudiants_inscrits=User::where('user.is_Activated','=','1')
                   ->where('user.userable_type','=','Student')
                   ->count();

        $etudiants_non_approuve=User::where('user.is_Activated','=','1')
                   ->where('user.is_Approved','=','0')
                   ->where('user.userable_type','=','Student')
                   ->count();

        if($etudiants_inscrits != 0)
        {
        $pourcentage_etudiants=(int)($etudiants_non_approuve*100/$etudiants_inscrits);  
        }

        $enseignants_inscrits=User::where('user.is_Activated','=','1')
                   ->where('user.userable_type','=','Teacher')
                   ->count();

        $enseignants_non_approuve=User::where('user.is_Activated','=','1')
                   ->where('user.is_Approved','=','0')
                   ->where('user.userable_type','=','Teacher')
                   ->count();

        if($enseignants_inscrits != 0)
        {
        $pourcentage_enseignants=(int)($enseignants_non_approuve*100/$enseignants_inscrits);
        }

        $sujets_valide=Post::where('post.Etat','=','Validé')
                   ->orWhere('post.Etat','=','En candidature')
                   ->orWhere('post.Etat','=','Affecté')
                   ->count();

        $nombre_total_sujets=Post::where('post.Etat','<>','Bloqué')
                   ->count();

        $sujets_non_valide=Post::where('post.Etat','En proposition')
                               ->orWhere('post.Etat','=','En cours de validation')
                               ->orWhere('post.Etat','=','Validé sous réserve')
                               ->orWhere('post.Etat','=','Refusé')
                               ->count();

        $sujets = Post::where('post.Etat','<>','Bloqué')->count();

        $sujets_sans_comi_validation = Post::where('post.Etat','En proposition')
                   ->count();

       if($sujets != 0)
       {
        $pourcentage_sujet_sans_comission =(int)($sujets_sans_comi_validation*100/$sujets);
       }

        if($nombre_total_sujets != 0)
        {
        $pourcentage_sujets_valide=(int)($sujets_valide*100/$nombre_total_sujets);
        }   
         
        if($nombre_total_sujets != 0)
        {
        $pourcentage_sujets_non_valide =(int)($sujets_non_valide*100/$nombre_total_sujets);
        }

        $etudiants_qui_ont_sujet = DB::table('user')
                                       ->join('student','user.userable_id','=','student.id')
                                       ->select('student.*','user.*')
                                       ->where('user.userable_type','=','Student')
                                       ->where('user.is_Approved','=','1')
                                       ->whereNotNull('student.AcceptedPost_id')
                                       ->count();

        $etudiants_sans_sujet = DB::table('user')
                                       ->join('student','user.userable_id','=','student.id')
                                       ->select('student.*','user.*')
                                       ->where('user.userable_type','=','Student')
                                       ->where('user.is_Approved','=','1')
                                       ->whereNull('student.AcceptedPost_id')
                                       ->count();

        $etudiant_approuvee = User::where('user.userable_type','=','Student')
                                    ->where('user.is_Approved','=','1')
                                    ->count();



        if($etudiant_approuvee != 0)
        {
          $pourcentage_etudiants_avec_sujet =(int)($etudiants_qui_ont_sujet*100/$etudiant_approuvee);
          $pourcentage_etudiants_sans_sujet =(int)($etudiants_sans_sujet*100/$etudiant_approuvee);
        }
        
     return view('admin.dashboard',['pourcentage_entreprises' => $pourcentage_entreprises ,
                        'pourcentage_etudiants' => $pourcentage_etudiants ,
                        'pourcentage_enseignants' => $pourcentage_enseignants ,
                        'entreprises_inscrites' => $entreprises_inscrites ,
                        'entreprises_non_approuve' => $entreprises_non_approuve ,
                        'etudiants_inscrits' => $etudiants_inscrits ,
                        'etudiants_non_approuve' => $etudiants_non_approuve ,
                        'enseignants_inscrits' => $enseignants_inscrits ,
                        'enseignants_non_approuve' => $enseignants_non_approuve ,
                        'sujets_valide' => $sujets_valide ,
                        'sujets_non_valide' => $sujets_non_valide ,
                        'sujets_sans_comi_validation' => $sujets_sans_comi_validation ,
                        'pourcentage_sujets_non_valide' => $pourcentage_sujets_non_valide ,
                        'pourcentage_sujets_valide' => $pourcentage_sujets_valide ,
                        'etudiants_qui_ont_sujet' => $etudiants_qui_ont_sujet ,
                        'etudiants_sans_sujet' => $etudiants_sans_sujet ,
                        'pourcentage_etudiants_avec_sujet' => $pourcentage_etudiants_avec_sujet ,
                        'pourcentage_etudiants_sans_sujet' => $pourcentage_etudiants_sans_sujet ,
                        'pourcentage_sujet_sans_comission' => $pourcentage_sujet_sans_comission ]);
    }

    public function create_comission(Request $request){


      $validator = Validator::make($request->all(),[
         'name' => 'required|min:4|max:100|unique:commission_de_validation,Nom'
         ]);

      if($validator->fails())
      {
        return redirect()->back()->withInput($request->all())->withErrors($validator);
      }

      $comission = new CommissionDeValidation();
      $comission->Domaine = $request->Input('domaine');
      $comission->Nom = $request->Input('name');
      $comission->save();

      Session::flash('success', 'Comission de validation créée avec succes'); 
      return redirect('admin/validationcom');
    
    }

  /* Pages methodes */
   public function societies()
   {

      // $users =User::all()
      //              ->where('user.is_Activated','=','1')
      //              ->where('user.userable_type','=','Company');
                   

      $users = DB::table('user')
                   ->join('company','user.userable_id','=','company.id')
                   ->select('user.*','company.Raison_sociale','company.registre_image')
                   ->where('user.is_Activated','=','1')
                   ->where('user.userable_type','=','Company')
                   ->get();

    return view('admin.societies',['users' => $users]);           
   } 
   
   public function students(Request $request)
   {

      $users=null;
      if($request->is('*/binomes/students')){

          $users = DB::table('user')
                   ->join('student','user.userable_id','=','student.id')
                   ->join('specialite','student.specialite','=','specialite.spec')
                   ->join('student as binomes','student.Binome_id','=','binomes.id')
                   ->select('student.*','specialite.niveau','binomes.nom as nom_binome','binomes.prenom as prenom_binome','user.*')
                   ->where('user.is_Activated','=','1')
                   ->where('user.userable_type','=','Student')
                   ->get();

                                           }

      if($request->is('*/monomes/students'))
      {     

          $users = DB::table('user')
                   ->join('student','user.userable_id','=','student.id')
                   ->join('specialite','student.specialite','=','specialite.spec')
                   ->select('student.*','user.*','specialite.niveau')
                   ->where('user.is_Activated','=','1')
                   ->where('user.userable_type','=','Student')
                   ->whereNull('student.Binome_id')
                   ->get();
      }
                                   
          return view('admin.students',['users' => $users]);
   }
   
   public function validation()
   {

        $teachers = Teacher::whereNotNull('commission_de_validation_id');
        $comissions = CommissionDeValidation::all();
        return view('admin.validation' , ['teachers' => $teachers , 'comissions' => $comissions]);

   }

   public function desaffect_commit_subject($id){

     $post = Post::findOrFail($id);
     $post->Etat = 'En proposition';
     $post->save();

     $valides = DB::table('valide')->where('post_id','=',$id)->delete();

     Session::flash('success','Comission de validation désafecté');

     return redirect('admin/subjects');

   }

   public function delete_comission($id){

        $teachers = Teacher::where('commission_de_validation_id','=',$id)->get();

            
        foreach ($teachers as $teacher){
          $valides = Valide::where('teacher_id' , $teacher->id)->get();
          foreach ($valides as $valide){
              $valide->delete();
          }
          $teacher->commission_de_validation_id = null;
        }
 
        $comission = CommissionDeValidation::findOrFail($id);
        $comission->delete();

        Session::flash('success' , 'Comission de validation supprimée');

        return redirect('admin/validationcom');
   }

   public function comments()
   {
           return view('admin.comments');
   }

   public function settings()
   {
           return view('admin.settings');
   }
   public function teachers()
   {

         $users = DB::table('user')
                   ->join('teacher','user.userable_id','=','teacher.id')
                   ->select('teacher.*','user.*')
                   ->where('user.is_Activated','=','1')
                   ->where('user.userable_type','=','Teacher')
                   ->get();

         $comissions = CommissionDeValidation::all();          

           return view('admin.teachers',['users' => $users , 'comissions' => $comissions]);
   }

   public function add_to_comission(Request $request){

     $user = User::findOrFail($request->Input('id_user')); 
     $user->userable->commission_de_validation_id = $request->Input('comission_id');
     $user->userable->save();
     Session::flash('success' , 'Enseignant ajouté a la comission');
     return redirect('admin/teachers');

   }

   public function delete_from_comission($id){
      
      $user = User::findOrFail($id);
      $user->userable->commission_de_validation_id = null;
      $user->userable->save();
      Session::flash('success' , 'Enseignant retiré de la comission');
      return redirect('admin/teachers');

   }

   public function affect_comission(Request $request){
        
      $post_id = $request->Input('id_post_commit');
      $comission_id = $request->Input('comission_id');
      $teachers = Teacher::all();
      $bool = 0;

      foreach ($teachers as $teacher){
       if(isset($teacher->commission_de_validation_id) && $teacher->commission_de_validation_id == $comission_id){
            DB::table('valide')->insert(
             ['post_id' => $post_id, 'teacher_id' => $teacher->id]                                       );
            $bool = 1;
       }
      }

        if($bool == 0){
            Session::flash('error' , 'La commission de validation ne contient aucun enseignant');
            return redirect()->back();
        }
    
     $post = Post::where('id',$post_id)->first();
     $post->save();

     Session::flash('success' , 'Commission de validation affectée');

     return redirect('admin/subjects');
   }

   public function auto_affect_commission(){
        
        $domaine_post = Post::select('Domaine')->groupBy('Domaine')->get();
        $nombre_sujets = Post::where('Etat','=','En cours de validation')->count();
        $compteur = 0;

        foreach($domaine_post as $domaine){

          $posts = Post::where('Domaine' ,'=',$domaine->Domaine)
                         ->where('Etat','=','En cours de validation')->get();
          $comissions = CommissionDeValidation::where('Domaine','=',$domaine->Domaine)->get();
          $nombre_comissions = $comissions->count();
          $i=0;
         
          foreach ($posts as $post){

              $post_id = $post->id;
              if($nombre_comissions > 0){            
              $teachers = Teacher::where('commission_de_validation_id','=',$comissions[$i % $nombre_comissions]->id)->get();

              if($teachers->count() > 0){
             
              foreach ($teachers as $teacher){
                   DB::table('valide')->insert(
                    ['post_id' => $post_id, 'teacher_id' => $teacher->id]                                       );
                                             }

                       $i++;
                       $compteur++;   
                                      }
                                    }
                                  }
                                           }

            if($compteur <  $nombre_sujets){
                 Session::flash('warning' , 'Faite attention, quelques domaine n\'ont aucune commission de validation, par consequent ils existent encore des sujet non affectés.');
                  return redirect('admin/subjects');
            }
            else{
                 Session::flash('success' , 'Tout les sujets se sont bien affecté');
                  return redirect('admin/subjects');
            }                               
        

        }


   /* Subjects page */
   public function subjects()
   {

        // $subjects = Post::all();
         
        $subjects_students =  DB::table('post')
                    ->join('user' , 'post.Poster_id' , '=' , "user.id")
                    ->join('student' , 'user.userable_id' , '=' ,'student.id')
                    ->select('student.*' , 'student.id as student_id', 'user.*','user.id as user_id', 'post.*')
                    ->where('Etat', '<>' , 'Bloqué')
                    ->where('Etat', '<>' , 'Affecté')
                    ->where('user.userable_type','=','Student')
                    ->get();

        $subjects_teachers =  DB::table('post')
                    ->join('user' , 'post.Poster_id' , '=' , "user.id")
                    ->join('teacher' , 'user.userable_id' , '=' ,'teacher.id')
                    ->select('teacher.*','teacher.id as teacher_id', 'user.*' , 'post.*')
                    ->where('Etat', '<>' , 'Bloqué')
                    ->where('Etat', '<>' , 'Affecté')
                    ->where('user.userable_type','=','Teacher')
                    ->get();

      $subjects_companies =  DB::table('post')
                    ->join('user' , 'post.Poster_id' , '=' , "user.id")
                    ->join('company' , 'user.userable_id' , '=' ,'company.id')
                    ->select('company.*' , 'user.*' , 'post.*')
                    ->where('Etat', '<>' , 'Bloqué')
                    ->where('Etat', '<>' , 'Affecté')
                    ->where('user.userable_type','=','Company')
                    ->get();

      $posts = Post::all();
      $teachers = Teacher::all(); 
      $comissions = CommissionDeValidation::all();

      return view('admin.subjects' , ['subjects_students' => $subjects_students,
                                      'subjects_teachers' => $subjects_teachers,
                                      'subjects_companies' => $subjects_companies,
                                      'teachers' => $teachers,
                                      'posts' => $posts,
                                      'comissions' => $comissions]);

      // return view('admin.subjects' , ['subjects' => $subjects]);
   }

  /* Projects page */
  public function projects()
  {

      $projects_internes =  DB::table('user')
                    ->join('student' , 'user.userable_id' , '=' , 'student.id')
                    ->join('post' , 'student.AcceptedPost_id' , '=' ,'post.id')
                    ->join('teacher' , 'student.Promoteur_interne_id','=','teacher.id')
                    ->select('teacher.id as id_teacher' ,'teacher.Nom as Nom_teacher','teacher.Prenom as Prenom_teacher','student.id as student_id' ,'student.Nom as Nom_student','student.Prenom as Prenom_student','user.userable_type','user.id as user_id', 'post.*')
                    ->where('user.userable_type', 'Student')
                    ->whereNull('student.Promoteur_externe_id')
                    ->get();

      $projects_externes =  DB::table('user')
                    ->join('student' , 'user.userable_id' , '=' , 'student.id')
                    ->join('post' , 'student.AcceptedPost_id' , '=' ,'post.id')
                    ->join('teacher' , 'student.Promoteur_interne_id','=','teacher.id')
                    ->join('representant' , 'student.Promoteur_externe_id','=','representant.id')
                    ->join('company' , 'representant.company_id','=','company.id')
                    ->select('teacher.id as id_teacher' ,'teacher.Nom as Nom_teacher','teacher.Prenom as Prenom_teacher','student.id as student_id' ,'student.Nom as Nom_student','student.Prenom as Prenom_student','company.Raison_sociale','representant.Nom as Nom_representant','representant.Prenom as Prenom_representant','user.userable_type','post.*')
                    ->where('post.Etat' ,'=' , 'Affecté')
                    ->get();

      return view('admin.projects' , ['projects_internes' => $projects_internes,
                                      'projects_externes' => $projects_externes]);   

   }


   /* Add new company */
   public function create_companie(Request $request)
   {         
        $validator = Validator::make($request->all(),[
         'username' => 'required|min:4|max:30|unique:user,username|regex:/^[a-zA-Z0-9-_\s]+$/',
         'password' => 'required|min:8|max:30|confirmed',
         'email' => 'required|email|unique:user,email|max:50',
         'rs' => 'max:100|unique:company,raison_sociale',
         'tel'=>'digits_between:9,10|unique:user,telephone|regex:/^0[0-9]{8,9}$/',
         'registre' =>'mimes:jpeg,jpg,png'
         ]);

      if($validator->fails())
      {
        return redirect()->back()->withInput($request->all())->withErrors($validator);
      }


      $user = new User();
      $user->username  =  $request->input('username');
      $user->email     =  $request->input('email');
      $user->password  =  bcrypt($request->input('password'));
      $user->telephone =  $request->input('tel');
      $user->is_Activated=1;
      $user->is_Approved=1;

      $company = new Company();
      $company->Raison_sociale = $request->input('rs'); 
      $child = $company;


      $user->save();

      if($request->hasFile('registre'))
      {
        $random_string=str_random(20);
        $path=Storage::putFileAs('public/Users/Company/RegistreDeCommerce',$request->file('registre'),$user->id.$random_string.'.jpg','public');
        $path='storage/Users/Company/RegistreDeCommerce/'.$user->id.$random_string.'.jpg';
        $child->registre_image=$path;

      }

      $child->save();
      $child->user()->save($user);  
  
      Session::flash('success', 'Vous avez bien ajouté l\'entreprise '); 
      return redirect('admin/societies');
    }

    /* Add new student */
   public function create_student(Request $request)
   {       
        $validator = Validator::make($request->all(),[
                    'nom' => 'required|max:50|regex:/^[a-zA-Z\s]+$/' , 
                    'prenom'           => 'required|max:50|regex:/^[a-zA-Z\s]+$/' , 
                    'username'             => 'required|min:4|max:30|unique:user,username|regex:/^[a-zA-Z0-9-_\s]+$/',
                    'email'           => 'required|email|unique:user,email|max:50' , 
                    'password'             => 'required|min:8|max:30|confirmed',
                    'telephone'        => 'digits_between:9,10|unique:user,Telephone|regex:/^0[0-9]{8,9}$/',
                    'matricule'=> 'required |unique:student|digits:12',
                    'specialite'=> 'required',
                    'niveau'=> 'required',
         ]);

      if($validator->fails())
      {
        return redirect()->back()->withInput($request->all())->withErrors($validator);
      }


      $user = new User();
      $user->username  =  $request->input('username');
      $user->email     =  $request->input('email');
      $user->password  =  bcrypt($request->input('password'));
      $user->telephone =  $request->input('telephone');
      $user->is_Activated=1;
      $user->is_Approved=1;

      $student = new Student();
      $student->nom        = strtoupper($request->input('nom')) ;  
      $student->prenom     = $request->input('prenom');
      $student->matricule  = $request->input('matricule') ;
      $student->specialite = $request->input('specialite') ;
      $child = $student ;

      $user->save();
      $child->save();
      $child->user()->save($user);  
  
      Session::flash('success', 'Vous avez bien ajouté l\'etudiant '); 
      return redirect('admin/monomes/students');
    }

   /* Add new teacher */
   public function create_teacher(Request $request)
   {
           
        $validator = Validator::make($request->all(),[
                    'nom' => 'required|max:50|regex:/^[a-zA-Z\s]+$/' , 
                    'prenom' => 'required|max:50|regex:/^[a-zA-Z\s]+$/' , 
                    'username' => 'required|min:4|max:30|unique:user,username|regex:/^[a-zA-Z0-9-_\s]+$/',
                    'email' => 'required|email|unique:user,email|max:50' , 
                    'password' => 'required|min:8|max:30|confirmed',
                    'tel' => 'digits_between:9,10|unique:user,Telephone|regex:/^0[0-9]{8,9}$/',
                    'grade' => 'required',
                
         ]);

      if($validator->fails())
      {
        return redirect()->back()->withInput($request->all())->withErrors($validator);
      }

      $user = new User();
      $user->username  =  $request->input('username');
      $user->email     =  $request->input('email');
      $user->password  =  bcrypt($request->input('password'));
      $user->telephone =  $request->input('tel');
      $user->is_Activated=1;
      $user->is_Approved=1;

      $teacher = new Teacher();
      $teacher->nom        = strtoupper($request->input('nom')) ;  
      $teacher->prenom     = $request->input('prenom');
      $teacher->grade      = $request->input('grade') ;
      $child = $teacher;

      $user->save();
      $child->save();
      $child->user()->save($user);  
  
      Session::flash('success', 'Vous avez bien ajouté l\'enseignant'); 
      return redirect('admin/teachers');
    }

    public function deadline_define(Request $request){

       $soumission = $request->Input('soumission');
       $validation = $request->Input('validation');
       $candidature = $request->Input('candidature');

       $soumission = explode(" - ",$soumission);
       $debut_soumission = date("Y-m-d", strtotime($soumission[0]));
       $fin_soumission = date("Y-m-d", strtotime($soumission[1]));

       $validation = explode(" - ",$validation);
       $debut_validation = date("Y-m-d", strtotime($validation[0]));
       $fin_validation = date("Y-m-d", strtotime($validation[1]));

       $candidature = explode(" - ",$candidature);
       $debut_candidature = date("Y-m-d", strtotime($candidature[0]));
       $fin_candidature = date("Y-m-d", strtotime($candidature[1]));


       if($fin_soumission >= $debut_validation){
        Session::flash('error' , 'La fin du soumission doit être avant le debut de la validation');
        return redirect('admin/settings');
       }

       if($fin_validation >= $debut_candidature){
        Session::flash('error' , 'La fin du validation doit être avant le debut de la candidature');
        return redirect('admin/settings');
       }

       DB::table('deadline')
            ->where('Phase', 'Soumission')
            ->update(['Date_debut' => $debut_soumission]);
       
       DB::table('deadline')
            ->where('Phase', 'Soumission')
            ->update(['Date_fin' => $fin_soumission]);

       DB::table('deadline')
            ->where('Phase', 'Validation')
            ->update(['Date_debut' => $debut_validation]);

       DB::table('deadline')
            ->where('Phase', 'Validation')
            ->update(['Date_fin' => $fin_validation]);

       DB::table('deadline')
            ->where('Phase', 'Candidature')
            ->update(['Date_debut' => $debut_candidature]);

       DB::table('deadline')
            ->where('Phase', 'Candidature')
            ->update(['Date_fin' => $fin_candidature]);

       Session::flash('success' , 'Deadlines bien définis');
       return redirect('admin/settings');
 
    }


   /* Delete user */
    public function delete_user(Request $request,$id)
    {
        
        $user = User::findOrFail($id);
        $temp = null;

        switch ($user->userable_type)
        {
          case 'Student': $temp='etudiant'; 
          $user->userable->Binome->Binome_id=null;
          $user->userable->Binome->save(); break;
          case 'Company': $temp='entreprise'; break;
          case 'Teacher': $temp='enseignant'; break;
        }

        $user->userable->delete();
        $user->delete();

        Session::flash('success', 'Vous avez bien supprimé l\''.$temp);
        return redirect('admin/'.$this->getRedirect($request));
    }

   /* Approve user */
    public function approve_user(Request $request,$id)
    {

      $user = User::findOrFail($id);
      $user->is_Approved=1;
      $user->save();

      return redirect('admin/'.$this->getRedirect($request));

    }
   
   /* Désapprove user */
    public function désapprove_user(Request $request,$id)
    {

      $user = User::findOrFail($id);
      $user->is_Approved=0;
      $user->save();

      return redirect('admin/'.$this->getRedirect($request));

    }

    /* Trier les entreprises */
    public function trier_companies(Request $request)
    {
      $users = DB::table('user')
                   ->join('company','user.userable_id','=','company.id')
                   ->select('user.*','company.Raison_sociale','company.registre_image',
                    'company.created_at')
                   ->where('user.is_Activated','=','1')
                   ->where('user.userable_type','=','Company')
                   ->orderBy('company.'.Input::get('option'),Input::get('type'))
                   ->get();
 
      // $users = User::with(['userable' => function($query){
      //   $query->orderBy('Raison_sociale' , 'asc');
      // }])->where('is_Activated','=',1)
      //    ->where('userable_type','=','Company')
      //    ->orderBy('userable.Raison_sociale')
      //    ->get();
     
      return view ('admin.societies',['users' => $users]);                  
    }

    /* Trier les enseignants */
    public function trier_teachers(Request $request)
    {

      $users = DB::table('user')
                   ->join('teacher','user.userable_id','=','teacher.id')
                   ->select('teacher.*','user.*')
                   ->where('user.is_Activated','=','1')
                   ->where('user.userable_type','=','Teacher')
                   ->orderBy('teacher.'.Input::get('option'),Input::get('type'))
                   ->get();

       $comissions = CommissionDeValidation::all();
    
      return view ('admin.teachers',['users' => $users , 'comissions' => $comissions]);                 
  
    }

    /* Trier les étudiants */
    public function trier_students(Request $request)
    {
    
      $users=null;
      if($request->is('*/monomes/students'))
      {

      $users = DB::table('user')
                 ->join('student','user.userable_id','=','student.id')
                 ->join('specialite','student.specialite','=','specialite.spec')
                 ->select('student.*','user.*','specialite.niveau')
                 ->where('user.is_Activated','=','1')
                 ->where('user.userable_type','=','Student')    
                 ->whereNull('student.Binome_id')
                 ->orderBy('student.'.Input::get('option'),Input::get('type'))
                 ->get();
       }


      if($request->is('*/binomes/students'))
      {

            $users = DB::table('user')
               ->join('student','user.userable_id','=','student.id')
               ->join('specialite','student.specialite','=','specialite.spec')
               ->join('student as binomes','student.Binome_id','=','binomes.id')
               ->select('student.*','specialite.niveau','binomes.nom as nom_binome','binomes.prenom as prenom_binome','user.*')
               ->where('user.is_Activated','=','1')
               ->where('user.userable_type','=','Student')
               ->orderBy('student.'.Input::get('option'),Input::get('type'))
               ->get();

       }   
    
      // $users = User::with(['userable' => function($query){
      // $query->orderBy('Raison_sociale' , 'asc');
      // }])->where('is_Activated','=',1)
      //    ->where('userable_type','=','Company')
      //    ->orderBy('userable.Raison_sociale')
      //    ->get();
     
      return view ('admin.students',['users' => $users]);                 
    }

    /* Desafect binome */
    public function desafect_binome(Request $request,$id)
    {
        
        $user = User::findOrFail($id);
        $binome = Student::findOrFail($user->userable->Binome_id);
        $user->userable->Binome_id = null;
        $binome->Binome_id = null;

        if($user->userable->AcceptedPost_id != null){
           $user->userable->AcceptedPost_id = null;
        }

        if($user->userable->Binome->AcceptedPost_id != null){
           $user->userable->Binome->AcceptedPost_id = null;
        }

        $binome->save();
        $user->userable->save();
         
        Session::flash('success', 'Binomes désafecté');
        return redirect('admin/'.$this->getRedirect($request));
    }

    /* Affectation des binomes */
    public function affect_binome(Request $request)
    {

         $validator = Validator::make($request->all(),[
           'matricule'=> 'required|digits:12|exists:student,Matricule',              
         ]);

      if($validator->fails())
      {
        return redirect()->back()->withInput($request->all())->withErrors($validator);
      }

      $matricule_binome = $request->Input('matricule');
      $id_user = $request->Input('id_user');
      
      $user=User::findOrFail($id_user);
      $binome=Student::where('Matricule',$matricule_binome)->first();
          
      $user->userable->Binome_id = $binome->id;
      $binome->Binome_id = $user->userable->id;
      if($user->userable->AcceptedPost_id != null){
        $binome->AcceptedPost_id = $user->userable->AcceptedPost_id;
      }
  
      $binome->save();
      $user->userable->save();

      Session::flash('success', 'Binomes affectés');
      return redirect('admin/monomes/students');
   
    }

    /* Delete subject */
    public function delete_subject($id)
    {
    
      $post=Post::findOrFail($id);
      $post->delete();
      Session::flash('success', 'Sujet supprimé');
      return redirect('admin/subjects');

    }

   /* Desafect teacher */
  public function desafect_teacher($id)
  {

    $user = User::findOrFail($id);
    if($user->userable->AcceptedPost_id != null && $user->userable->Promoteur_interne_id != null){
    $post = Post::where('id','=',$user->userable->AcceptedPost_id)->first();
    $post->Etat = 'En proposition';
    $post->save();

    $user->userable->AcceptedPost_id = null;
    $user->userable->Promoteur_interne_id = null;
  
    if($user->userable->Binome != null){
    $user->userable->Binome->AcceptedPost_id = null;
    $user->userable->Binome->Promoteur_interne_id = null;
    $user->userable->Binome->save();
    }

    $user->userable->save();

    $subjects_student = Post::where('Poster_id','=',$id)
                            ->get();

   foreach ($subjects_student as $subject)
   {

    if($subject->Etat == 'Affecté' || $subject->Etat == 'Bloqué')
    {
          $subject->Etat = 'En proposition';
          $subject->save();
    }

   }

   Session::flash('success', 'Encadreur désafecté');
   }

    return redirect('admin/projects');   
   }

   public function affect_promoteur_interne(Request $request)
   {

    $promoteur_interne_id = $request->Input('teacher_id');
    $student_id = $request->Input('id_student');
    $subject_id = $request->Input('id_post');
    $poster_id = $request->Input('id_user');


    $student = Student::findOrFail($student_id);
    $student->Promoteur_interne_id = $promoteur_interne_id;
    $student->AcceptedPost_id = $subject_id;
    $student->save();

    if($student->Binome != null){
           $student->Binome->AcceptedPost_id = $subject_id;
           $student->Binome->Promoteur_interne_id = $promoteur_interne_id;
           $student->Binome->save();    
    }
    
    $subjects_student = Post::where('Poster_id','=',$poster_id)->get();

    foreach ($subjects_student as $subject)
    {
          $subject->Etat = 'Bloqué';
          $subject->save();   
    }

    $post = Post::findOrFail($subject_id);
    $post->Etat = 'Affecté';
    $post->save();

    Session::flash('success', 'Encadreur affecté');

    return redirect('admin/subjects');

   }

   /* Affectation d'etudiant a un sujet */
     public function affect_student(Request $request)
     {
        $validator = Validator::make($request->all(),[
           'matricule'=> 'required|digits:12|exists:student,Matricule',              
         ]);

      if($validator->fails())
      {
        return redirect()->back()->withInput($request->all())->withErrors($validator);
      }

      $matricule = $request->Input('matricule');
      $id_sujet = $request->Input('id_subject');
      $id_teacher = $request->Input('id_teacher');

      $student = Student::where('Matricule',$matricule)->first();

      if($student->AcceptedPost_id == null){
      $post = Post::findOrFail($id_sujet);
      $post->Etat = 'Affecté';
      $student->AcceptedPost_id = $id_sujet;
      $student->Promoteur_interne_id = $id_teacher;    
      
      if($student->Binome != null){
           $student->Binome->AcceptedPost_id = $id_sujet;
           $student->Binome->Promoteur_interne_id = $id_teacher;
           $student->Binome->save();    
      }
      
      $post->save();
      $student->save();
 
        Session::flash('success', 'Etudiant affecté');
      }
      else{
        Session::flash('error', 'Désolé, cet étudiant a déja un sujet');
      }
      return redirect('admin/subjects');

   }

   /* Desafect internal project */
   public function desafect_subject_interne($id)
   {

    $user = User::findOrFail($id);

    if($user->userable->AcceptedPost_id != null && $user->userable->Promoteur_interne_id != null){
    $post_id =  $user->userable->AcceptedPost_id;
    $user->userable->AcceptedPost_id = null;
    $user->userable->Promoteur_interne_id = null;

    if($user->userable->Binome != null){
    $user->userable->Binome->AcceptedPost_id = null;
    $user->userable->Binome->Promoteur_interne_id = null;
    $user->userable->Binome->save();
    }

    $user->userable->save();
 
    $subjects_student = Post::where('Poster_id','=',$id)
                            ->get();

    $subject_teacher  = Post::findOrFail($post_id);
    $subject_teacher->Etat = 'En candidature';


    $subject_teacher->save();

   foreach ($subjects_student as $subject)
   {
    if($subject->Etat == 'Bloqué')
    {
          $subject->Etat = 'En proposition';
          $subject->save();
    }
   }

   Session::flash('success', 'Sujet désafecté');
   }
    return redirect('admin/projects');   
   }

    /* Desafect external project */ 
    public function desafect_subject_externe($id)
    {

    $user = User::findOrFail($id);

    if($user->userable->AcceptedPost_id != null && $user->userable->Promoteur_interne_id != null && $user->userable->Promoteur_externe_id != null)
    {

    $post_id =  $user->userable->AcceptedPost_id;
    $user->userable->AcceptedPost_id = null;
    $user->userable->Promoteur_interne_id = null;
    $user->userable->Promoteur_externe_id = null;
    $user->userable->save();

    $subjects_student = Post::where('Poster_id','=',$id)
                            ->get();

    $subject_teacher  = Post::findOrFail($post_id);
    $subject_teacher->Etat = 'En proposition';
    $subject_teacher->save();

   foreach ($subjects_student as $subject)
   {

    if($subject->Etat == 'Bloqué')
    {
          $subject->Etat = 'En proposition';
          $subject->save();
    }
   }

   Session::flash('success', 'Sujet désafecté');
   }
    return redirect('admin/projects');
   }

    /* Fonction pour savoir qu'elle est la page ou on doit se redirégé */
    public function getRedirect(Request $request)
    {

      $redirect=null;

      if($request->is('*/societies'))
      {  
        $redirect = 'societies'; 
      }

      if($request->is('*/teachers'))
      { 
        $redirect = 'teachers'; 
      }

      if($request->is('*/monomes*'))
      {
        $redirect = 'monomes/students'; 
      }

      if($request->is('*/binomes*'))
      {
        $redirect = 'binomes/students';
      }
      return $redirect;
    }

    public function commission_details($id)
    {

      $teachers = Teacher::where('commission_de_validation_id',$id)->get();
      $commission = CommissionDeValidation::findOrFail($id)->first();
      return view('admin.commission_details' , ['teachers' => $teachers , 'commission' => $commission]);

    }

    /* messages */

    public function messages(){
      
       $messages = Message::all();
       return view('admin.messages' , ['messages' => $messages]);

    }


    public function delete_message($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        Session::flash('success', 'Vous avez bien supprimé le message');
        return redirect('admin/messages');
    }

    /* messages */
}
