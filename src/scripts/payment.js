import axios from "axios";

$(document).ready(function () {
    if ($("main").hasClass('payment')) {
        // console.log('payment init');
        const mediaQueryDesktop = window.matchMedia('(min-width: 1024px)');
        if ($('.payment-gateway-main__price').html() === '$.00') {
            window.location.href = '/index'
        }
        setTimeout(()=>{
            $('#preloader').css('display', 'none');
        },700);

        document.addEventListener("scroll", function (e) {
            // // console.log(window.pageYOffset);
            if (mediaQueryDesktop.matches) {
                if (window.pageYOffset > 50) {
                    $('.success-frame-content').addClass('success-frame-content-unfix')
                    $('.success-frame').addClass('success-frame-unfix');
                } else {
                    $('.success-frame-content').removeClass('success-frame-content-unfix')
                    $('.success-frame').removeClass('success-frame-unfix');
                }
            }
        });


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
            let elem = $('.payment-gateway__elem--info');
            let array = [];

            if (elem) {
                elem.each((k, val) => {
                    let name = $(val).attr('name');
                    let time = $(val).attr('time');
                    let date = $(val).attr('date');
                    let gmt = $(val).attr('gmt');
                    let obj = {
                        name: name,
                        time: time,
                        date: date,
                        gmt: gmt,
                        'method': 'confirmLessons',
                    }
                    array.push(obj);
                })
            }
            // console.log(array);



            axios.post('/handle.php', JSON.stringify(array))
                .then((response) => {
                    if (response.data === 'success') {
                        $('.success-frame').addClass('success-frame-active');
                        $('.payment-gateway').addClass('payment-gateway-hidden');
                        $('.instruction__item--two').removeClass('instuction-active');
                        $('.instruction__item--three').addClass('instuction-active');
                    }
                });



            let mailForUser = {
                name: getCookie('name'),
                email: localStorage.getItem('email'),
                data: array,
                'method': 'confirmPayByUser'
            }
            let mailForAdmin = {
                name: getCookie('name'),
                email: localStorage.getItem('email'),
                data: array,
                'method': 'confirmPayByUserToAdmin'
            }
            axios.post('/mailer.php', JSON.stringify(mailForUser))
            axios.post('/mailer.php', JSON.stringify(mailForAdmin))
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