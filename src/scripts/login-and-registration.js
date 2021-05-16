import axios from "axios";

$(document).ready(function () {

    if (!$('body').hasClass('admin') && !$('main').hasClass('payment')) {
        console.log('login and register init')

        openLoginForm();
        closeLoginForm();
        changeForms();
        registration();
        login();
        loginOnReload();
        logout();
        passwordWhitespaceDisable($("input[type='password']"));
        resetOnFocus();

    }

    // ----- закрытие на escape
    $(this).keydown(function (eventObject) {
        if (eventObject.which == 27) {
            if ($('.login-form').hasClass('login-form-active') || $('.register-form').hasClass('register-form-active')) {
                closeFormAnimation()
            }
        }
    });
    // ----------------------------------------


    function openLoginForm() {
        $(".btn-login").click(function () {

            if (!$(".login-form").hasClass('login-form-active')) {

                $('.header').css('right', '8px');
                $('.header__overhead').css('padding', '0 30px');

                $(".login-form").addClass('login-form-active').animate({
                    'opacity': '1'
                }, 100);

                $(".form-frame").animate({
                    'left': '0px',
                }, 200);

                $(".register-form").animate({
                    'opacity': '1'
                },100);

                $("#mysite").addClass("body-fixed");
                // $('.header__overhead').addClass('header-fixed');
                // $('.login-form .form-frame').animate({
                //     'width': '364px',
                //     'height': '364px'
                // },100);
            }
        });
    }
    function closeFormAnimation() {
        $(".login-form").animate({
            'opacity': '0'
        },100);

        $(".register-form").animate({
            'opacity': '0'
        },100);

        setTimeout(function () {
            $(".login-form").removeClass('login-form-active');
            $(".register-form").removeClass('register-form-active')
        },400);

        $(".form-frame").animate({
            'left': '-2000px',
        }, 200);
        $('.header').css('right', '0');
        $('.header__overhead').css('padding', '0 20px');
        $("#mysite").removeClass("body-fixed");
        $(".login-invalid").addClass("login-invalid--disable");
    }

    function closeLoginForm() {
        $(".form-close-btn").click(function () {
            delete localStorage.status;
            closeFormAnimation();
        });
    }

    function changeForms() {
        $(".reg-log-changer").click(function () {
            if ($(".login-form").hasClass('login-form-active')) {
                $(".login-form").removeClass('login-form-active').animate({
                    'opacity': '0'
                },100);
                $(".register-form").addClass("register-form-active").css(
                    'opacity', '1');
            } else {
                $(".login-form").addClass('login-form-active').css(
                    'opacity', '1');
                $(".register-form").removeClass("register-form-active").animate({
                    'opacity': '0'
                },100);
            }
        });
    }

    function passwordWhitespaceDisable(elem) {
        elem.each(function (k, v) {
            $(this).on('input', () => {
                if ($(this).val().charAt(0) === ' ') $(this).val('');
            });
        });
    }

    function registerUser() {
        // закрытие формы
        // $(".register-form").removeClass("register-form-active");
        closeFormAnimation()
        // открытие сообщение об успешной регистрации
        $(".register-success").addClass("register-success-active");
    }

    function authorizedUser() {
        // $(".login-form").removeClass("login-form-active");
        closeFormAnimation()
    }

    function changeLoginBtnToUserName() {
        $(".btn-login").addClass("disable");
        $(".user-login").removeClass("disable").addClass("active-flex");
    }


    function registration() {
        let checkText;
        let registerBtn = document.querySelector(".form-submit-register");
        registerBtn.addEventListener("click", function (e) {
            e.preventDefault();
            let name = $.trim($(".form-input--username").val());
            let password = $.trim($("#reg-password").val());
            let rePassword = $.trim($("#re-password").val());
            let email = $.trim($("#reg-email").val());
            let skype = ($.trim($("#skype").val()) == '') ? ' ' : ($.trim($("#skype").val()));

            // ВАЛИДАЦИЯ РЕГИСТРАЦИИ
            let errors = [];

            // проверка сопадения паролей
            if (password !== rePassword) {
                errors.push('пароли не совпадают ');
                $(".check-re-password").removeClass("reg-check--disable");
            }
            // проверка username на соответствие регулярному выражению
            if ((!$("#username").val().match((/^[а-яА-ЯёЁa-zA-Z0-9]+\s+[а-яА-ЯёЁa-zA-Z0-9]+$/g))) && (!$("#username").val().match((/^[а-яА-ЯёЁa-zA-Z0-9]+$/g)))) {
                errors.push('логин может состоять только из букв английского алфавита и цифр');
                if (getCookie('btnLang') === 'rus-lang') {
                    checkText = 'ввести можно только буквы и цифры';
                } else {
                    checkText = 'only letters and numbers can be entered';
                }
                $(".reg-check-name").removeClass("reg-check--disable").html(checkText);
            }

            if ($("#username").val().length < 3 || $("#username").val().length > 30) {
                errors.push('имя может быть от 3 до 30 символов');
                if (getCookie('btnLang') === 'rus-lang') {
                    checkText = 'имя должно быть от 3 до 30 символов';
                } else {
                    checkText = 'the name must be between 3 and 30 characters long';
                }
                $(".reg-check-name").removeClass("reg-check--disable").html(checkText);
            }

            // проверка email на соответствие регулярному выражению
            if (!$("#reg-email").val().match((/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/g)) == true) {
                errors.push('некорректный email');
                if (getCookie('btnLang') === 'rus-lang') {
                    checkText = 'формат: name@email.com';
                } else {
                    checkText = 'format: name@email.com';
                }
                $(".reg-check-email").removeClass("reg-check--disable").html(checkText);
            }

            // проверка пароля на количество символов
            if ($("#reg-password").val().length < 6) {
                errors.push('пароль не может быть меньше 6 символов');
                if (getCookie('btnLang') === 'rus-lang') {
                    checkText = 'пароль не может быть меньше 6 символов';
                } else {
                    checkText = 'password cannot be less than 6 characters';
                }
                $(".reg-check-pass").removeClass("reg-check--disable").html(checkText);
            }
            if (!$("#reg-password").val().match(/^(?=.*[a-z])(?=.*[A-Z])(?=(.*[a-zA-Z])).{6,20}$/g)) {
                errors.push('пароль не может быть меньше 6 символов');
                if (getCookie('btnLang') === 'rus-lang') {
                    checkText = 'пароль должен содержать заглавные буквы и цифры';
                } else {
                    checkText = 'the password must contain capital letters and numbers';
                }
                $(".reg-check-pass").removeClass("reg-check--disable").html(checkText);
            }

            // проверка на пустоту
            $(".register-form .required-input").each(function (k, val) {
                if ($(this).val() == '') {
                    errors.push('не заполнено ' + $(this).attr('placeholder'));
                    if (getCookie('btnLang') === 'rus-lang') {
                        checkText = 'поле обязательно для заполнения';
                    } else {
                        checkText = 'this field is required';
                    }
                    $(this).next("div").removeClass("reg-check--disable").html(checkText);
                }

                // сброс check-ов при фокусе
                $(this).focus(function () {
                    if (k == 2 || k == 1) {
                        $(".check-re-password").addClass("reg-check--disable");
                    }
                    $(this).next("div").addClass("reg-check--disable");
                });
            });

            function getFormatDate(join) {
                join = join || ' '; // разделитель по дефолту

                var d = new Date();
                return addZero(d.getFullYear() + join + addZero(d.getMonth() + 1) + join + d.getDate());
            }

            function addZero(num) {
                return +num < 10 ? '0' + num : num
            }

            // console.log(getFormatDate('.'));
            let registerDate = getFormatDate('.');
            // FETCH

            if (errors.length === 0) {
                let params = {
                    name: name,
                    password: password,
                    email: email,
                    skype: skype,
                    register: registerDate,
                    status: 'new',
                    avatar: ' ',
                    'method': 'register'
                };
                // console.log(params);
                let response = fetch('handle.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify(params)
                });
                response.then(function (data) {
                    return data.json()
                }).then(function (data) {
                    console.log(data);
                    if (data.success) {
                        localStorage.setItem('email', data.email);
                        setCookie('name', data.name);
                        registerUser();
                        changeLoginBtnToUserName();
                        // console.log(data.name);
                        $(".user-login__elem--user-name").html(data.name);
                        /*-- если логин после нажатия на кнопку "получить беспдатное занятие"
                             * То редирект на страницу free-lesson*/
                        if (localStorage.getItem('status') === 'free-lesson') {
                            $(location).attr('href', '/free-lesson.php');
                        }

                        let mailForUser = {
                            name: name,
                            email: email,
                            'method': 'register'
                        }
                        let mailForAdmin = {
                            name: name,
                            email: email,
                            'method': 'registerNewUser'
                        }
                        axios.post('/mailer.php', JSON.stringify(mailForUser))
                        axios.post('/mailer.php', JSON.stringify(mailForAdmin))


                    } else {
                        checkText = data.error;
                        $(".reg-check-email").removeClass("reg-check--disable").html(checkText);
                    }
                });

                // $("#mysite").addClass("body-fixed");
                $(".reg-success-btn").click(function () {
                    $(".register-success").removeClass("register-success-active");
                    $("#mysite").removeClass("body-fixed");
                });
            } else {
                console.log(errors);
            }


        });
    }


    function login() {
        let loginBtn = document.querySelector(".form-submit-login");
        loginBtn.addEventListener("click", function (e) {
            e.preventDefault();

            // ВАЛИДАЦИЯ LOGIN
            let errors = [];
            // проверка email на соответствие регулярному выражению
            if (!$("#email").val().match((/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/g)) == true) {
                errors.push('некорректный email');
                $(".login-check-email").removeClass("login-check--disable");
            }

            $(".login-form .form-input").each(function (k, val) {
                // проверка на пустоту
                if ($(this).val() == '') {
                    errors.push('не заполнено ' + $(this).attr('placeholder'));
                    $(this).next("div").removeClass("login-check--disable");
                }
                // сброс check-ов при фокусе
                $(this).focus(function () {
                    $(this).next("div").addClass("login-check--disable");
                });
            });

            if (errors.length === 0) {
                let inputData = {
                    email: $("#email").val(),
                    password: $("#password").val(),
                    'method': 'login'
                };
                let response = fetch('handle.php', {
                    method: 'Post',
                    headers: {
                        'Content-Type': 'application/json;charset=utf-8'
                    },
                    body: JSON.stringify(inputData)
                });
                response.then(function (data) {
                    return data.json()
                }).then(function (data) {
                    console.log(data);
                    // установка localstor user_id для croppie
                    // console.log(localStorage.getItem('user_id'));
                    if (data.success) {
                        localStorage.setItem('user_id', data.userID);
                        localStorage.setItem('email', data.email);

                        if (data.status === 'admin') {
                            document.location.href = '/index.php'
                        }
                        if (data.status === 'user') {
                            setCookie('name', data.name);
                            authorizedUser();
                            changeLoginBtnToUserName();
                            $(".user-login__elem--user-name").html(data.name);

                            // -- если логин после нажатия на кнопку "получить беспдатное занятие"
                            // то редирект на страницу free-lesson
                            axios.post('/handle.php', JSON.stringify({'method': 'checkLoginOnBookedLesson'}))
                                .then((response) => {
                                    if (localStorage.getItem('status') === 'free-lesson') {
                                        if (response.data['status_2'] === 'new') {
                                            $(location).attr('href', '/free-lesson.php');
                                        }
                                    }
                                });

                            // если user находится на странице бронирования - нужно
                            // перезагрузить страницу при входе
                            if ($('main').hasClass('private-lesson') || $('main').hasClass('speaking-club')) {
                                window.location.reload();
                            }
                            // ---------- подгрузка аватара в header
                            if (data.avatar.trim() !== '') {
                                // $('.avatar').css('backgroundImage', 'url(' + data.avatar + ')');
                                $('.user-login__elem--avatar').attr('src', '..' + data.avatar + '');
                            }
                        }
                    } else {
                        if (data.status === 'blocked') {
                            let checkText;
                            if (getCookie('btnLang') === 'rus-lang') {
                                checkText = 'пользователь заблокирован';
                            } else {
                                checkText = 'the user is blocked';
                            }
                            $(".login-invalid p").html(checkText);
                        } else {
                            // $(".login-invalid p").html('неверные email или пароль');
                            $(".login-invalid").removeClass("login-invalid--disable");
                        }

                    }
                    // login
                });

            } else {
                console.log(errors);
            }
        });
    }

    function loginOnReload() {
        window.addEventListener("load", function (e) {
            // ----  удалить Localstorage
            delete localStorage.status;
            let data = {
                'method': 'reload'
            };
            let response = fetch('handle.php', {
                method: 'Post',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(data)
            });

            response.then(function (data) {
                return data.json()
            }).then(function (data) {
                // console.log(data)
                $('.form-input').each((k,val)=>{
                    $(val).val('');
                });

                if (data.success) {
                } else {
                    deleteCookie('name');
                    $(".btn-login").removeClass("disable");
                    $(".user-login").addClass("disable").removeClass("active-flex");
                }
            });
        });
    }

    function resetOnFocus() {
        $(".login-form .form-input").each(function (e) {
            $(this).focus(function () {
                $(".login-invalid").addClass("login-invalid--disable");
            });
        });
    }

    function logout() {
        $(".user-login-menu__elem--logout").click(function (e) {
            e.preventDefault();
            let inputData = {
                'method': 'logout'
            };
            let response = fetch('handle.php', {
                method: 'Post',
                headers: {
                    'Content-Type': 'application/json;charset=utf-8'
                },
                body: JSON.stringify(inputData)
            });
            response.then(function (data) {
                return data.json()
            }).then(function (data) {
                console.log(data.logout)
                if (data.logout === true) {
                    deleteCookie('name');
                    delete localStorage.email;
                    delete localStorage.user_id;
                    document.location.href = '/index.php'
                    // console.log('logout');
                } else {
                    console.log('не удалось выйти')
                }
            });
        });
    }



    function setCookie(name, value, options = {}) {
        options = {
            path: '/',
            ...options
        };
        if (options.expires instanceof Date) {
            options.expires = options.expires.toUTCString();
        }
        let updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);

        for (let optionKey in options) {
            updatedCookie += "; " + optionKey;
            let optionValue = options[optionKey];
            if (optionValue !== true) {
                updatedCookie += "=" + optionValue;
            }
        }
        document.cookie = updatedCookie;
    }

    function deleteCookie(name) {
        setCookie(name, "", {
            'max-age': -1
        })
    }

    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

});
