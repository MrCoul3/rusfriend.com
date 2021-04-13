import axios from 'axios';
$(document).ready(function () {
        console.log('settings init');
        let user_id = null;
        // -------------------------
        // moveSettingWindow();
        openSettings();
        closeSettings();
        changeSettings();

        // // ----------- функционал перемещения меню настроек по экрану
        // function moveSettingWindow() {
        //     let Draggable
        //     if ($(window).width() > 767) {
        //          Draggable = require('Draggable');
        //     } else {
        //         $('.settings-main-frame').attr('style', '');
        //         Draggable = null;
        //     }
        //     let header = document.querySelector('.settings-main-frame__elem--header');
        //     let frame = document.querySelector('.settings-main-frame');
        //     let options = {
        //         handle: header,
        //     };
        //     new Draggable(frame, options);
        // }
        //
        // // -----------------------------------------

        // ----------- открыть настройки пользователя
        function openSettings() {
            $('.user-login-menu__elem--settings').click(function () {
                // console.log(localStorage.getItem('user_id'));
                $("#mysite").addClass("body-fixed");
                $('.settings-main-frame').addClass('settings-active');
                $('.settings').addClass('settings-active');
                // получение данных при открытии
                axios.post('/handle.php', JSON.stringify({'method': 'getUserInfo'}))
                    .then((response) => {
                        let dataFromDB = response.data
                        user_id = dataFromDB.id;
                        // console.log(response.data);
                        $('.main-text--user-name').html(dataFromDB.name)
                        $('.main-text--email').html(dataFromDB.email);
                        $('.main-text--skype').html(dataFromDB.skype);
                        // ---------- подгрузка аватара
                        if (dataFromDB.avatar.trim() !== '') {
                            $('.avatar').css('backgroundImage', 'url(' + dataFromDB.avatar + ')');
                            // $('.avatar img').attr('src', dataFromDB.avatar);
                        }
                    });

            })
        }
        // -----------------------------

        // ------------ close settings
        function closeSettings() {
            $('.close-btn--settings').click(function () {
                $("#mysite").removeClass("body-fixed");
                $('.settings-main-frame').removeClass('settings-active');
                $('.settings').removeClass('settings-active');
            });
        }
        // -----------------------------------------

        // ------------ change settings
        function changeSettings() {
            $('.settings').click(function (e) {
                let checkText;
                // появление инпута при нажатии изменить
                if (e.target.className.includes('change-btn--input')) {

                    let wrap = e.target.parentNode.parentNode;
                    let inputWrap = wrap.nextElementSibling;

                    $('.wrap').removeClass('wrap-hidden');
                    $('.input-wrap').removeClass('input-wrap-active');
                    // console.log(wrap.nextElementSibling);
                    wrap.classList.add('wrap-hidden');
                    inputWrap.classList.add('input-wrap-active');
                }

                if (e.target.className.includes('change-btn--avatar')) {

                }

                // при нажатии на кнопку "ИЗМЕНИТЬ" после ввода в инпут
                if (e.target.className.includes('change-button')) {

                    let inputField = e.target.previousElementSibling;
                    let check = inputField.previousElementSibling;
                    check.innerHTML = '';
                    let errors = [];

                    // сброс чеков при фокусе

                    inputField.addEventListener('focus', function () {
                        check.classList.remove('check-active');
                    });

                    // проверка на пустоту
                    if (inputField.value.trim() === '') {
                        errors.push('пустое поле');
                        if (getCookie('btnLang') === 'rus-lang') {
                            checkText = 'поле не должно быть пустым';
                        } else {
                            checkText = 'the field must not be empty';
                        }
                        check.innerHTML = checkText;

                    } else if (inputField.className.includes('input--name')) {
                        // проверка username на соответствие регулярному выражению
                        if ((!inputField.value.match((/^[а-яА-ЯёЁa-zA-Z0-9]+\s+[а-яА-ЯёЁa-zA-Z0-9]+$/g))) && (!inputField.value.match((/^[а-яА-ЯёЁa-zA-Z0-9]+$/g)))) {
                            errors.push('имя не соответствует регулярному выражению');
                            if (getCookie('btnLang') === 'rus-lang') {
                                checkText = 'ввести можно только буквы и цифры';
                            } else {
                                checkText = 'only letters and numbers can be entered';
                            }
                            check.innerHTML = checkText;
                            // проверка на количество символов
                        } else if (inputField.value.length < 3 || inputField.value.length > 30) {
                            errors.push('имя должно быть от 3 до 30 символов');
                            if (getCookie('btnLang') === 'rus-lang') {
                                checkText = 'имя должно быть от 3 до 30 символов';
                            } else {
                                checkText = 'the name must be between 3 and 30 characters';
                            }
                            check.innerHTML = checkText;
                        }
                        // проверка email на соответствие формату name@email.com
                    } else if (inputField.className.includes('input--email')) {
                        if (!inputField.value.match((/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/g))) {
                            errors.push('некорректный email');
                            if (getCookie('btnLang') === 'rus-lang') {
                                checkText = 'формат: name@email.com';
                            } else {
                                checkText = 'format: name@email.com';
                            }
                            check.innerHTML = checkText;
                        }
                        // проверка пароля
                    } else if (inputField.className.includes('input--password')) {

                        // проверка совпадения паролей
                        if ($('.input--new-pas').val() !== $('.input--repeat-new-pas').val()) {
                            errors.push('пароли не совпадают ');
                            if (getCookie('btnLang') === 'rus-lang') {
                                checkText = 'пароли не совпадают';
                            } else {
                                checkText = 'passwords dont match';
                            }
                            check.innerHTML = checkText;
                            // проверка по количеству символов
                        } else if (inputField.value.length < 6) {
                            errors.push('пароль не должен быть меньше 6 символов');
                            if (getCookie('btnLang') === 'rus-lang') {
                                checkText = 'пароль не должен быть меньше 6 символов';
                            } else {
                                checkText = 'the password must not be less than 6 characters';
                            }
                            check.innerHTML = checkText;
                            // проверка на заглавные буквы и цифры
                        } else if (!inputField.value.match(/^(?=.*[a-z])(?=.*[A-Z])(?=(.*[a-zA-Z])).{6,20}$/g)) {
                            errors.push('пароль должен содержать заглавные буквы и цифры');
                            if (getCookie('btnLang') === 'rus-lang') {
                                checkText = 'пароль должен содержать заглавные буквы и цифры';
                            } else {
                                checkText = 'the password must contain capital letters and numbers';
                            }
                            check.innerHTML = checkText;
                        }

                    }


                    if (errors.length !== 0) {
                        check.classList.add('check-active');
                        // ----------- если нет ошибок

                    } else {

                        let dataType = e.target.getAttribute('data-type'); // тип отправляемых данных ('name', 'password', 'email', 'skype') Берется из атрибута data-type кнопки "ИЗМЕНИТЬ"

                        // ----------- ИЗМЕНЕНИЕ ПАРОЛЯ ----------- \\
                        let oldPas = $('.input--old-pas');
                        // сброс чека при фокусе
                        oldPas.on('focus', function () {
                            $('.check--old-pass').removeClass('check-active');
                        });

                        if (e.target.className.includes('change-button--password')) {
                            let data = {
                                old: oldPas.val(), // старый пароль
                                data: inputField.value, // новый пароль
                                dataType: dataType,
                                'method': 'changeSettings',
                            }
                            // console.log(JSON.stringify(data));
                            axios.post('/handle.php', JSON.stringify(data))
                                .then((response) => {
                                    let dataFromDB = response.data;
                                    console.log(dataFromDB);
                                    if (dataFromDB !== 'success') {
                                        $('.check--old-pass').addClass('check-active');
                                    } else {
                                        $('.wrap--pass').removeClass('wrap-hidden');
                                        $('.input-wrap--pass').removeClass('input-wrap-active')
                                    }
                                });

                            // ---------------------------------------

                        } else {
                            // ----- ИЗМЕНЕНИЕ ОСТАЛЬНЫХ ПОЛЕЙ (имя, email, skype)
                            let inputWrap = e.target.parentNode.parentNode;
                            let wrap = inputWrap.previousElementSibling;

                            let data = {
                                data: inputField.value,
                                dataType: dataType,
                                'method': 'changeSettings',
                            }
                            // console.log(data);
                            axios.post('/handle.php', JSON.stringify(data))
                                .then((response) => {
                                    // console.log(response.data)
                                    let dataFromDB = response.data;
                                    // если смена успешна, убирается поле ввода с возвратом первоначального состояния
                                    if (dataFromDB.status === 'success') {

                                        if (dataFromDB.type !== 'email') {
                                            wrap.classList.remove('wrap-hidden');
                                            inputWrap.classList.remove('input-wrap-active')
                                            let nameOfFiled = e.target.parentNode.parentNode.previousElementSibling.lastElementChild;
                                            // console.log(nameOfFiled);
                                            nameOfFiled.innerHTML = dataFromDB.name;
                                            // при смене имени меняется имя в шапке сайта и в поле настроек
                                            if (dataFromDB.type === 'name') {
                                                $(".user-login__elem--user-name").html(dataFromDB.name);
                                            }
                                        }


                                    }
                                    // -------------- email
                                    // lang changes
                                    let confirmationCodeText;
                                    let sendCodeText;
                                    let btnConfText;
                                    let enterEmailText;
                                    let change;
                                    let incorCode;
                                    if (getCookie('btnLang') === 'rus-lang') {
                                        confirmationCodeText = 'введите код подтверждения';
                                        sendCodeText = 'вам на почту отправлен код подтверждения';
                                        btnConfText = 'подтвердить';
                                        enterEmailText ='введите email';
                                        change = 'изменить';
                                        incorCode ='неверный код подтверждения';
                                    } else {
                                        confirmationCodeText = 'enter the confirmation code';
                                        sendCodeText = 'a confirmation code has been sent to your email address';
                                        btnConfText = 'confirm';
                                        enterEmailText ='enter email';
                                        change = 'change';
                                        incorCode = 'invalid confirmation code';
                                    }

                                    if (dataFromDB.status === 'unconfirmed') {
                                        // меняется placeholder поля инпут на введите код подтверждения
                                        // console.log(dataFromDB.status);

                                        $('.input--email').attr('placeholder', confirmationCodeText).val('').removeClass('input--email').addClass('confirm-email');
                                        $('.check--email').addClass('check-active').html(sendCodeText);
                                        $('.change-button--email').html(btnConfText).attr('data-type', 'confirm-code');
                                    }
                                    if (dataFromDB.status === 'confirmed') {
                                        console.log(dataFromDB.email);
                                        console.log(dataFromDB);
                                        console.log(dataFromDB.status);
                                        $('.wrap--email').removeClass('wrap-hidden');
                                        $('.input-wrap--email').removeClass('input-wrap-active');
                                        $('.main-text--email').html(dataFromDB.email);

                                        $('.confirm-email').attr('placeholder', enterEmailText).val('').removeClass('confirm-email').addClass('input--email');
                                        $('.change-button--email').html(change).attr('data-type', 'email');
                                    }
                                    if (dataFromDB.status === 'invalid-code') {
                                        // console.log('неверный код подтверждения');
                                        // console.log(dataFromDB.status);
                                        $('.check--email').addClass('check-active').html(incorCode);
                                    }
                                });
                        }

                    }
                }


            });
            // ------- загрузка аватара ../scripts/croppie/script.js

            // function readURL(input) {
            //     if (input.files && input.files[0]) {
            //         let reader = new FileReader();
            //         // console.log(reader)
            //         reader.onload = function(e) {
            //             $('.avatar').css('backgroundImage', 'url(' + e.target.result + ')');
            //         }
            //         reader.readAsDataURL(input.files[0]);
            //     }
            // }
            // $('#download-avatar').change(function(){
            //     axios.post('/handle.php', JSON.stringify({'method': 'getUserInfo'}))
            //         .then((response) => {
            //             let dataFromDB = response.data
            //             console.log(dataFromDB)
            //             user_id = dataFromDB.id;
            //         });
            //     readURL(this);
            //     $('.apply-avatar').addClass('apply-avatar-active ');
            // });
            // $('.apply-avatar').click(function () {
            //
            //     let data = new FormData();
            //     // console.log(document.getElementById('download-avatar').files)
            //     // console.log(document.getElementById('download-avatar').files[0])
            //     let input  = document.getElementById('download-avatar');
            //     data.append('img_path', input.files[0]);
            //     data.append('method','setAvatar');
            //     data.append('user_id', user_id);
            //     console.log(data);
            //     let response = fetch('/handle.php', {
            //         method: 'POST',
            //         headers: {},
            //         body: data,
            //     });
            // })
            // -----------------------------------------

        }
        // -----------------------------------------
    // ----------- getCookie
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }
    //----------------------------------------------
    }
);