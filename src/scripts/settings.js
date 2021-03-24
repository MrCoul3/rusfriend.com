$(document).ready(function () {
        console.log('settings init');
        // -------------------------
        moveSettingWindow();
        closeSettings();

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
                $('.setting').removeClass('settings-active');
            });
        }

        // -----------------------------------------


    }
);