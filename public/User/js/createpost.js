    var selectedValue ; 

    //select  the retrieved post Values 

    //domaine  

    
    
    
    
    // if it has no old value  for  create & update
    if ( $('#selectdomaine').data('domaine')  )
    {

         selectedValue = $('#selectdomaine').data('domaine') ;
        $("#selectdomaine").val(selectedValue);
    }
    else if ($('#selectdomaine').data('old') )
    {
         selectedValue = $('#selectdomaine').data('old') ;
        $("#selectdomaine").val(selectedValue);
    }

    //oriente  same
    if ( $('#oriente').data('oriente') )
    {
        selectedValue = $('#oriente').data('oriente') ;
        $("#oriente").val(selectedValue);
    }
    else if ($('#oriente').data('old'))
    {
        selectedValue = $('#oriente').data('old') ;
        $("#oriente").val(selectedValue);
    }

    var res ; 

    

    if($('#destinea').data('destinea') )
    {
        res = $('#destinea').data('destinea').split(",") ;
    }
    else if ( $('#destinea').data('old'))
    {
        res = $('#destinea').data('old').split(",") ;
    }
    
    
    //destine a   checkboxes
    $("#destinea option").each(function(i){

        if (   jQuery.inArray(  ($(this).val())    , res )  >=  0 )

          $(this).attr('selected','selected');
    });