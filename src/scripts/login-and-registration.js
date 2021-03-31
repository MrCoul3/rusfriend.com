$(document).ready(function () {
    if (!$('body').hasClass('admin')) {
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


    function openLoginForm() {
        $(".btn-login").click(function () {
            if (!$(".login-form").hasClass('login-form-active')) {
                $(".login-form").addClass('login-form-active');
                $("#mysite").addClass("body-fixed");
                // $('.header__overhead').addClass('header-fixed');
                // $('.login-form .form-frame').animate({
                //     'width': '364px',
                //     'height': '364px'
                // },100);
            }
        });
    }

    function closeLoginForm() {
        $(".form-close-btn").click(function () {
            if ($(".login-form").hasClass('login-form-active')) {
                $(".login-form").removeClass('login-form-active');

            }
            if ($(".register-form").hasClass('register-form-active')) {
                $(".register-form").removeClass('register-form-active');
            }
            $("#mysite").removeClass("body-fixed");
            // $('.header__overhead').removeClass('header-fixed');
            $(".login-invalid").addClass("login-invalid--disable");
        });
    }

    function changeForms() {
        $(".reg-log-changer").click(function () {
            if ($(".login-form").hasClass('login-form-active')) {
                $(".login-form").removeClass('login-form-active');
                $(".register-form").addClass("register-form-active");
            } else {
                $(".login-form").addClass('login-form-active');
                $(".register-form").removeClass("register-form-active");
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

    function authorizedUser() {
        $(".login-form").removeClass("login-form-active");
        $("#mysite").removeClass("body-fixed");
    }
    function common() {
        $(".btn-login").addClass("disable");
        $(".user-login").removeClass("disable").addClass("active-flex");
    }



    function registration() {
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
                $(".reg-check-name").removeClass("reg-check--disable").html('ввести можно только буквы и цифры');
            }

            if ($("#username").val().length < 3 || $("#username").val().length > 30) {
                errors.push('имя может быть от 3 до 30 символов');
                $(".reg-check-name").removeClass("reg-check--disable").html('имя должно быть от 3 до 30 символов');
            }

            // проверка email на соответствие регулярному выражению
            if (!$("#reg-email").val().match((/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/g)) == true) {
                errors.push('некорректный email');
                $(".reg-check-email").removeClass("reg-check--disable").html('формат: name@email.com');
            }

            // проверка пароля на количество символов
            if ($("#reg-password").val().length < 6) {
                errors.push('пароль не может быть меньше 6 символов');
                $(".reg-check-pass").removeClass("reg-check--disable").html('пароль не может быть меньше 6 символов');
            }
            if (!$("#reg-password").val().match(/^(?=.*[a-z])(?=.*[A-Z])(?=(.*[a-zA-Z])).{6,20}$/g)) {
                errors.push('пароль не может быть меньше 6 символов');
                $(".reg-check-pass").removeClass("reg-check--disable").html('пароль должен содержать заглавные буквы и цифры');
            }

            // проверка на пустоту
            $(".register-form .required-input").each(function (k, val) {
                if ($(this).val() == '') {
                    errors.push('не заполнено ' + $(this).attr('placeholder'));
                    $(this).next("div").removeClass("reg-check--disable").html('поле обязательно для заполнения');
                }

                // сброс check-ов при фокусе
                $(this).focus(function () {
                    if (k == 2 || k == 1) {
                        $(".check-re-password").addClass("reg-check--disable");
                    }
                    $(this).next("div").addClass("reg-check--disable");
                });
            });

            // FETCH
            if (errors.length === 0) {
                let params = {
                    name: name,
                    password: password,
                    email: email,
                    skype: skype,
                    status: 'active',
                    'method': 'register'
                };
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
                        setCookie('name', data.name);
                        registerUser();
                        common();
                        console.log(data.name);
                        $(".user-login__elem--user-name").html(data.name);
                    } else {
                        $(".reg-check-email").removeClass("reg-check--disable").html('пользователь с таким email уже существует');
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

    function registerUser() {
        $(".register-form").removeClass("register-form-active");
        $(".register-success").addClass("register-success-active");
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
                $(".login-check-email").removeClass("login-check--disable").html('формат: name@email.com');
            }

            $(".login-form .form-input").each(function (k, val) {
                // проверка на пустоту
                if ($(this).val() == '') {
                    errors.push('не заполнено ' + $(this).attr('placeholder'));
                    $(this).next("div").removeClass("login-check--disable").html('поле обязательно для заполнения');
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
                    if (data.success) {
                        if (data.status === 'admin') {
                            document.location.href = '/index.php'
                            authorizedUser();
                        }
                        if (data.status === 'user') {
                            setCookie('name', data.name);
                            authorizedUser();
                            common();
                            $(".user-login__elem--user-name").html(data.name);
                            //если user находится на странице бронирования - нужно
                            // перезагрузить страницу при входе
                            if ($('main').hasClass('private-lesson') || $('main').hasClass('speaking-club')) {
                                window.location.reload();
                            }
                        }
                    } else {
                        $(".login-invalid").removeClass("login-invalid--disable");
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
                console.log(data)
                if (data.success) {

                    if (data.status === 'user') {
                        authorizedUser();
                        common();
                        $(".user-login__elem--user-name").html(data.name);
                    }

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
                    $(".btn-login").removeClass("disable").addClass('active-block');
                    $(".user-login").addClass("disable").removeClass("active-flex");
                    deleteCookie('name');
                    console.log('logout');
                    if ($('main').hasClass('private-lesson') || $('main').hasClass('speaking-club')) {
                        window.location.reload();
                    }
                    if ($('main').hasClass('student-lessons')) {
                        document.location.href = '/index.php'
                    }
                } else {
                    console.log('не удалось выйти')
                }
            });
        });
    }

    function deleteCookie(name) {
        setCookie(name, "", {
            'max-age': -1
        })
    }
    function setCookie(name, value, options = {}) {

        options = {
            path: '/',
            // при необходимости добавьте другие значения по умолчанию
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

});
