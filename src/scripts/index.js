const mediaQueryCartDesktop = window.matchMedia('(min-width: 1024px)'); // не менее 1024
const mediaQueryCartTablet = window.matchMedia('(max-width: 1023px)');
const mediaQuerySmall = window.matchMedia('(max-width: 767px)');

$(document).ready(function () {
    if ($("main").hasClass('main-page')) {
        console.log("js index plugged");
        paralaksForMainPhoto();


        // ------------- функционал кнопки "подробнее про нашу школу"
        $('.about-school-btn--play-btn').click(function () {
            $("#mysite").addClass("body-fixed");
            $('.about-school-video').addClass('detailed-about-school-active');
        });
        $('.close-button').click(function () {
            $("#mysite").removeClass("body-fixed");
            $('.about-school-video').removeClass('detailed-about-school-active');
        });
        // ------------------------------------------------------------


        // карусели
        $(".owl-carousel-1").owlCarousel({
            margin: 100,
            autoWidth: true,
            dotsEach: true,
            navSpeed: 500,
            loop: true,
            center: true,
            autoplay: true,
            autoplaySpeed: 500,
            autoplayHoverPause: true,
            autoplayTimeout: 3000,
            // navText:[`<img src=${require('../images/icons/icon-arrow--left.svg')}>`, `<img src=${require('../images/icons/icon-arrow--right.svg')}>`],
        });
        $(".owl-carousel-2").owlCarousel({
            items: 1,
            margin: 300,
            center: true,
            dotsEach: true,
            autoWidth: true,
            navSpeed: 500,
            loop: true,
            // center: true,
            autoplay: true,
            autoplaySpeed: 500,
            autoplayHoverPause: true,
            autoplayTimeout: 3000
        });


        //ANIMATION-----------------------------------
        // анимация главного баннера на главной странице
        animateToOrigin($(".top-index-title"));
        animateToOrigin($(".top-index-second-title"));
        animateToOrigin($(".top-index-first-title"));
        document.addEventListener("scroll", function (e) {
            console.log(window.pageYOffset );

            // делает header белым при прокрутке больше 50px
            if (mediaQuerySmall.matches) {
                console.log('small')
                if (window.pageYOffset > 50) {
                    // $('.header__overhead').css('background', '#fff')
                    $('.header__overhead').addClass('header-menu-white-on-mobile')
                } else {
                    $('.header__overhead').removeClass('header-menu-white-on-mobile')

                }
            }

            if (mediaQueryCartDesktop.matches) {
                // анимация for-whom
                if (window.pageYOffset > 280) {
                    animateToOrigin($(".for-whom-title"))
                }
                // анимация offers
                if (window.pageYOffset > 900) {
                    animateToOrigin($(".offers-title"));
                    animateToOrigin($(".offers-slogan"));
                }

                if (window.pageYOffset > 1100) {
                    $(".offers-cards-conteiner").animate({
                        'opacity': 1,
                        'marginTop': 0
                    }, 1000, "easeOutQuart");
                }

                // анимация about
                if (window.pageYOffset > 1500) {
                    animateToOrigin($(".about__element--left"), 100);
                    animateToOrigin($(".about-title"));
                    animateToOrigin($(".about-slogan"));
                    animateToOrigin($(".about-social-net"));
                }
                if (window.pageYOffset > 1700) {
                    animateToOrigin($(".about-items .a"));
                }
                if (window.pageYOffset > 1725) {
                    animateToOrigin($(".about-items .b"));
                }
                if (window.pageYOffset > 1750) {
                    animateToOrigin($(".about-items .c"));
                }
                if (window.pageYOffset > 1800) {
                    animateToOrigin($(".about-items .d"));
                }
                if (window.pageYOffset > 1900) {
                    animateToOrigin($(".detail-slogan"));
                }
                //анимация  reviews
                if (window.pageYOffset > 2250) {
                    animateToOrigin($(".reviews-title"));
                }
            }
        });
        //end animation----------------------------------

        function paralaksForMainPhoto(){
            $(".top-index-photo__elem").each(function (key, val) {
                val.addEventListener("mousemove", function (e) {
                    let positionX = e.clientX / window.innerWidth;
                    let positionY = e.clientY / window.innerHeight;
                    this.style.transform = 'translate(-' + positionX * 50 + 'px, -' + positionY * 50 + 'px)';
                });
            });
        }
        function animateToOrigin(element, marginLeft = 0) {
            element.animate({
                'opacity': 1,
                'marginLeft': marginLeft
            }, 1000, "easeOutQuart");
        }

    }
});
