
//SETUP //
 $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
             });





var Student , Binome, toggle = 'Binome' ;




//checkbox employes
$('#checkbox1').change(function()
{

   if($(this).is(":checked")) {
      $('#newEmploye').hide() ;
      $('#oldEmploye').removeClass('hidden') ; 
       

   }
   else
   {  
      $('#oldEmploye').addClass('hidden') ; 
      $('#newEmploye').show() ; 
   }   
});


$('.refuserPostulation').click(function()
{
      $Type = $(this).parent().data('type');
      
       $.ajax
            ({
                            dataType: 'json',
                                 url: '/ajax/'+$Type+'/refuserPostulation',
                                type: 'POST',
                                data: { 
                                          'post_id'      : $(this).parent().data('postid') , 
                                          'student_id'   : $(this).parent().data('studentid') ,
                                          'notif_type'   : 'postulation'
                                      },

                             success: function(data)
                             {
                              
                              $noty = noty({text: 'Postulation refusée avec Succès'
                                        , layout: 'topCenter'  , type: 'success'   });
                                    setTimeout(function() {
                                        $noty.close() ;
                                    }, 4000 );
                             
                              $('#'+data['post_id']+" ."+data['poster_id']).fadeOut();
                              $('#'+data['post_id']+" ."+data['binome_id']).fadeOut();
                             },

                             error: function(data)
                                 {
                                    alert('Erreur !') ;
                                 },


            });

});


$('.AccepterPostulation').click(function()
{
      $Type = $(this).parent().data('type');
      
       $.ajax
            ({
                            dataType: 'json',
                                 url: '/ajax/'+$Type+'/Encadrer',
                                type: 'POST',
                                data: { 
                                          'user_id'      : $(this).parent().data('userid') ,
                                          'post_id'      : $(this).parent().data('postid') , 
                                          'student_id'   : $(this).parent().data('studentid') ,
                                          'notif_type'   : 'postulation'

                                      },

                             success: function(data)
                             {
                              
                              $noty = noty({text: 'Vous êtes maintenant le promoteur de cet étudiant !'
                                        , layout: 'topCenter'  , type: 'success'   });
                                    setTimeout(function() {
                                        $noty.close() ;
                                    }, 8000);
                              $('#'+data['post_id']+'').fadeOut() ;
                              $("."+data['poster_id']).fadeOut();
                              $('.'+data['binome_id']).fadeOut();
                             },

                             error: function(data)
                                 {
                                     
                                     var error = data.responseJSON.msg;

                                     var poster_id = data.responseJSON.poster_id;
                                     var binome_id = data.responseJSON.binome_id;
                                     //display the error message for 8 seconds*

                                      $noty =  noty({text: error
                                            , layout: 'topCenter'  , type: 'error'   }) ;
                                        setTimeout(function() {
                                            $noty.close() ;
                                        }, 8000);   
                                  
                                    
                                    //End  display
                                   
                                    //remove others Applications
                                    $("."+poster_id).fadeOut();
                                    $('.'+binome_id).fadeOut();
                                    
                                 },


            });

});

$('.AccepterPostulationCompany').click(function()
{
      
    $('#AcceptCompany').data('userid', $(this).parent().data('userid') ) ;
    $('#AcceptCompany').data('postid', $(this).parent().data('postid') ) ;
    $('#AcceptCompany').data('studentid', $(this).parent().data('studentid') ) ;  

    

});

