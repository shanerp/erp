$(document).ready(function(){
    
    /* Toggle left panel menu */
    $(document).on("click", "#toggle", function(e){
        e.preventDefault();
        $(this).next('.sub_menu').slideToggle(300);
        var cls = $(this).children('.glyphicon').attr('class');
        
        if ( cls.indexOf('glyphicon-triangle-right') > -1 )
            $(this).children('.glyphicon').toggleClass('glyphicon-triangle-bottom');
        else if ( cls.indexOf('glyphicon-triangle-bottom') > -1 )
            $(this).children('.glyphicon').toggleClass('glyphicon-triangle-right');
            
        if ( cls.indexOf('glyphicon-plus') > -1 )
            $(this).children('.glyphicon').toggleClass('glyphicon-minus');
        else if ( cls.indexOf('glyphicon-minus') > -1 )
            $(this).children('.glyphicon').toggleClass('glyphicon-plus');
    })
        
    $('.left_panel_toggle_btn').click(function(){
        var cls = $(this).attr('class');
        if ( cls.indexOf('open_left_panel_btn') > -1 ) {
            // Left panel is close now, so open it
            $('.left-panel').animate({left: '0'}, 150);
            $('.left_panel_toggle_btn').removeClass('glyphicon-menu-right');
            $('.left_panel_toggle_btn').addClass('glyphicon-menu-left');
            $('.dashboard-content').animate({'margin-left': '250px'}, 150);
            $(this).removeClass('open_left_panel_btn');
        }
        else {
            // Left panel is open now, so close it
            $('.left-panel').animate({left: '-250px'}, 150);
            $('.left_panel_toggle_btn').removeClass('glyphicon-menu-left');
            $('.left_panel_toggle_btn').addClass('glyphicon-menu-right');
            $('.dashboard-content').animate({'margin-left': '0'}, 150);
            $(this).addClass('open_left_panel_btn');
        }
        return false;
    });
    
    /* highlighting activar menu */
    var str=location.href.toLowerCase();
    $(".navigation .sub_menu > li > a").each(function() {
        if (str.indexOf(this.href.toLowerCase()) > -1) {
            $(this).addClass("active");
        }
    });
});

    /* Open/Close Left Panel */
    device_width = $(window).width();
    if ( device_width <= 768 )
    {
        $('.left-panel').css('left','-250px');
        $('.left_panel_toggle_btn').addClass('open_left_panel_btn');
        $('.left_panel_toggle_btn').removeClass('glyphicon-menu-left');
        $('.left_panel_toggle_btn').addClass('glyphicon-menu-right');
    }

    