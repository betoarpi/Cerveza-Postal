( function( $ ) {
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
} )( jQuery );
