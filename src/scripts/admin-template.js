$(document).ready(function () {
    if ($('main').hasClass("admin-main")) {
        console.log('admin-template init');
        loginOnReload();
            // переключение элементов меню
        $('.admin-menu__element').click(function (e) {
            if (e.target.className.includes('admin-menu__element--mycalendar')) {
                $('.admin-panel-section').removeClass('calendar-active');
                $('.my-calendar').addClass('calendar-active');
            }
            if (e.target.className.includes('admin-menu__element--myschedule')) {
                $('.admin-panel-section').removeClass('calendar-active');
                $('.my-schedule').addClass('calendar-active');
            }

            if (e.target.className.includes('admin-menu__element--mystudents')) {
                $('.admin-panel-section').removeClass('active');
                $('.my-students').addClass('active');
            }
            if (e.target.className.includes('admin-menu__element--messages')) {
                $('.admin-panel-section').removeClass('active');
                $('.messages').addClass('active');
            }
            if (e.target.className.includes('admin-menu__element--reviews')) {
                $('.admin-panel-section').removeClass('active');
                $('.reviews').addClass('active');
            }
        });


        // logout
        $('.btn-exit').click(function () {
            console.log('www')
            let response = fetch('handle.php', {
                method: 'Post',
                headers: {'Content-Type': 'application/json;charset=utf-8'},
                body: JSON.stringify({'method': 'logout'})
            });
            // document.location.href = '/index.php';
        });


        function loginOnReload() {
            window.addEventListener("load", function (e) {
                let data = {
                    'method': 'reload'
                };
                let response = fetch('/handle.php', {
                    method: 'Post',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify(data)
                });

                response.then(function (data) {
                    return data.json()
                }).then(function (data) {
                    console.log(data)
                    if (data.success) {
                        if (data.status === 'user') {
                            document.location.href = '/index.php'
                        }
                    } else {
                        document.location.href = '/index.php'
                    }
                });
            });
        }
    }
});