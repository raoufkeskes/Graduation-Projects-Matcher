
//SETUP //
 $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    }
             });


$(document).ready(function(){

    /* Default settings */
    var theme_settings = {
        st_head_fixed: 0,
        st_sb_fixed: 1,
        st_sb_scroll: 1,
        st_sb_right: 0,
        st_sb_custom: 0,
        st_sb_toggled: 0,
        st_layout_boxed: 0
    };
    /* End Default settings */
    
    set_settings(theme_settings,false);    



    
    
});


$('#Notif').click(function()
{
    
    $.ajax
            ({
                            dataType: 'json',
                                 url: '/ajax/ClearNotifications',
                                type: 'POST',
                                data: { 
                                          'user_id'      : $(this).data('userid') , 
                                      },
                                success:function(data)
                                {
                                    
                                },
                                error:function(data)
                                {
                                    
                                }
            });
}) ;

function set_settings(theme_settings,option){
    
    /* Start Header Fixed */
    if(theme_settings.st_head_fixed == 1)
        $(".page-container").addClass("page-navigation-top-fixed");
    else
        $(".page-container").removeClass("page-navigation-top-fixed");    
    /* END Header Fixed */
    
    /* Start Sidebar Fixed */
    if(theme_settings.st_sb_fixed == 1){        
        $(".page-sidebar").addClass("page-sidebar-fixed");
    }else
        $(".page-sidebar").removeClass("page-sidebar-fixed");
    /* END Sidebar Fixed */
    
    /* Start Sidebar Fixed */
    if(theme_settings.st_sb_scroll == 1){          
        $(".page-sidebar").addClass("scroll").mCustomScrollbar("update");        
    }else
        $(".page-sidebar").removeClass("scroll").css("height","").mCustomScrollbar("disable",true);
    
    /* END Sidebar Fixed */
    
    /* Start Right Sidebar */
    if(theme_settings.st_sb_right == 1)
        $(".page-container").addClass("page-mode-rtl");
    else
        $(".page-container").removeClass("page-mode-rtl");
    /* END Right Sidebar */
    
    /* Start Custom Sidebar */
    if(theme_settings.st_sb_custom == 1)
        $(".page-sidebar .x-navigation").addClass("x-navigation-custom");
    else
        $(".page-sidebar .x-navigation").removeClass("x-navigation-custom");
    /* END Custom Sidebar */
    
    /* Start Custom Sidebar */
    if(option && option === 'st_sb_toggled'){
        if(theme_settings.st_sb_toggled == 1){
            $(".page-container").addClass("page-navigation-toggled");
            $(".x-navigation-minimize").trigger("click");
        }else{          
            $(".page-container").removeClass("page-navigation-toggled");
            $(".x-navigation-minimize").trigger("click");
        }
    }
    /* END Custom Sidebar */
    
    /* Start Layout Boxed */
    if(theme_settings.st_layout_boxed == 1)
        $("body").addClass("page-container-boxed");
    else
        $("body").removeClass("page-container-boxed");
    /* END Layout Boxed */

    
    /* Call resize window */
    
    /* End call resize window */



}

