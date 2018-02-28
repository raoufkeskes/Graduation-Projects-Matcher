(function ($) {
    
    // Init Wow
    wow = new WOW( {
        animateClass: 'animated',
        offset:       100
    });
    wow.init();
    
    
     //  Logo scroll  by Raouf
     
    /* $(".navbar-brand").on('click', function(event) {

        event.preventDefault();
        var hash = this.hash;
        $('html, body').animate({
            scrollTop: $(hash).offset().top
        }, 1500, function(){
            window.location.hash = hash;
            

        });

    });*/
    

    //smoothscroll   New By Raouf  fixing previous Active navbar item  bugs
    $(document).ready(function () {
    $(document).on("scroll", onScroll);
    
    
    $('.bg-color a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        $(document).off("scroll");
        
       /* $('a').each(function () {
            $(this).removeClass('active');
        })
        $(this).addClass('active');*/
      
        var target = this.hash,
            menu = target;
        $target = $(target);
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top-65
        }, 1500 , 'swing', function () {
            /*window.location.hash = target;*/   // To Hide the hashtag  by raouf 
            $(document).on("scroll", onScroll);
            

        });
    });
});

function onScroll(event){
   
    $(".nav li").on("click", function() 
    {

                 /* $(".nav li").removeClass("active");
                  $(this).addClass("active");*/
    });

}

   

   

       
    //jQuery to collapse the navbar on scroll
    $(window).scroll(function() {
        if ($(".navbar-default").offset().top > 50) {
            $(".navbar-fixed-top").addClass("top-nav-collapse");
        } else {
            $(".navbar-fixed-top").removeClass("top-nav-collapse");
        }
    });

    // By Nacer 

      
      $(function () {

        $("#boxwords").wordsrotator({
          words: ['Etudiant','Enseignant','Entreprise']
        });
    
            });
        
    
    // Testimonials Slider
    $('.bxslider').bxSlider({
      adaptiveHeight: true,
      mode: 'fade'
    });


    // ===== Scroll to Top ==== 
    $(window).scroll(function() {
        if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
            $('#return-to-top').fadeIn(200);    // Fade in the arrow
        } else {
            $('#return-to-top').fadeOut(200);   // Else fade out the arrow
        }
    });
    





    
})(jQuery);