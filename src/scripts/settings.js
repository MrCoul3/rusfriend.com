$(document).ready(function () {
        console.log('settings init');
        // -------------------------
        moveSettingWindow();
        closeSettings();
        changeSettings();

        // ----------- функционал перемещения меню настроек по экрану
        function moveSettingWindow() {
            let Draggable = require('Draggable');
            let header = document.querySelector('.settings-main-frame__elem--header');
            let frame = document.querySelector('.settings-main-frame');
            let options = {
                handle: header,
            };
            new Draggable(frame, options);
        }

        // -----------------------------------------


        // ------------ close settings
        function closeSettings() {
            $('.close-btn--settings').click(function () {
                $('.settings').removeClass('settings-active');
            });
        }

        // -----------------------------------------

        // ------------ change settings
        function changeSettings() {
            $('.settings').click(function (e) {

                if (e.target.className.includes('change-btn--input')) {

                    let wrap = e.target.parentNode.parentNode;
                    let inputWrap = wrap.nextElementSibling;

                    $('.wrap').removeClass('wrap-hidden');
                    $('.input-wrap').removeClass('input-wrap-active');
                    // console.log(wrap.nextElementSibling);
                    wrap.classList.add('wrap-hidden');
                    inputWrap.classList.add('input-wrap-active');
                }


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
                        check.innerHTML = 'поле не должно быть пустым';

                    } else if (inputField.className.includes('input--name')) {
                        // проверка username на соответствие регулярному выражению
                        if ((!inputField.value.match((/^[а-яА-ЯёЁa-zA-Z0-9]+\s+[а-яА-ЯёЁa-zA-Z0-9]+$/g))) && (!inputField.value.match((/^[а-яА-ЯёЁa-zA-Z0-9]+$/g)))) {
                            errors.push('имя не соответствует регулярному выражению');
                            check.innerHTML = 'ввести можно только буквы и цифры';
                        // проверка на количество символов
                        } else if (inputField.value.length < 3 || inputField.value.length > 30) {
                            errors.push('имя должно быть от 3 до 30 символов');
                            check.innerHTML = 'имя должно быть от 3 до 30 символов';
                        }
                     // проверка email на соответствие формату name@email.com
                    } else if (inputField.className.includes('input--email')) {
                        if (!inputField.value.match((/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/g))) {
                            errors.push('некорректный email');
                            check.innerHTML = 'формат: name@email.com';
                        }
                     // проверка пароля
                    } else if (inputField.className.includes('input--password')) {
                        // проверка старого пароля
                        // if ($('.input--old-pas').val() !== )
                        // проверка совпадения паролей
                        if ($('.input--new-pas').val() !== $('.input--repeat-new-pas').val()) {
                            errors.push('пароли не совпадают ');
                            check.innerHTML = 'пароли не совпадают';
                        // проверка по количеству символов
                        }  else if (inputField.value.length < 6) {
                            errors.push('пароль не должен быть меньше 6 символов');
                            check.innerHTML = 'пароль не должен быть меньше 6 символов';
                        // проверка на заглавные буквы и цифры
                        } else if (!inputField.value.match(/^(?=.*[a-z])(?=.*[A-Z])(?=(.*[a-zA-Z])).{6,20}$/g)) {
                            errors.push('пароль должен содержать заглавные буквы и цифры');
                            check.innerHTML = 'пароль должен содержать заглавные буквы и цифры';
                        }

                    }


                    if (errors.length !== 0) {
                        check.classList.add('check-active');
                    // ----------- если нет ошибок
                    } else {
                        let data = {

                        'method': 'changeSettings',
                        }
                        $.ajax('/handle.php',JSON.stringify(data))

                    }
                }


            });
        }

        // -----------------------------------------
    }
);