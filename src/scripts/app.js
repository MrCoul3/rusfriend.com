import Vue from 'vue';
import './index';
import './common';
import './about';
import './offers';
import './book-calendar';
import './private-lesson';
import './speaking-club';
import './courses';
import './guide';
import './my-lessons';
import './admin-panel';
import './admin-template';
import './login-and-registration';
import 'owl.carousel';
import './easing-plugin';
import './service';
import MySchedule from "../vue/MySchedule.vue";
import Test from "../vue/Test.vue";

if (document.getElementById('vue-test')) {
    console.log('init vue-test');
    const vueTest = new Vue({
        el: '#vue-test',
        components: {
            test: Test,
        }
    });
}

$(document).ready(function () {

    if (document.getElementById('vue-my-schedule')) {
        console.log('init my-schedule calendar');
        const mySchedule = new Vue({
            el: '#vue-my-schedule',
            components: {
                myschedule: mySchedule,
            }
        });
    }





    if ($(".header")) {
        const mediaQueryMobile = window.matchMedia('(max-width: 768px)'); // не более 768

        resetStates();
        changeLanguage();
        navMenuFixing();
        userMenuOpen();
        burgerMenuActions();

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
        function navMenuFixing(){
            let lastPos = 0;
            document.addEventListener("scroll", function (e) {
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

                // Background white меню на мобильном устройстве
                if (mediaQueryMobile.matches) {
                    if (window.pageYOffset > 35) {
                        $('.header').addClass('header-menu-fixed');
                    } else {
                        $('.header').removeClass('header-menu-fixed');
                    }
                }
            });
        }
        function userMenuOpen() {
            $(".user-login").on('click', function () {
                $(".user-login-menu").slideToggle(100);
            });
            // $(".button").click(function (e) {
            //     e.preventDefault();
            // });
        }
        function burgerMenuActions() {
            $(".burger-menu").click(function () {
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

    }
});

