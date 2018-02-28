

/*Formulaire JS*/
$('.form').find('input, textarea').on('keyup blur focus', function (e) {
  
  var $this = $(this),
      label = $this.prev('label');


	  if (e.type === 'keyup'   )
    {
    			if ($this.val() === ''  )
        {
              label.removeClass('active highlight');
        } else
        {
              label.addClass('active highlight');
        }

    } 

    else if (e.type === 'blur') 
    {
    	if($this.val() === ''  ) 
      {
    		label.removeClass('active highlight'); 
			} 
      else
      {
		    label.removeClass('highlight');   
			}   

    } 

    else if (e.type === 'focus')
    {
      
        if( $this.val() === '' ) 
        {
      		label.removeClass('highlight'); 
  			} 
        else if( $this.val() !== '' )
        {
  		    label.addClass('highlight');
  			}
    }
    

});


 //by raouf to fix  inputs values with labels UP when reloading form page 
 $(document).ready(function() 
  {
    
    $("input").each(function()
    {

        var $this = $(this),
          label = $this.prev('label');

          if ($this.val() === ''  )
            {
                  label.removeClass('active highlight');
            } else
            {
                  label.addClass('active highlight');
            }

    });

      
      
      
    
  }) ; 
 /* end raouf */




$('.tab a').on('click', function (e) {
  
  e.preventDefault();
  
  $(this).parent().addClass('active');
  $(this).parent().siblings().removeClass('active');
  
  target = $(this).attr('href');

  $('.tab-content > div').not(target).hide();
  
  $(target).fadeIn(600);
  
});






/*End Formulaire Js*/ 

/*Select Box js*/
$('.drop-menu').click(function () 
    {
        $(this).attr('tabindex', 1).focus();
        $(this).toggleClass('active');
        $(this).find('.dropeddown').slideToggle(300);
    });

$('.drop-menu').focusout(function () 
  {
        $(this).removeClass('active');
        $(this).find('.dropeddown').slideUp(300);
  });
    
$('.drop-menu .dropeddown li').click(function () 
    {
        $(this).parents('.drop-menu').find('span').text($(this).text());
        

        /*by raouf*/ 
        if ($(this).text() == "Licence")
        {
              $(".Licence").show();
              $(".Master").hide();
        }
        else 
        {
            $(".Master").show();
            $(".Licence").hide();
        }
          /*in all cases we will fill the input in MASTER LICENCE & TEACHER GRADES  because we need it in the form  */ 
          $(this).parents('.drop-menu').find('input').attr('value', $(this).text());
        


        color();

      /*by raouf */
    });
/*End Select Box js*/



/*by raouf */
function color() { 
  document.getElementById("Selectniveau").style.color = 'white';
}
/*by raouf for loading */ 

$( "#loadingbutton" ).click(function() 
  { 
    if ( ! (  $("input[name='email']").val()===''   ) )
      
      {
        $("#loading").removeClass('hidden') ;
        $(".error-msg").addClass('hidden') ;
        $(".success-msg").addClass('hidden') ;
      }
});

