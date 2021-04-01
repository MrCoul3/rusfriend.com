import axios from "axios";
$(document).ready(function () {
    if ($('main').hasClass("admin-main")) {
        console.log('admin-panel init');

        const mediaQueryMobile = window.matchMedia('(max-width: 767px)');

        switchMenuComponents();
        logout();
        adminMenuMobile();
        // loginOnReload();
        
        $('.header').css('display', 'none');// убираем header главной страницы

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
                    console.log(data.logout)
                    if (data.logout === true) {
                        window.location.reload();
                    } else {
                        console.log('не удалось выйти')
                    }
                });
            });
        }
        // ------------------------------


        // ------------- открытие меню навигации на мобильной версии
        function adminMenuMobile() {
            if (mediaQueryMobile.matches) {

            }
        }
        // ------------------------------

        // function loginOnReload() {
        //     window.addEventListener("load", function (e) {
        //         let data = {
        //             'method': 'reload'
        //         };
        //         let response = fetch('/handle.php', {
        //             method: 'Post',
        //             headers: {
        //                 'Content-Type': 'application/json;charset=utf-8'
        //             },
        //             body: JSON.stringify(data)
        //         });
        //
        //         response.then(function (data) {
        //             return data.json()
        //         }).then(function (data) {
        //             console.log(data)
        //             if (data.success) {
        //                 if (data.status === 'user') {
        //                     // document.location.href = '/index.php'
        //                 }
        //             } else {
        //                 window.location.reload();
        //             }
        //         });
        //     });
        // }
    }
});