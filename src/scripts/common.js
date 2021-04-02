

$(document).ready(function () {
    if ($(".header")) {
        console.log('common.js init')
        const mediaQueryMobile = window.matchMedia('(max-width: 767px)'); // работает только на мобильных / не более 767
        // -------------------------
        resetStates();
        changeLanguage();
        navMenuFixing();
        headerFixedOnMobile();
        burgerMenuActions();
        coloredNavMenuElems();
        openUserMenu();
        // -------------------------

        // ----------- сброс активных состояний
        function resetStates() {
            $(document).click(function (e) {
                let targClass = e.target.className;
                if (!targClass.includes('btn-change-lang')) {
                    $(".lang-changer").removeClass('active');
                }
                // targClass !== "user-login-menu__elem" &&
                if (!targClass.includes("user-login__elem") && !targClass.includes("user-login")) {
                    $(".user-login-menu").slideUp(10);
                }
                // console.log(e.target);
            });
        }

        // -----------------------------------------

        // ----------- функционал кнопки смены языка
        function changeLanguage() {
            $(".btn-change-lang").click(function () {
                // console.log($(".lang-changer").hasClass('lang-changer-active'));
                if (!$(".lang-changer").hasClass('active')) {
                    $(".lang-changer").addClass('active');
                } else {
                    $(".lang-changer").removeClass('active');
                }
            });
            $('.lang-changer').click(function () {
                let langsObj = {
                    'method': 'language'
                };
                if ($('.lang-changer').hasClass('eng-lang')) {
                    $('.lang-changer').addClass('rus-lang').removeClass('eng-lang');
                    $(".btn-change-lang").removeClass('rus-lang').addClass('eng-lang');
                    langsObj.btnLang = 'eng-lang';
                    langsObj.langChanger = 'rus-lang';
                } else {
                    $('.lang-changer').removeClass('rus-lang').addClass('eng-lang');
                    $(".btn-change-lang").addClass('rus-lang').removeClass('eng-lang');
                    langsObj.btnLang = 'rus-lang';
                    langsObj.langChanger = 'eng-lang';
                }

                let response = fetch('/handle.php', {
                    method: 'Post',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify(langsObj)
                });
            });
        }

        // -----------------------------------------


        // ----------- функционал фиксирования меню навигации при прокрутке страницы
        function navMenuFixing() {
            let lastPos = 0;
            document.addEventListener("scroll", function (e) {

                // Background white меню на мобильном устройстве
                headerFixedOnMobile();

                // на десктопе и таблете
                function headerLowerFixed() {
                    if (!mediaQueryMobile.matches) {
                        if (window.pageYOffset > 145) {
                            (window.pageYOffset < lastPos) ? $(".header__lower").addClass("header-lower-fixed") : $(".header__lower").removeClass("header-lower-fixed");
                        } else {
                            $(".header__lower").removeClass("header-lower-fixed");
                        }
                    }
                }

                $(window).resize(function (e) {
                    headerLowerFixed();
                });

                headerLowerFixed();
                lastPos = window.pageYOffset;
            });
        }

        function headerFixedOnMobile() {
            if (mediaQueryMobile.matches) {
                if (window.pageYOffset > 35) {
                    $('.header').addClass('header-menu-fixed');
                } else {
                    $('.header').removeClass('header-menu-fixed');
                }
            }
        }


        // -----------------------------------------


        // ----------- функционал и анимация бургер-меню на мобильных устройствах
        function burgerMenuActions() {
            $(".burger-menu").click(function () {
                // console.log('ww')
                // console.log(window.pageYOffset);
                if ($(".header-menu").hasClass('header-menu-active')) {
                    $(".header-menu").removeClass('header-menu-active').animate({
                        'right': '768px'
                    }, 100);

                    $("#mysite").removeClass("body-fixed");
                    $(".footer").animate({
                        'bottom': '-=200px'
                    });

                    setTimeout(function () {
                        $(".header__lower").removeClass('header-lower-active');
                    }, 300);

                    setTimeout(function () {
                        $(".footer").removeClass("footer-active-menu");
                    }, 300);

                } else {
                    $(".header-menu").addClass('header-menu-active').animate({
                        'right': '0px'
                    });
                    $("#mysite").addClass("body-fixed");
                    $(".footer").addClass('footer-active-menu').animate({
                        'bottom': '0px'
                    });
                    $(".header__lower").addClass('header-lower-active');
                }
            });

        }

        // -----------------------------------------


        // ----------- подсветка активного элемента меню навигации пользователя
        function coloredNavMenuElems() {
            if ($('main').hasClass("private-lesson")) {
                $('.header-menu--private').addClass('menu-item-active');
            }
            if ($('main').hasClass("speaking-club")) {
                $('.header-menu--s-club').addClass('menu-item-active');
            }
            if ($('main').hasClass("guide")) {
                $('.header-menu--guide').addClass('menu-item-active');
            }
            if ($('main').hasClass("courses")) {
                $('.header-menu--courses').addClass('menu-item-active');
            }
            if ($('main').hasClass("about-page")) {
                $('.header-menu--about').addClass('menu-item-active');
            }
        }

        // -----------------------------------------


        // ----------- ВСПЛЫВАЮЩЕЕ МЕНЮ ПОЛЬЗОВАТЕЛЯ ----------- \\
        // ----------- открыть меню
        function openUserMenu() {
            // if (mediaQueryMobile.matches) {// не менее 767
            $(".user-login").on('click', function () {
                $(".user-login-menu").slideToggle(100);
            });
            // }
            // $(".button").click(function (e) {
            //     e.preventDefault();
            // });
        }
        // -----------------------------------------


    }
});
