(function($){
    // CP-perfilOptions
    //----------------------------------------//
    $(".CP-user").on('mouseenter', function(){
        $('.CP-perfilOptionsWrapper').fadeIn(200);
        $('.CP-user').addClass('CP-userHovered');
    });

    $(".CP-perfilOptionsWrapper").on('mouseleave', function(){
        $(this).fadeOut(100);
        $('.CP-user').removeClass('CP-userHovered');
    });

    // CP-PopUp
    //----------------------------------------//
    if ($.cookie('PopUp-status')=='clicked'){
        $('.PopUp').css('display','none');
    }
    setTimeout(function(){$('.PopUp-container').addClass('PopUp-active')},500);
    $('.PopUp-yes').click(function(event){
        event.preventDefault();
        $.cookie('PopUp-status','clicked');
        $('.PopUp-container').removeClass('PopUp-active');
        setTimeout(function(){$('.PopUp').fadeOut()},400);
    });
    // ParallaxImg
    //----------------------------------------//
    function ParallaxImg(){
    var tittle = $('.parallax-titlebar');
    var banner = $('.parallax-banner');
    var modificador;
    var altoContainer;
    var clase;
    if(tittle.length==0&&banner.length==1)
    {
        altoContainer=200;
        modificador=banner;
        clase="ParallaxImg-banner";
    }
    else
    {
        altoContainer=160;
        modificador=tittle;
        clase="ParallaxImg";
    }
    
    var altoImg = $(modificador).children('img').height();
        if (altoImg<altoContainer) {
            var scala= altoContainer/altoImg;
            var top= (altoContainer-altoImg)/2;
            $(modificador).children('img').css("transform","scale("+(scala+.2)+")");
            $(modificador).children('img').addClass(clase);

        };
    }
    ParallaxImg();
    $(window).resize(function(){ParallaxImg();});
})(this.jQuery);