$('#AcceptCompany').click(function()
{

      
      
      if(  ( form.valid() )   )
         { 
            alert($('#selectEmployee').val()) ;
            $('#checkbox1').val($('#selectEmployee').val()) ;
           //close the window after clicking on Yes
            $('#mb-encadrer').removeClass("open");
          
            $.ajax
            ({
                            dataType: 'json',
                                 url: '/ajax/company/Encadrer',
                                type: 'POST',
                                data: { 
                                          'user_id'   : $(this).data('userid') ,
                                          'post_id'   : $(this).data('postid') ,
                                          'student_id': $(this).data('studentid') ,
                                          'form'      : form.serialize(),
                                          'notif_type'   : 'postulation'
                                      },

                             success: function(data)
                             {
                              
                              $noty = noty({text: 'Vous êtes maintenant le promoteur de cet étudiant !'
                                        , layout: 'topCenter'  , type: 'success'   });
                                    setTimeout(function() {
                                        $noty.close() ;
                                    }, 8000);
                              $('#'+data['post_id']+'').fadeOut() ;
                              $("."+data['poster_id']).fadeOut();
                              $('.'+data['binome_id']).fadeOut();
                             },

                             error: function(data)
                                 {
                                     
                                     var error = data.responseJSON.msg;

                                     var poster_id = data.responseJSON.poster_id;
                                     var binome_id = data.responseJSON.binome_id;
                                     //display the error message for 8 seconds*

                                      $noty =  noty({text: error
                                            , layout: 'topCenter'  , type: 'error'   }) ;
                                        setTimeout(function() {
                                            $noty.close() ;
                                        }, 8000);   
                                  
                                    
                                    //End  display
                                   
                                    //remove others Applications
                                    $("."+poster_id).fadeOut();
                                    $('.'+binome_id).fadeOut();
                                    
                                 },


            });
          
         }
    
     

});




   
//^postuler button
$('.postuler').click(function(){
    if($(this).hasClass('active'))
    {
        $(this).removeClass('active') ;
        $(this).html('<span class="fa fa-star"></span>Postuler');
        
        
        $.ajax
        ({
                          dataType: 'json',
                               url: '/ajax/removePostuler',
                              type: 'POST',
                              data: { 
                                        'user_id' : $(this).data('userid') ,
                                        'post_id' : $(this).data('postid') ,
                                    },

                           success: function(data)
                           {
                             $noty = noty({text: 'Vous venez de retirer votre postulation pour '+data['title']
                                , layout: 'topCenter'  , type: 'error'   });
                             setTimeout(function() {
                                      $noty.close() ;
                                  }, 8000);
                             
                           }
                           

        });
       
        
    } 
    else 
    {
        $(this).addClass('active') ;
    
        $(this).html('<span class="fa fa-check-circle"></span> Déjà Postulé');
        $.ajax
        ({
                          dataType: 'json',
                               url: '/ajax/postuler',
                              type: 'POST',
                              data: { 
                                        'user_id' : $(this).data('userid') ,
                                        'post_id' : $(this).data('postid') ,

                                    },

                           success: function(data)
                           {
                             $noty = noty({text: 'Vous venez de postuler pour '+data['title']+' avec succès'
                                , layout: 'topCenter' , type: 'success'  });
                             setTimeout(function() {
                                      $noty.close() ;
                                  }, 8000);
                             
                           },
                           error:function(data)
                           {
                              var error = data.responseJSON.msg ;
                              $noty =  noty({text: error
                                            , layout: 'topCenter'  , type: 'error'   }) ;
                                    setTimeout(function() {
                                                $noty.close() ;
                                                location.reload();
                                            }, 5000); 
                           }

        });

    }
});          


$('#Binome').click(function() 
        {
          
            
            $.ajax
              ({
                                dataType: 'json',
                                     url: '/ajax/Binome',
                                    type: 'POST',
                                    data: { 
                                              'user_id'   : $(this).data('userid') ,
                                              'matricule' : $('[name="matricule"]').val() ,
                                          },

                                 success: function(data)
                                 { 
                                    $noty = noty({text: data.Nom+" "+data.Prenom+' vient de recevoir votre demande'
                                        , layout: 'topCenter'  , type: 'success'   });
                                    setTimeout(function() {
                                        $noty.close() ;
                                    }, 8000);
                                 }
                                 , 
                                 error: function(data)
                                 {
                                     var errors = data.responseJSON.errors;
                                     var check  = data.responseJSON.check;
                                           strErrors ="Erreurs ! <br />" ;
                                     for (var i = 0 ; i < errors.length ; i++)
                                           {
                                               strErrors = strErrors + '- '+errors[i] +"<br />" ;
                                           }

                                      // Render the errors with js ...
                                       

                                      
                                        $noty =  noty({text: strErrors
                                            , layout: 'topCenter'  , type: 'error'   }) ;
                                        setTimeout(function() {
                                            $noty.close() ;
                                            if ( check =='current_student') 
                                            {
                                              location.reload() ;
                                            }
                                        }, 8000);   
                                  }
              });
         });

//End request binome



