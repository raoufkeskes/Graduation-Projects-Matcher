<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/','VisitorController@index');

/* Ajax routes */

//For autocomplete  Keywords
Route::get('/ajax/AllKeywords', 'KeywordController@allkeywords');

//Notifications Reset
Route::post('/ajax/ClearNotifications', 'NotificationController@Reset');

//Commenting
Route::post('/ajax/Comment', 'CommentController@store' );
Route::post('/ajax/Comment/delete', 'CommentController@delete' );

Route::post('/ajax/postuler', 'StudentController@RequestPost');
Route::post('/ajax/removePostuler', 'StudentController@DeleteRequestPost');



Route::post('/ajax/teacher/Encadrer', 'TeacherController@MentorPost');
Route::post('/ajax/teacher/removeEncadrer', 'TeacherController@DeleteMentorPost');
Route::post('/ajax/teacher/refuserPostulation', 'TeacherController@refuserPostulation');

Route::post('/ajax/company/Encadrer', 'CompanyController@MentorPost');
Route::post('/ajax/company/removeEncadrer', 'CompanyController@DeleteMentorPost');
Route::post('/ajax/company/refuserPostulation', 'CompanyController@refuserPostulation');

Route::get('/ajax/teacher/StudentDetails' , 'TeacherController@showStudentDetails'  );
  Route::get('/ajax/company/StudentDetails' , 'CompanyController@showStudentDetails'  );

Route::post('/ajax/Binome' , 'StudentController@RequestBinome' ) ;
Route::post('/ajax/RespondBinome' ,'StudentController@RespondBinome') ;
Route::post('/ajax/annulePostulation' ,'StudentController@DeleteApplication') ;

/* End Ajax routes */




Route::group(['prefix' => '{person}'  ], function () {


  //LOGIN LOGOUT
  Route::get('/login', 'UserAuth\LoginController@showLoginForm');
  Route::post('/login', 'UserAuth\LoginController@login')->name('login');
  Route::post('/logout', 'UserAuth\LoginController@logout');
  Route::get('/home', 'UserAuth\LoginController@showHome');


  //REGISTER
  Route::post('/register', 'UserAuth\RegisterController@register');
  Route::get('/SuccessRegister', 'UserAuth\RegisterController@Success' )->name('Success') ;
  Route::get('/register/confirmation/{token}','UserAuth\RegisterController@confirmation');

  //PASSWORD RESET
  Route::post('/password/email', 'UserAuth\ForgotPasswordController@sendResetLinkEmail');
  Route::post('/password/reset', 'UserAuth\ResetPasswordController@reset');
  Route::get('/password/reset', 'UserAuth\ForgotPasswordController@showLinkRequestForm');
  Route::get('/password/reset/{token}', 'UserAuth\ResetPasswordController@showResetForm');



  //POST
  Route::resource('posts', 'PostController');
  

  //User
  Route::get('/{id}/profile' , 'UserController@showProfile')->name('profile') ;
  Route::post('/{id}/profile/update' , 'UserController@updateProfile') ;
  Route::post('/{id}/resetPassword' , 'UserController@updatePassword') ;
  Route::get('/home/search', 'UserController@getSearchedPosts');

});




//Student Routes 
  Route::post('/student/{id}/Moyennes' , 'StudentController@setMoyennes') ;
  Route::post('/student/{id}/CursusUpload' , 'StudentController@Cursus');
  Route::post('/student/{id}/RemoveCursusFile' , 'StudentController@RemoveCursusFile');
  Route::get('/student/{id}/ExistingCursus' , 'StudentController@getExistingCursus' ) ;
  Route::get('/student/{id}/Binome' ,        'StudentController@BinomePage');
  Route::post('/student/{id}/RemoveBinome' , 'StudentController@RemoveBinome');
  Route::get('/student/{id}/MyApplications', 'StudentController@MyApplications');
//End Student Routes

//Teacher routes
  Route::get('/teacher/{id}/PostsTovalidate' , 'TeacherController@MyPostsTovalidate') ;
  Route::get('/teacher/PostsTovalidate/{id}' , 'TeacherController@showPostToValidate') ;
  Route::post('teacher/posts/{id}/refuser' , 'TeacherController@refuser' ) ;
  Route::post('teacher/posts/{id}/valider' , 'TeacherController@valider' ) ;
  Route::post('/teacher/posts/{id}/validerSousReserve' , 'TeacherController@validerSousReserve' ) ;
  Route::get('/teacher/{id}/MentoredPosts'   , 'TeacherController@MyMentoredPosts') ;
  Route::get('/teacher/{id}/ReceivedApplications' ,'TeacherController@ReceivedApplications') ;

//END Teacher routes

//Company Routes
  Route::get('/company/{id}/MentoredPosts'   , 'CompanyController@MyMentoredPosts') ; 
  Route::get('/company/{id}/ReceivedApplications' ,'CompanyController@ReceivedApplications') ;
