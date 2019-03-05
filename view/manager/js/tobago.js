(function ($) {
    $(window).on("load", function () {
        $(".scroll_height, .place_height").mCustomScrollbar({
            autoHideScrollbar: true,
            theme: "rounded-dots-dark"
        });
    });
    $(document).ready(function () {
        var dem = 0;
        var step_buy, slide, sum;
        step_buy = $('.step_buy').outerHeight();
        slide = $('#bootstrap-touch-slider').outerHeight();
        sum = step_buy + slide - 40;
        $("#highest_sale").owlCarousel({
            autoPlay: 3000,
            items: 5,
            itemsDesktop: [1199, 3],
            itemsDesktopSmall: [979, 3]
        });
        
        $('#btn_click,.title_sp').on('click', function () {
            var dem = 0;
            dem++;
            if (dem % 2 === 0) {
                $('#images_support').css({
                    'transform': 'translateX(0)',
                    '-webkit-transform': 'translateY(0)',
                    '-moz-transform': 'translateY(0)',
                    '-ms-transform': 'translateY(0)',
                    '-o-transform': 'translateY(0)'
                });
            } else {
                $('#images_support').css({
                    'transform': 'translateY(315px)',
                    '-webkit-transform': 'translateY(400px)',
                    '-moz-transform': 'translateY(400px)',
                    '-ms-transform': 'translateY(400px)',
                    '-o-transform': 'translateY(400px)'
                });
            }
        });
        $('.scroll_height').css('max-height',sum);
        $('.is-home').hide();
        // $(".home-page").hover(function () {
        //     $('.is-home').slideToggle();
        // });

        // if($(window).innerWidth() >768){
        //     $('.box-vertical-megamenus1').hover(
        //         function() {
        //           $('.is-home').slideDown();
        //       },
        //       function() {
        //           $('.is-home').slideUp();
        //       });
        // } else {
        //      $('.box-vertical-megamenus1 h4').click(function(){
        //         $('.is-home').slideToggle();
        //     });

        // }
        $('.box-vertical-megamenus1 h4').click(function(){
            $('.is-home').slideToggle();
        });


    });
})(jQuery);

// $(document).ready(function() {
//     var he = $(window).innerHeight();
//     var head = $('header').innerHeight();
//     var he_menu = he - head;
//     document.write(he_menu);
// });


function readURL1(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img1')
            .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

function readURL2(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img2')
            .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}