//Encadrer 
$('.Encadrer').click(function(){
    //passing post data  to  Yes Button
    $('#YesEncadrer').data('postid',$(this).data('postid')); 
    $('#YesEncadrer').data('userid',$(this).data('userid')); 
    $('#YesEncadrer').data('studentid',$(this).data('studentid')); 
});


$('#YesEncadrer').click(function(){

   
    
    var userType = $(this).data('type') ;    
    var post_id = ($(this).data('postid'));
    var targetButton ='.btn-rounded[data-postid='+post_id+']' ;
    
    
    if($(targetButton).hasClass('active'))
    {
       

       $('#mb-encadrer').removeClass("open");
        form.show();
        form.trigger('reset');
        $(targetButton).removeClass('active') ;
        $('#question').text('Êtes-vous sûr de bien vouloir être le promoteur de ce sujet ?') ;
        $(targetButton).html('<span class="fa fa-star"></span>Encadrer');
        $.ajax
        ({
                          dataType: 'json',
                               url: '/ajax/'+userType+'/removeEncadrer',
                              type: 'POST',
                              data: { 
                                        'user_id' : $(this).data('userid') ,
                                        'post_id' : $(this).data('postid') ,
                                        'student_id': $(this).data('studentid') ,
                                        'notif_type'   : 'encadrement'
                                    },

                           success: function(data)
                           {
                             //Notification
                             $noty =  noty({text: "Vous n'êtes plus promoteur de ce sujet : "+data['title']
                                , layout: 'topCenter'  , type: 'error'   });
                              // refresh  Students Posts list   
                             $("."+data['poster_id']+"[data-postid != '"+data['post_id']+"']").fadeIn();
                              $("."+data['binome_id']).fadeIn();
                             setTimeout(function() {
                                      $noty.close() ;
                                  }, 8000);
                             

                             // End notification

                            

                             //update Select options  for company
                             if(data['remove'])
                              $("#selectEmployee option[value='"+data['remove']+"']").remove();
                             // end 

          
                           }

        });
    }
    else
    {  
          
         if(  (userType == 'company' &&  form.valid() )  ||  userType == 'teacher' )
         { 
           //pass data from the select to the checkbox value   because form serialize  gives only checkbox
           $('#checkbox1').val($('#selectEmployee').val()) ;
           //close the window after clicking on Yes
           $('#mb-encadrer').removeClass("open");
           //hide the form to prepare next click RemoveEncadrer
           form.hide();
           // Designing the button  Encadrer / Déjà Encadré
           $(targetButton).addClass('active') ;
           $(targetButton).html('<span class="fa fa-check-circle"></span> Déjà Encadré');
           $('#question').text('Vous ne voulez plus être le promoteur de cet étudiant ?') ;
           //End
           
           $.ajax
            ({
                            dataType: 'json',
                                 url: '/ajax/'+userType+'/Encadrer',
                                type: 'POST',
                                data: { 
                                          'user_id'   : $(this).data('userid') ,
                                          'post_id'   : $(this).data('postid') ,
                                          'student_id': $(this).data('studentid') ,
                                          'form'      : form.serialize(),
                                          'notif_type'   : 'encadrement'
                                      },

                             success: function(data)
                             {
                               $noty =  noty({text: 'Vous êtes maintenant promoteur de ce sujet : '+data['title']
                                    
                                  , layout: 'topCenter'  , type: 'success'   });
                               // refresh  Students Posts list   by deleting accepted student post & its binome s post 
                               // too
                               $("."+data['poster_id']+"[data-postid != '"+data['post_id']+"']").fadeOut();
                              $("."+data['binome_id']).fadeOut();

                               setTimeout(function() {
                                      $noty.close() ;
                                  }, 8000);
                             },
                             error: function(data)
                                 {
                                     
                                     var error = data.responseJSON.msg;
                                     var poster_id = data.responseJSON.poster_id;
                                      var binome_id = data.responseJSON.binome_id;
                                    
                                     //display the error message for 8 seconds*
                                     $noty =  noty({text: error
                                    , layout: 'topCenter'  , type: 'error'   });
                                     setTimeout(function() {
                                      $noty.close() ;
                                    }, 8000);
                                    //End  display*
                                    // refresh  Students Posts list   by deleting accepted student post & its binome s post 
                                    // too
                                    $("."+poster_id).fadeOut();
                                    $("."+binome_id).fadeOut();
                                    
                                 }


            });
         }
    }
    
});