//END company Routes




Route::prefix('admin')->group(function(){

/* Login */
Route::get('/login', 'AdminAuth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/login', 'AdminAuth\AdminLoginController@login')->name('admin.login.submit');
Route::post('/logout', 'AdminAuth\AdminLoginController@logout')->name('Adminlogout');


/* Admin install */
Route::post('/create', 'AdminAuth\AdminLoginController@create')->name('admin.create');

Route::get('/', 'AdminController@index')->name('admin.dashboard');
Route::get('/societies', 'AdminController@societies')->name('admin.societies');

Route::get('/monomes/students', 'AdminController@students')->name('admin.monomes.students');
Route::get('/binomes/students', 'AdminController@students')->name('admin.binomes.students');


Route::get('/subjects', 'AdminController@subjects')->name('admin.subjects');
Route::get('/projects', 'AdminController@projects')->name('admin.projects');

Route::get('/validationcom', 'AdminController@validation')->name('admin.validation');
Route::get('/comments', 'AdminController@comments')->name('admin.comments');
Route::get('/messages', 'AdminController@messages')->name('admin.messages');
Route::get('/settings', 'AdminController@settings')->name('admin.settings');
Route::get('/teachers', 'AdminController@teachers')->name('admin.teachers');

/* Create company */
Route::post('/create_company', 'AdminController@create_companie')->name('admin.create.company');

/* Create student */
Route::post('/create_student', 'AdminController@create_student')->name('admin.create.student');

/* Create teacher */
Route::post('/create_teacher', 'AdminController@create_teacher')->name('admin.create.teacher');

 
/* Approve - Désapprove - Delete User */
Route::post('/delete_user/{id}/{user}' , 'AdminController@delete_user')->name('admin.delete.user');
Route::post('/désapprove_user/{id}/{user}' , 'AdminController@désapprove_user')->name('admin.désapprove.user');
Route::post('/approve_user/{id}/{user}' , 'AdminController@approve_user')->name('admin.approve.user');

/* Trier */
Route::post('/trier/societies' , 'AdminController@trier_companies')->name('admin.trier.companies');
Route::post('/trier/monomes/students' , 'AdminController@trier_students')->name('admin.trier.monomes.students');
Route::post('/trier/binomes/students' , 'AdminController@trier_students')->name('admin.trier.binomes.students');
Route::post('/trier/teachers' , 'AdminController@trier_teachers')->name('admin.trier.teachers');

/* Affecte desafecte binome */
Route::post('/desefact_binome/{id}/{user}' , 'AdminController@desafect_binome')->name('admin.desafect.binome');
Route::post('/affect_binome/{user}' , 'AdminController@affect_binome')->name('admin.affect.binome');

/* Delete subject */
Route::post('/delete/{id}/subject' , 'AdminController@delete_subject')->name('admin.delete.subject');

/* Desafect teacher */
Route::post('/desafact_teacher/{id}' , 'AdminController@desafect_teacher')->name('admin.desafect.teacher');

/* Desafect subject */
Route::post('/desafect_subject/{id}' , 'AdminController@desafect_subject_interne')->name('admin.desafect.subject_interne');
Route::post('/desafect_subject/{id}' , 'AdminController@desafect_subject_externe')->name('admin.desafect.subject_externe');

Route::post('/create_comission' , 'AdminController@create_comission')->name('admin.create.comission');
Route::post('/add_to_comission' , 'AdminController@add_to_comission')->name('admin.affect.commit');
Route::post('/affect_comission' , 'AdminController@affect_comission')->name('admin.affect.comission');
Route::post('/delete_from_comission/{id}' , 'AdminController@delete_from_comission')->name('admin.desafect.commit');

Route::post('/delete_comission/{id}' , 'AdminController@delete_comission')->name('admin.delete.commission');
/* Important */

/* Affect teacher to internal subject */
Route::post('/affect_teacher_internal' , 'AdminController@affect_promoteur_interne')->name('admin.affect.teacher');


/* Affect student to subject */
Route::post('/affect_student/' , 'AdminController@affect_student')->name('admin.affect.student.subject');

Route::post('/desaffect_comission/{id}' , 'AdminController@desaffect_commit_subject')->name('admin.desafect.comission');

Route::get('/auto_affect' , 'AdminController@auto_affect_commission')->name('admin.auto.affect');
Route::post('/deadlines' , 'AdminController@deadline_define')->name('admin.deadlines');
Route::get('/commit_details/{id}' , 'AdminController@commission_details')->name('admin.commit.details');

/* Important */

/* messages */
Route::get('/messages' ,'AdminController@messages')->name('admin.messages');
Route::post('/delete_message/{id}' , 'AdminController@delete_message')->name('admin.delete.message');
/* messages */


});
/* Admin */

/* Visiteur */

Route::post('/send_msg' , 'VisitorController@send_message')->name('visiteur.send_msg');