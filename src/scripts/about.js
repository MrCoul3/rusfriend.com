$(document).ready(function () {
    if ($('main').hasClass("about-page")) {
        // console.log('about');
        const mediaQueryDesktop = window.matchMedia('(min-width: 1024px)');

        aboutAnimation();
        offersAnimation();

        // $(window).resize(function () {
        //     aboutAnimation();
        // })

        $(".owl-carousel-3").owlCarousel({
            items: 1,
            margin: 300,
            center: true,
            dotsEach: true,
            autoWidth: true,
            navSpeed: 500,
            loop: true,
            center: true,
            autoplay: true,
            autoplaySpeed: 1000,
            autoplayHoverPause: true,
            autoplayTimeout: 7000
        });

        // ----------- возврат в исходное состояние
        function animateToOrigin(element, marginLeft = 0) {
            element.animate({
                'opacity': 1,
                'marginLeft': marginLeft
            }, 1000, "easeOutQuart");
            setTimeout(function () {
                element.css('visibility', 'visible');
            }, 100);
        }

        // ----------- возврат в исходное состояние
        function animateToLeft(element, left = 0) {
            element.animate({
                'left': left,
                'opacity': 1
            })
            setTimeout(function () {
                element.css('visibility', 'visible');
            }, 100);
        }
        // ----------- анимация карточек предложений
        function offersAnimation() {
            document.addEventListener("scroll", function (e) {
                // // console.log(window.pageYOffset);
                if (mediaQueryDesktop.matches) {
                    if (window.pageYOffset > 400) {
                        animateToOrigin($(".offers-title"));
                        animateToOrigin($(".offers-slogan"));
                    }
                    if (window.pageYOffset > 500) {
                        $(".offers-cards-conteiner").animate({
                            'opacity': 1,
                            'marginTop': 0
                        }, 1000, "easeOutQuart");
                    }
                }
            });
        }

        function aboutAnimation() {
            if ($('.about-page')) {
                if (mediaQueryDesktop.matches) {

                    animateToOrigin($(".about__element--left"));
                    setTimeout(function () {
                        animateToLeft($(".about-title"));
                    }, 300);

                    animateToLeft($(".about-social-net"));
                    setTimeout(function () {
                        animateToLeft($('.about-items .a'));
                    }, 500);
                    setTimeout(function () {
                        animateToLeft($(".about-items .b"));
                    }, 700);
                    setTimeout(function () {
                        animateToLeft($(".about-slogan"));
                    }, 1000);

                    setTimeout(function () {
                        animateToOrigin($(".detail-slogan"));
                    }, 1300);
                }
            }
        }
    }
});