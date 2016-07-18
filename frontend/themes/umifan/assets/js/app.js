$(function(){
    $(".dropdown").hover(
        function() {
            $('.dropdown-menu', this).stop( true, true ).fadeIn("fast");
            $(this).toggleClass('open');
        },
        function() {
            $('.dropdown-menu', this).stop( true, true ).fadeOut("fast");
            $(this).toggleClass('open');
        });


    var $container = $('.portfolioContainer'),
        $body = $('body'),
        colW = 375,
        columns = null;


    $container.isotope({
        // disable window resizing
        resizable: true,
        masonry: {
            columnWidth: colW
        }
    });

    $(window).smartresize(function(){
        // check if columns has changed
        var currentColumns = Math.floor( ( $body.width() -30 ) / colW );
        if ( currentColumns !== columns ) {
            // set new column count
            columns = currentColumns;
            // apply width to container manually, then trigger relayout
            $container.width( columns * colW )
                .isotope('reLayout');
        }

    }).smartresize(); // trigger resize to set container width
    $('.portfolioFilter a').click(function(){
        $('.portfolioFilter .current').removeClass('current');
        $(this).addClass('current');

        var selector = $(this).attr('data-filter');
        $container.isotope({
            filter: selector,
        })

        return false;
    });
    $('.Portfolio-nav li:first a').addClass("current");
    $container.isotope({ filter:$('.Portfolio-nav li:first a').attr('data-filter')});
    $(".fancybox").fancybox({
        maxWidth	: 1000,
        maxHeight	: 900,
    });
});