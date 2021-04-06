import axios from "axios";


$(document).ready(function () {
    if ($("main").hasClass('main-page')) {
        console.log("js index plugged");
        const mediaQueryDesktop = window.matchMedia('(min-width: 1024px)'); // не менее 1024
        const mediaQueryCartTablet = window.matchMedia('(max-width: 1023px)');
        const mediaQuerySmall = window.matchMedia('(max-width: 767px)');
        paralaksForMainPhoto();
        scrollAnimation();
        aboutSchoolVideoOpen();


        // ------------- функционал кнопки "подробнее про нашу школу"
        function aboutSchoolVideoOpen() {
            $('.about-school-btn--play-btn').click(function () {
                $("#mysite").addClass("body-fixed");
                $('.about-school-video').addClass('detailed-about-school-active');
            });
            $('.close-button').click(function () {
                document.getElementById('about-video').contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
                $("#mysite").removeClass("body-fixed");
                $('.about-school-video').removeClass('detailed-about-school-active');
            });
        }

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
            nav: true,
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



        function scrollAnimation() {
            document.addEventListener("scroll", function (e) {
                // console.log(window.pageYOffset );

                if (mediaQueryDesktop.matches) {
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
        }
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

        // ---------- получить бесплатное занятие
        $('.get-free-lesson-btn').click(function () {
            localStorage.setItem('status', 'free-lesson');
            axios.post('/handle.php', JSON.stringify({'method': 'checkLoginOnBookedLesson'}))
                .then((response) => {
                    // console.log(response.data['success']);
                    if (response.data['success'] === false) {
                        // открытие формы логина
                        if (!$(".register-form").hasClass('register-form-active')) {
                            $(".register-form").addClass('register-form-active');
                            $("#mysite").addClass("body-fixed");
                        }
                    } else {
                        if (response.data['status_2'] === 'new') {
                            $(location).attr('href', '/free-lesson.php');
                        } else {
                            console.log('пользователь уже бронировал бесплатный урок');
                        }
                    }
                })
        });
    }
});
