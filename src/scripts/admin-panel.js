$(document).ready(function () {
    if ($('main').hasClass("admin-main")) {
        console.log('admin-template init');
        $('.header').css('display', 'none');// убираем header главной страницы
        // loginOnReload();
        // переключение элементов меню
        $('.admin-menu__element--mycalendar').addClass('menu-element-colored');
        $('.admin-menu__element').click(function (e) {
            $('.admin-menu__element').removeClass('menu-element-colored');
            if (e.target.className.includes('admin-menu__element--mycalendar')) {
                $('.admin-panel-section').removeClass('calendar-active');
                $('.my-calendar').addClass('calendar-active');
                $('.admin-menu__element--mycalendar').addClass('menu-element-colored');
            }
            if (e.target.className.includes('admin-menu__element--myschedule')) {
                $('.admin-panel-section').removeClass('calendar-active');
                $('.my-schedule').addClass('calendar-active');
                $(this).addClass('menu-element-colored');
            }

            if (e.target.className.includes('admin-menu__element--mystudents')) {
                $('.admin-panel-section').removeClass('calendar-active');
                $('.my-students').addClass('calendar-active');
                $(this).addClass('menu-element-colored');
            }
            if (e.target.className.includes('admin-menu__element--messages')) {
                $('.admin-panel-section').removeClass('calendar-active');
                $('.messages').addClass('calendar-active');
                $(this).addClass('menu-element-colored');
            }
            if (e.target.className.includes('admin-menu__element--reviews')) {
                $('.admin-panel-section').removeClass('calendar-active');
                $('.reviews').addClass('calendar-active');
                $(this).addClass('menu-element-colored');
            }
        });


        // logout
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