(function ($) {
    "use strict";

    // Preloader (if the #preloader div exists)
    $(window).on('load', function () {
        if ($('#preloader').length) {
            $('#preloader').delay(100).fadeOut('slow', function () {
                $(this).remove();
            });
        }
    });

    $('.pager.wizard .btn').click(function() {
       $('html,body').animate({
        scrollTop: $("#payment-container").offset().top},
        'slow');
    })
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 1500, 'easeInOutExpo');
        return false;
    });

    // Initiate the wowjs animation library
    new WOW().init();

    // Header scroll class
    $(window).scroll(function () {
        if ($(this).scrollTop() > 10) {
            $('#header').addClass('header-scrolled');
        } else {
            $('#header').removeClass('header-scrolled');
        }
    });

	$(".mobile-nav a").click(function(){
		//alert ("hello");
		$("body").removeClass("mobile-nav-active");
		$(".mobile-nav-overly").css("display", "none");
		$('.mobile-nav-toggle i').toggleClass('fa-times fa-bars');
	}); 

    if ($(window).scrollTop() > 10) {
        $('#header').addClass('header-scrolled');
    }

    // Smooth scroll for the navigation and links with .scrollto classes
    // $('.main-nav a, .mobile-nav a, .scrollto').on('click', function () {
        // if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
            // var target = $(this.hash);
            // if (target.length) {
                // var top_space = 0;

                // if ($('#header').length) {
                    // top_space = $('#header').outerHeight();
                    // console.log(top_space);
                    // if (!$('#header').hasClass('header-scrolled')) {
                        // top_space = top_space - 40;
                    // }
                // }

                // $('html, body').animate({
                    // scrollTop: target.offset().top - top_space
                // }, 1500, 'easeInOutExpo');

                // if ($(this).parents('.main-nav, .mobile-nav').length) {
                    // $('.main-nav .active, .mobile-nav .active').removeClass('active');
                    // $(this).closest('li').addClass('active');
                // }

                // if ($('body').hasClass('mobile-nav-active')) {
                    // $('body').removeClass('mobile-nav-active');
                    // $('.mobile-nav-toggle i').toggleClass('fa-times fa-bars');
                    // $('.mobile-nav-overly').fadeOut();
                // }
                // return false;
            // }
        // }
    // });

    // Navigation active state on scroll
    //  var nav_sections = $('section');
    //  var main_nav = $('.main-nav, .mobile-nav');
    //  var main_nav_height = $('#header').outerHeight();
    //
    //  $(window).on('scroll', function () {
    //    var cur_pos = $(this).scrollTop();
    //  
    //    nav_sections.each(function() {
    //      var top = $(this).offset().top - main_nav_height,
    //          bottom = top + $(this).outerHeight();
    //  
    //      if (cur_pos >= top && cur_pos <= bottom) {
    ////        main_nav.find('li').removeClass('active');
    //        main_nav.find('a[href="#'+$(this).attr('id')+'"]').parent('li').addClass('active');
    //      }
    //    });
    //  });



    // Porfolio isotope and filter
    $(".tab-pane  .card-header a").click(function () {
        if ($(this).hasClass("collapsed")) {
            //        console.log("gbdhfg");
            $('.tab-pane  .card-header a').addClass("collapsed");
            $(this).removeClass("collapsed");
            $(".collapse").removeClass("show");
            $(this).siblings(".collapse").addClass("show")

        }
    });
    // Clients carousel (uses the Owl Carousel library)
    $(".clients-carousel").owlCarousel({
        autoplay: true,
        dots: true,
        loop: true,
		margin:10,
        responsive: {
            0: {
                items: 2
            },
            768: {
                items: 3
            },
            900: {
                items: 3
            }
        }
    });
	
    $(document).ready(function () {
        //        $('#rootwizard').bootstrapWizard({
        //            onTabShow: function (tab, navigation, index) {
        //                var $total = navigation.find('li').length;
        //                var $current = index + 1;
        //                var $percent = ($current / $total) * 100;
        //                $('#rootwizard').find('.bar').css({
        //                    width: $percent + '%'
        //                });
        //            }
        //        });

        $('#rootwizard').bootstrapWizard({
            onTabClick: function (tab, navigation, index) {
                //		alert('on tab click disabled');
                return false;
            }
        });


        //        $('#rootwizard .finish').click(function () {
        ////            alert('Finished!, Starting over!');
        //            $('#rootwizard').find("a[href*='tab1']").trigger('click');
        //        });

        $('#agree-check1').click(function () {
            if ($('#agree-check1').prop("checked") == true) {
                $("#agree-section1").addClass("check-button");
            } else {
                $("#agree-section1").removeClass("check-button");
            }
        });

        $('#agree-section1').on('click', function () {
            console.log("click");
            if ($(this).hasClass("check-button")) {
                console.log("check");
                $('#agree-check1').removeAttr('checked');
                $(this).removeClass("check-button");
            } else {
                console.log("uncheck");
                $('#agree-check1').prop("checked", true);
                $(this).addClass("check-button");
            }
        });

        $('#agree-check2').click(function () {
            if ($('#agree-check2').prop("checked") == true) {
                $("#agree-section2").addClass("check-button");
            } else {
                $("#agree-section2").removeClass("check-button");
            }
        });

        $('#agree-section2').on('click', function () {
            console.log("click");
            if ($(this).hasClass("check-button")) {
                console.log("check");
                $('#agree-check2').removeAttr('checked');
                $(this).removeClass("check-button");
            } else {
                console.log("uncheck");
                $('#agree-check2').prop("checked", true);
                $(this).addClass("check-button");
            }
        });

        $('#agree-check3').click(function () {
            if ($('#agree-check3').prop("checked") == true) {
                $("#agree-section3").addClass("check-button");
            } else {
                $("#agree-section3").removeClass("check-button");
            }
        });

        $('#agree-section3').on('click', function () {
            console.log("click");
            if ($(this).hasClass("check-button")) {
                console.log("check");
                $('#agree-check3').removeAttr('checked');
                $(this).removeClass("check-button");
            } else {
                console.log("uncheck");
                $('#agree-check3').prop("checked", true);
                $(this).addClass("check-button");
            }
        });
		
		

        //        $(".step-heading").on("click", function () {
        //            if ($(this).hasClass("active")) {
        //                $(this).removeClass("active");
        //                $(this).siblings(".step-container")
        //                    .slideUp(200);
        //            } else {
        //                $('.step-heading').removeClass("active");
        //                $(this).addClass("active");
        //                $(".step-container").slideUp(200);
        //                $(this).siblings(".step-container")
        //                    .slideDown(200);
        //            }
        //        });

        if ($(window).width() < 768) {
            $(".pager.wizard li.next").on("click", function () {
                //                 alert("click")
                $(".step-container").slideUp(200);
                $(this).parents().next('.tab-pane').find(".step-container").slideDown(200);
                $('.step-heading').removeClass("active");
                $(this).parents().next('.tab-pane').find(".step-heading").addClass("active");
            });
            $(".pager.wizard li.previous").on("click", function () {
                $(".step-container").slideUp(200);
                $(this).parents().prev('.tab-pane').find(".step-container").slideDown(200);
                $('.step-heading').removeClass("active");
                $(this).parents().prev('.tab-pane').find(".step-heading").addClass("active");
            });
        }
    });
})(jQuery);
