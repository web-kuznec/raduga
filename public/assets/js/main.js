$(function() {
    var GammaSettings = {
        // order is important!
        viewport : [ {
                width : 1200,
                columns : 5
        }, {
                width : 900,
                columns : 4
        }, {
                width : 620,
                columns : 3
        }, { 
                width : 320,
                columns : 2
        }, { 
                width : 0,
                columns : 2
        } ]
    };

    Gamma.init( GammaSettings, fncallback );

    // Example how to add more items (just a dummy):
    function fncallback() {
        $( '#loadmore' ).show().on( 'click', function() {
            ++page;
            var newitems = items[page-1]
            if( page <= 1 ) {
                Gamma.add( $( newitems ) );
            }
            if( page === 1 ) {
                $( this ).remove();
            }
        });
    }
});
$(document).ready(function () {
    $(document).on("scroll", onScroll);

    $('a[href^="#"]').on('click', function (e) {
        //e.preventDefault();
        $(document).off("scroll");

        $('a').each(function () {
            $(this).removeClass('navactive');
        })
        $(this).addClass('navactive');

        var target = this.hash;
        $target = $(target);
        $('html, body').stop().animate({
            'scrollTop': $target.offset().top+2
        }, 500, 'swing', function () {
            window.location.hash = target;
            $(document).on("scroll", onScroll);
        });
    });
    
    $('.navbar-collapse ul li a').on('click', function (e) {
        $(this).parent().parent().parent().removeClass('in');
    });
});

function onScroll(event){
    var scrollPosition = $(document).scrollTop();
    $('.nav li a').each(function () {
        var currentLink = $(this);
        var refElement = $(currentLink.attr("href"));
        
    });
};

var cbpAnimatedHeader = (function() {

    var docElem = document.documentElement,
        header = document.querySelector( '.navbar-fixed-top' ),
        didScroll = false,
        changeHeaderOn = 50;

    function init() {
        window.addEventListener( 'scroll', function( event ) {
            if( !didScroll ) {
                didScroll = true;
                setTimeout( scrollPage, 250 );
            }
        }, false );
    }

    function scrollPage() {
        var sy = scrollY();
        if ( sy >= changeHeaderOn ) {
            //classie.add( header, 'cbp-af-header-shrink' );
            $('.top').css('display', 'none');
        }
        else {
            //classie.remove( header, 'cbp-af-header-shrink' );
            $('.top').css('display', 'block');
        }
        didScroll = false;
    }

    function scrollY() {
        return window.pageYOffset || docElem.scrollTop;
    }

    init();

})();