
Dropzone.options.myAwesomeDropzone =
{
    addRemoveLinks: true,
    removedfile: function(file)
    {
          var name = file.name;        
          //Removing File Dropzone
          $.ajax
          ({
              type: 'POST',
              url: '/student/'+$('#user_id').data('studentid')+'/RemoveCursusFile',
              data: "filename="+name,
              dataType: 'json' , 
              success: function(data)
              {
                 
              } , 
              error: function(data)
              {
                alert('Une erreur innattendue est survenue lors de la suppression') ;
              }
          });
          var _ref;
          return ( _ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0; 
    }
}


//Uploading existing Cursus in the dropzone 
$.ajax({
                            dataType: 'json',
                                 url: '/student/'+$('#user_id').data('studentid')+'/ExistingCursus',
                                type: 'GET',
                               

                             success: function(data)
                             {
                                

                                var myDropzone = new Dropzone("#my-awesome-dropzone");
                                
                                                           
                                 $.each(data.Files , function( index, value )
                                {
                                  i = index + 1 ; 
                                  FilenameIndex = ( data.Files[index]['name'].split('/').length )- 1 ;
                                  Filename = data.Files[index]['name'].split('/')[FilenameIndex] ;
                                 
                                 var mockFile = { name:Filename, size: data.Files[index]['size']  };
                                 myDropzone.options.addedfile.call(myDropzone, mockFile);
                                 myDropzone.options.thumbnail.call(myDropzone, mockFile,
                                window.location.origin+data.Files[index]['name']);

                                
                                }); 
                                                             
                             },

                             error: function(data)
                                 {
                                    alert('Erreur Loading Cursus !') ;
                                 },
       });



//Employee  Form validation





