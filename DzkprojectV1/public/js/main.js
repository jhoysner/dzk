;(function($){
    "use strict"

        var window_width = $(window).width(),
            window_height = window.innerHeight,
            header_height = $(".default-header").height(),
            header_height_static = $(".site-header.static").outerHeight(),
            fitscreen = window_height - header_height;

        $(".fullscreen").css("height", window_height);
        $(".fitscreen").css("height", fitscreen);


    /* ---------------------------------------------
        Nice Select js
     --------------------------------------------- */


        $('select').niceSelect();


    /* ---------------------------------------------
       Top Cart js
     --------------------------------------------- */


    $(".top-cart").on('click', function (event) {
        $(".mini-cart").slideToggle();  // Might cause problems depending on implementation
        event.stopPropagation();

        $(document).on('click', function (e) {
            if(!$(e.target).is('.top-cart')) {
                $(".mini-cart").slideUp(); 
            }
        });
    });


    /* ---------------------------------------------
        Initiate superfish on nav menu 
     --------------------------------------------- */

        $('.nav-menu').superfish({
            animation: {
                opacity: 'show'
            },
            speed: 400
        });


    /* ---------------------------------------------
        Mobile Navigation
     --------------------------------------------- */

    if ($('#nav-menu-container').length) {
        var $mobile_nav = $('#nav-menu-container').clone().prop({
            id: 'mobile-nav'
        });
        $mobile_nav.find('> ul').attr({
            'class': '',
            'id': ''
        });
        $('body').append($mobile_nav);
        $('body').prepend('<button type="button" id="mobile-nav-toggle"><i class="icons icon-menu"></i></button>');
        $('body').append('<div id="mobile-body-overly"></div>');
        $('#mobile-nav').find('.menu-has-children').prepend('<i class="icons icon-arrow-down"></i>');

        $(document).on('click', '.menu-has-children i', function(e) {
            $(this).next().toggleClass('menu-item-active');
            $(this).nextAll('ul').eq(0).slideToggle();
            $(this).toggleClass("icon-arrow-up icon-arrow-down");
        });

        $(document).on('click', '#mobile-nav-toggle', function(e) {
            $('body').toggleClass('mobile-nav-active');
            $('#mobile-nav-toggle i').toggleClass('lnr-cross icon-menu');
            $('#mobile-body-overly').toggle();
        });

        $(document).on('click',function(e){
            var container = $("#mobile-nav, #mobile-nav-toggle");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
                if ($('body').hasClass('mobile-nav-active')) {
                    $('body').removeClass('mobile-nav-active');
                    $('#mobile-nav-toggle i').toggleClass('lnr-cross icon-menu');
                    $('#mobile-body-overly').fadeOut();
                }
            }
        });



    } else if ($("#mobile-nav, #mobile-nav-toggle").length) {
        $("#mobile-nav, #mobile-nav-toggle").hide();
    }


    /* -------------------------------------------------------------------
        Smooth scroll for the menu and links with .scrollto classes
     ------------------------------------------------------------------ */

        $('.nav-menu a, #mobile-nav a, .scrollto').on('click', function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') && location.hostname === this.hostname) {
                var target = $(this.hash);
                if (target.length) {
                    var top_space = 0;

                    if ($('#header').length) {
                        top_space = $('#header').outerHeight();

                        if (!$('#header').hasClass('header-fixed')) {
                            top_space = top_space;
                        }
                    }

                    $('html, body').animate({
                        scrollTop: target.offset().top - top_space
                    }, 1500, 'easeInOutExpo');

                    if ($(this).parents('.nav-menu').length) {
                        $('.nav-menu .menu-active').removeClass('menu-active');
                        $(this).closest('li').addClass('menu-active');
                    }

                    if ($('body').hasClass('mobile-nav-active')) {
                        $('body').removeClass('mobile-nav-active');
                        $('#mobile-nav-toggle i').toggleClass('lnr-times lnr-bars');
                        $('#mobile-body-overly').fadeOut();
                    }
                    return false;
                }
            }
        });

        $(document).on('ready', function() {

            $('html, body').hide();

            if (window.location.hash) {

                setTimeout(function() {

                    $('html, body').scrollTop(0).show();

                    $('html, body').animate({

                        scrollTop: $(window.location.hash).offset().top - 68

                    }, 1000)

                }, 0);

            } else {

                $('html, body').show();

            }

        });



        jQuery(document).on('ready', function($) {
            // Get current path and find target link
            var path = window.location.pathname.split("/").pop();

            // Account for home page with empty path
            if (path === '') {
                path = 'index.php';
            }

            var target = $('nav a[href="' + path + '"]');
            // Add active class to target link
            target.addClass('menu-active');
        });

        $(document).on('ready', function() {
            if ($('.menu-has-children ul>li a').hasClass('menu-active')) {
                $('.menu-active').closest("ul").parentsUntil("a").addClass('parent-active');
            }
        });


    /* -------------------------------------------------------------------
        Header Scroll Class js
     ------------------------------------------------------------------ */

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 100) {
                $('#header').addClass('header-scrolled');
            } else {
                $('#header').removeClass('header-scrolled');
            }
        });


    /* -------------------------------------------------------------------
        MailChimp js
     ------------------------------------------------------------------ */

    $(document).on('ready', function() {
        $('#mc_embed_signup').find('form').ajaxChimp();
    });


    /* -------------------------------------------------------------------
        Have Cupon Button Text Toggle Change
     ------------------------------------------------------------------ */

    if (document.getElementById("cuppon-wrap")) {

        $('.cuppon-wrap .have-btn').on('click', function(e){
            e.preventDefault();
            $('.cuppon-wrap .have-btn span').text(function(i, text){
              return text === "Have a Coupon?" ? "Close Coupon" : "Have a Coupon?";
            })
            $('.cuppon-wrap .cupon-code').fadeToggle("slow");
        });

        $('.load-more-btn').on('click', function(e){
            e.preventDefault();
            $('.load-product').fadeIn('slow');
            $(this).fadeOut();
        });

    }

    /* -------------------------------------------------------------------
        Quantity js
     ------------------------------------------------------------------ */


    jQuery('<div class="quantity-nav"><div class="quantity-button quantity-up"><i class="icons icon-arrow-up"></i></div><div class="quantity-button quantity-down"><i class="icons icon-arrow-down"></i></div></div>').insertAfter('.quantity input');
    jQuery('.quantity').each(function() {
      var spinner = jQuery(this),
        input = spinner.find('input[type="number"]'),
        btnUp = spinner.find('.quantity-up'),
        btnDown = spinner.find('.quantity-down'),
        min = input.attr('min'),
        max = input.attr('max');

      btnUp.on('click', function() {
        var oldValue = parseFloat(input.val());
        if (oldValue >= max) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue + 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

      btnDown.on('click', function() {
        var oldValue = parseFloat(input.val());
        if (oldValue <= min) {
          var newVal = oldValue;
        } else {
          var newVal = oldValue - 1;
        }
        spinner.find("input").val(newVal);
        spinner.find("input").trigger("change");
      });

    });


    /* -------------------------------------------------------------------
        Settings Vertial tab js
     ------------------------------------------------------------------ */

      $( function() {
        $( "#tabs" ).tabs();
      } );



    /* -------------------------------------------------------------------
        Chart js
     ------------------------------------------------------------------ */

    if (document.getElementById("sales-chart")) {

        var canvas = document.getElementById("sales-chart");
        var ctx = canvas.getContext('2d');

        // Global Options:
         Chart.defaults.global.defaultFontColor = '#797979';
         Chart.defaults.global.defaultFontSize = 14;

        // Data with datasets options
        var data = {
            labels: ["2017","2018"],
              datasets: [
                {
                    label: "Sales",
                    fill: true,
                    backgroundColor: "#ecf7fe",
                    borderColor: "#42b0f2",
                    data: [72, 32],
                }
            ]
        };
        // Chart declaration with some options:
        var myFirstChart = new Chart(ctx, {
            type: 'line',
            data: data
        })

    }



    /* -------------------------------------------------------------------
        Category and Settings Menu Dropdown js
     ------------------------------------------------------------------ */

    if (document.getElementById("cat-menu")) {
 
          // Create the dropdown base
          $("<select />").appendTo(".cat-nav-menu");
          
          // Create default option "Go to..."
          $("<option />", {
             "selected": "selected",
             "value"   : "",
             "text"    : "Select Category"
          }).appendTo("select");
          
          // Populate dropdown with menu items
          $(".cat-menu a").each(function() {
           var el = $(this);
           $("<option />", {
               "value"   : el.attr("href"),
               "text"    : el.text()
           }).appendTo("select");
          });
          

          $("select").change(function() {
            window.location = $(this).find("option:selected").val();
          }); 
          $('select').niceSelect();
    }

    // Settings Menu

    if (document.getElementById("usr-menu")) {
 
          // Create the dropdown base
          $("<select />").appendTo(".usr-menu");
          
          // Create default option "Go to..."
          $("<option />", {
             "selected": "selected",
             "value"   : "",
             "text"    : "profile"
          }).appendTo("select");
          
          // Populate dropdown with menu items
          $(".top-nav a").each(function() {
           var el = $(this);
           $("<option />", {
               "value"   : el.attr("href"),
               "text"    : el.text()
           }).appendTo("select");
          });
          

          $("select").change(function() {
            window.location = $(this).find("option:selected").val();
          }); 
          $('select').niceSelect();
    }    

})(jQuery)