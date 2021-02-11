jQuery.noConflict()( function ( $ ) {
    "use strict";
    $( document ).ready( function () {

        // menu dropdown link clickable
        $( '.navbar .dropdown > a, .dropdown-menu > li > a' ).click( function () {
            location.href = this.href;
        } );

        // scroll to top button
        $( "#back-top" ).hide();
        $( function () {
            $( window ).scroll( function () {
                if ( $( this ).scrollTop() > 100 ) {
                    $( '#back-top' ).fadeIn();
                } else {
                    $( '#back-top' ).fadeOut();
                }
            } );

            // scroll body to 0px on click
            $( '#back-top a' ).click( function () {
                $( 'body,html' ).animate( {
                    scrollTop: 0
                }, 800 );
                return false;
            } );
        } );

        // tooltip
        $( function () {
            $( '[data-toggle="tooltip"]' ).tooltip()
        } )

        // FlexSlider
        $( window ).load( function () {
            $( '.homepage-slider' ).flexslider( {
                animation: "fade",
                slideshow: true,
                touch: true,
                keyboard: true,
                pauseOnHover: true,
                prevText: '',
                nextText: '',
                before: function ( slider ) {
                    $( slider ).find( ".flex-active-slide" ).find( '.flexslider-title' ).removeClass( "animated fadeInLeft" );
                    $( slider ).find( ".flex-active-slide" ).find( '.flexslider-desc, .flexslider-heading' ).removeClass( "animated zoomIn" );
                    $( slider ).find( ".flex-active-slide" ).find( '.flexslider-button' ).removeClass( "animated fadeInUp" );
                },
                after: function ( slider ) {
                    $( slider ).find( ".flex-active-slide" ).find( '.flexslider-title' ).addClass( "animated fadeInLeft" );
                    $( slider ).find( ".flex-active-slide" ).find( '.flexslider-desc, .flexslider-heading' ).addClass( "animated zoomIn" );
                    $( slider ).find( ".flex-active-slide" ).find( '.flexslider-button' ).addClass( "animated fadeInUp" );
                },
                start: function ( slider ) {
                    $( slider ).find( ".flex-active-slide" ).find( '.flexslider-title' ).addClass( "animated fadeInLeft" );
                    $( slider ).find( ".flex-active-slide" ).find( '.flexslider-desc, .flexslider-heading' ).addClass( "animated zoomIn" );
                    $( slider ).find( ".flex-active-slide" ).find( '.flexslider-button' ).addClass( "animated fadeInUp" );
                },
            } );
        } );


        // Wishlist count ajax update
        $( 'body' ).on( 'added_to_wishlist', function () {
            $( '.top-wishlist .count' ).load( yith_wcwl_l10n.ajax_url + ' .top-wishlist span', { action: 'yith_wcwl_update_single_product_list' } );
        } );

        // Off Canvas Menu
        if ( $( 'nav' ).hasClass( 'off-canvas-menu' ) ) {
            $( "#menu" ).mmenu( {
                "extensions": [
                    "effect-menu-slide",
                    "theme-dark",
                    "pagedim-black"
                ],
                "navbars": [
                    {
                        "position": "top",
                        "content": [
                            "prev",
                            "title",
                            "close"
                        ]
                    }
                ],
                "counters": true
            } );
        }

    } );
} );
