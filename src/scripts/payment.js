import axios from "axios";

$(document).ready(function () {
    if ($("main").hasClass('payment')) {
        console.log('payment init');

        // ---- закрытие окна FAQ
        $('.payment-gateway-main__faq').click(() => {
            $('.faq').addClass('faq-active');
        })
        $('.close-btn').click(()=>{
            $('.faq').removeClass('faq-active');
        })
        //------------------------------------

        // --- confirm btn click
        $('.payment-gateway-main__confirm-btn').click( () => {
            let array = [];
            let elem = $('.payment-gateway__elem--info');

            if (elem) {
                elem.each((k, val) => {
                    let name = $(val).attr('name');
                    let time = $(val).attr('time');
                    let date = $(val).attr('date');
                    let obj = {
                        name: name,
                        time: time,
                        date: date,
                        'method': 'confirmLessons',
                    }
                    array.push(obj);
                })
            }


            console.log(array);

            axios.post('/handle.php', JSON.stringify(array))
                .then((response) => {
                    if (response.data === 'success') {
                        $('.success-frame').addClass('success-frame-active');
                        $('.payment-gateway').addClass('payment-gateway-hidden');
                        $('.instruction__item--two').removeClass('instuction-active');
                        $('.instruction__item--three').addClass('instuction-active');
                    }
                });
        })

        // ----------- getCookie
        function getCookie(name) {
            let matches = document.cookie.match(new RegExp(
                "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
            ));
            return matches ? decodeURIComponent(matches[1]) : undefined;
        }
        //----------------------------------------------
    }
});