$('.custom').click(function(){
    //passing post data  to  Yes Button

   if ( $(this).attr('name') == 'refuse' )
       $('#'+$(this).parent().data('studentid')).fadeOut();

    $.ajax
              ({
                                dataType: 'json',
                                     url: '/ajax/RespondBinome',
                                    type: 'POST',
                                    data: { 
                                              'respond'   : $(this).attr('name') ,
                                              'student_id': $(this).parent().data('studentid') ,
                                              'user_id':$(this).parent().data('userid')
                                          },

                                 success: function(data)
                                 { 
                                    $noty =  noty({text: data.msg
                                            , layout: 'topCenter'  , type: 'success'   }) ;
                                    setTimeout(function() {
                                                $noty.close() ;
                                                if (data.check == 'accept')
                                                location.reload();
                                            }, 5000); 

                                 }
                                 , 
                                 error: function(data)
                                 {
                                     var errors = data.responseJSON.errors;
                                     var check  = data.responseJSON.check;
                                    
                                     $noty =  noty({text: errors
                                            , layout: 'topCenter'  , type: 'error'   }) ;
                                       
                                       if ( check =='current_student') 
                                      {
                                          setTimeout(function() {
                                                $noty.close() ;
                                                location.reload();
                                            }, 5000); 
                                      }
                                      else
                                      {
                                        setTimeout(function() {
                                                $noty.close() ;    
                                            }, 5000); 
                                        var requesterToDelete_id = data.responseJSON.toDelete ;
                                        $('#'+requesterToDelete_id).fadeOut() ;
                                        
                                         if ($('.List list-group-item').length == 0 )
                                         {
                                            $('#MasterDiv').append('Aucune Demande Binome ne vous a été envoyé') ;
                                         }
                                      }
                                     
                                     
                                 }
              });

});

 $('.annulePostulation').click(function()
{
      
    
       $.ajax
            ({
                            dataType: 'json',
                                 url: '/ajax/annulePostulation',
                                type: 'POST',
                                data: { 
                                          'post_id'      : $(this).data('postid') , 
                                          'student_id'   : $(this).data('studentid') 
                                      },

                             success: function(data)
                             {
                                 $('#'+data.post_id).fadeOut() ;
                             },

                             error: function(data)
                                 {
                                    alert("Erreur innatendue lors de l'annulation de postulation") ;
                                 },


            });
});

$('a[data-target="#modal_basic"]').click(function(){
  
 
  $('#modal_basic').data('userid',$(this).data('userid')); 
  ResetStudentFileds() ;
  
}) ;

//Student Details Modal
  $('#modal_basic').on('shown.bs.modal', function () {
    
    
    var type = $(this).data('type');
    
    $.ajax
            ({
                            dataType: 'json',
                                 url: '/ajax/'+type+'/StudentDetails',
                                type: 'GET',
                                data: { 
                                          'user_id' : $(this).data('userid')
                                      },
                                
                             success: function(data)
                             {
                               
                               Student = data.Student ;
                               Binome  = data.Binome ;
                               FillStudentFileds(Student) ;
                                

                               $('#Loading').addClass('hidden') ;
                               $('#StudentData').removeClass('hidden') ;
                             }

            });
});

$("#modal_basic").draggable({
    handle: ".modal-header"
});
//End Modal



$(document).on("click", ".deleteComment", function(){
  
    $(this).parent().fadeOut(function() { $(this).remove(); } ) ;
    $.ajax
               ({
                            dataType: 'json',
                                 url: '/ajax/Comment/delete',
                                type: 'POST',
                                data: { 
                                          'id' : $(this).data('id') ,
                                      },

                             success: function(data)
                             {
                                
                             },

                             error: function(data)
                                 {
                                    alert("Erreur lors de la suppression du commentaire !") ;
                                 }
               });
});


