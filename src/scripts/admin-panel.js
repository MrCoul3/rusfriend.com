import axios from "axios";

$(document).ready(function () {
    if ($('main').hasClass("admin-main")) {
        // console.log('admin-panel init');

        const mediaQueryMobile = window.matchMedia('(max-width: 767px)');

        switchMenuComponents();
        logout();
        // adminMenuMobile();
        changePrice();
        loginOnReload();

        // $('.header').css('display', 'none');// убираем header главной страницы
        $('.header').remove();// убираем header главной страницы
        $('.login-form').remove();
        $('.register-form').remove();
        $('.register-success').remove();
        $('.settings').remove();

        setTimeout(()=>{
            $('#preloader').css('display', 'none');
        },50);

        // ------------ переключение элементов меню
        function switchMenuComponents() {
            $('.admin-menu__element--mycalendar').addClass('menu-element-colored');
            $('.admin-menu__element').click(function (e) {
                $('.admin-menu__element').removeClass('menu-element-colored');
                $('.admin-panel-section').removeClass('calendar-active');
                $(this).addClass('menu-element-colored');
                if (e.target.className.includes('admin-menu__element--mycalendar')) {
                    $('.my-calendar').addClass('calendar-active');
                }
                if (e.target.className.includes('admin-menu__element--myschedule')) {
                    $('.my-schedule').addClass('calendar-active');
                }

                if (e.target.className.includes('admin-menu__element--mystudents')) {
                    $('.my-students').addClass('calendar-active');
                }

                if (e.target.className.includes('admin-menu__element--messages')) {
                    $('.messages').addClass('calendar-active');
                }

                if (e.target.className.includes('admin-menu__element--reviews')) {
                    $('.reviews').addClass('calendar-active');
                }

            });
        }

        // ------------------------------

        //------- изменить цену
        function changePrice() {
            // ---- Открытие окна изменения цены
            $('.admin-menu-price').click(() => {
                $('.price-changer').addClass('price-changer-active');
                $("#mysite").addClass("body-fixed");
            });
            // ---- закрыть
            $('.price-changer--close').click(() => {
                $('.price-changer').removeClass('price-changer-active');
                $("#mysite").removeClass("body-fixed");
            });

            // ----- Отправить цену в БД
            $('.change-bnt').click((e) => {
                let type;
                let price;
                if ($(e.target).hasClass('change-btn--private')) {
                    type = 'private';
                    price = $('.input-private').val();
                }
                if ($(e.target).hasClass('change-btn--sclub')) {
                    type = 'sclub';
                    price = $('.input-sclub').val();
                }
                $('.input').val('');
                let obj = {
                    type: type,
                    price: price,
                    'method': 'setPrice'
                };
                axios.post('/handle.php', JSON.stringify(obj))
                    .then((response) => {
                        // console.log(response.data);
                        $('.price-private').html('$' + response.data.private);
                        $('.price-sclub').html('$' + response.data.sclub);
                    });
            })


        }


        // ------------------ logout
        function logout() {
            $('.btn-exit').click(function (e) {

                let response = fetch('handle.php', {
                    method: 'Post',
                    headers: {'Content-Type': 'application/json;charset=utf-8'},
                    body: JSON.stringify({'method': 'logout'})
                });
                response.then(function (data) {
                    return data.json()
                }).then(function (data) {
                    // console.log(data.logout)
                    if (data.logout === true) {
                        delete localStorage.getAllUsersInfo;
                        window.location.reload();
                    } else {
                        // console.log('не удалось выйти')
                    }
                });
            });
        }

        // ------------------------------

        // ------------- открытие меню навигации на мобильной версии
        // function adminMenuMobile() {
        //     $('.burger-menu-label').click(function () {
        //         if (!$('.admin-menu').hasClass('admin-menu-active')) {
        //             $('.admin-menu').addClass('admin-menu-active');
        //         } else {
        //             $('.admin-menu').removeClass('admin-menu-active');
        //         }
        //     })
        // }

        // ------------------------------

        // ---- занесение в БД admin-data часового пояса при перезагрузке страницы
        function loginOnReload() {
            window.addEventListener("load", function (e) {
                // // console.log('load')
                let zone = new Date().toString().split(' ')[5];
                let gmt = 'GMT ' + zone.substring(3, 6) + ':00';
                let data = {
                    gmt: gmt,
                    'method': 'adminPanelReload'
                };
                let response = fetch('/handle.php', {
                    method: 'Post',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify(data)
                });
            });
        }
    }
});