$('#commentBtn').click(function()
{
  a = $('#comment-write').val() ;
  $('#comment-write').val('') ;
  if (!a.trim()  )
      alert("Il est impossible d'inserer un commentaire vide") ;
  else
    {
               $.ajax
               ({
                            dataType: 'json',
                                 url: '/ajax/Comment',
                                type: 'POST',
                                data: { 
                                          'user_id' : $(this).data('userid') ,
                                          'post_id' : $(this).data('postid') ,
                                          'content' : a ,
                                      },

                             success: function(data)
                             {
                               
                                $('.addedComments').append('<li class="media">'+
                                            '<a class="pull-left" href="#">'+
                                                '<img class="media-object img-text"'+
                                                'src="/'+data.comment.imagePath+'" alt="" width="64">'+
                                            '</a>'+
                                            '<a class="pull-right deleteComment" data-id="'+data.comment.id+'" >Supprimer</a>'+
                                            '<div class="media-body">'+
                                                '<h4 class="media-heading">'+
                                                  data.comment.commentator+
                                                '</h4>'+
                                                '<p>'+data.comment.content+'</p>'+
                                                '<p class="text-muted">'+data.comment.created+'</p>'+
                                                                                                                                        
                                            '</div> '+                                           
                                        '</li>') ;
                                

                             },

                             error: function(data)
                                 {
                                    alert("Erreur lors de l'ajout du commentaire !") ;
                                 }
               });
    }
});






function passarray(array)
{
  $.each(array, function(i, obj) {
  $('.modal-body ol').append('<li>'+obj+'</li>');
});
  
}

//Functions


// display the uploaded  image live 
function readURL(input) {
    
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('.blah').attr('width', '100%');
            $('.blah').attr('height', '100%');
            $('.blah').attr('src', e.target.result);
               
            $('.gallery-item').attr('href',e.target.result) ;
        };

        reader.readAsDataURL(input.files[0]);
    }
}







 function notyConfirm(){
                    noty({
                        text: 'Do you want to continue?',
                        layout: 'topRight',
                        buttons: [
                                {addClass: 'btn btn-success btn-clean', text: 'Ok', onClick: function($noty) {
                                    $noty.close();
                                    noty({text: 'You clicked "Ok" button', layout: 'topRight', type: 'success'});
                                }
                                },
                                {addClass: 'btn btn-danger btn-clean', text: 'Cancel', onClick: function($noty) {
                                    $noty.close();
                                    noty({text: 'You clicked "Cancel" button', layout: 'topRight', type: 'error'});
                                    }
                                }
                            ]
                    })                                                    
                } 


//pop up 


function FillStudentFileds(Student)
{
   // Filling student Data
                               $('#nom').text(Student.Nom) ;
                               $('#prenom').text(Student.Prenom) ;
                               $('#matricule').text(Student.Matricule) ;
                               $('#email').text(Student.email) ;
                               $('#specialite').html(Student.specialite.niveau+' '+Student.specialite.spec
                                +'<br>'+Student.specialite.label) ;
                               if (Student.Statut == 'Monome')
                                  $('#etat').text('Monôme');
                               else
                                  $('#etat').html('Binôme   (<a onClick="test()" >Voir les Détails du Binôme </a>)');
                               
                               /*Filling Moyennes */
                               $.each(Student.Moyennes, function(key, value) {
                                $('#'+key).text(value);
                              });

                               // remove labels  of master s student if he s Licence 
                               if ( Student.specialite.niveau == 'Licence' )
                               {
                                  $('#L3').prev('label').remove(); 
                                  $('#L3').remove() ;
                                   $('#M1').prev('label').remove();
                                  $('#M1').remove() ;
                               }

                               // Cursus images 
                                $.each(Student.images, function(key, value) {
                                
                                $('#links').append(
                                 '<div class="col-md-4">'+
                                            '<a class="gallery-item" href="/'+value+'" title="Cursus" data-gallery>\
                                                <div class="image">'+                 
                                                    '<img src="/'+value+'" alt="Cursus"/>'+                                                                                                        
                                                '</div>'+                                
                                            '</a>'+
                                  '</div>') ;
                                 });
                                //End Cursus images
}

function ResetStudentFileds()
{
                              $('#links div').remove() ;                              
}



function test()
{
  var param ;
  if ( toggle == 'Binome' )
  {
     param = Binome ;
     toggle = 'Student' ;
  }
  else
  {
    param = Student ;
    toggle = 'Binome' ;
  }
  ResetStudentFileds() ;
  FillStudentFileds(param) ;
  
}
// END functions
