$(document).ready(function () {

    const mediaQueryCartDesktop = window.matchMedia('(min-width: 1024px)'); // не менее 1024

    // --------------- вращение карточек предложений
    // function rotateCards() {
    //     if (mediaQueryCartDesktop.matches) {
    //         $(".offers-cards-conteiner").each(function (key, val) {
    //             $(this).mouseover(function (e) {
    //                 if ($(this).children('.offers-cards__card').hasClass('card-rotate-back')) {
    //                     $(this).children('.offers-cards__card').removeClass('card-rotate-back');
    //                 }
    //
    //                 $(this).children('.offers-cards__card').addClass('card-rotate-forward');
    //                 let front = $(this).find('div.card-content--front');
    //                 let back = $(this).find('div.card-content--end');
    //
    //                 let frontTimeOut = setTimeout(function () {
    //                     front.removeClass('card-side-active');
    //                 }, 150);
    //                 let backTimeOut = setTimeout(function () {
    //                     back.addClass('card-side-active');
    //                 }, 170);
    //
    //             });
    //             $(this).mouseout(function (e) {
    //                 if ($(this).children('.offers-cards__card').hasClass('card-rotate-forward')) {
    //                     $(this).children('.offers-cards__card').removeClass('card-rotate-forward');
    //                 }
    //                 $(this).children('.offers-cards__card').addClass('card-rotate-back');
    //                 let front = $(this).find('div.card-content--front');
    //                 let back = $(this).find('div.card-content--end');
    //                 let frontTimeOut = setTimeout(function () {
    //                     front.addClass('card-side-active');
    //                 }, 150);
    //                 let backTimeOut = setTimeout(function () {
    //                     back.removeClass('card-side-active');
    //                 }, 170);
    //
    //             });
    //         });
    //     }
    // }
    function rotateCards() {
        if (mediaQueryCartDesktop.matches) {
            $(".detail-btn").each(function (key, val) {
                $(this).click(function (e) {
                    // console.log($(this).parent().parent())
                    $(this).parent().parent().addClass('card-rotate-forward');

                    let front = $(this).parent();
                    let back = front.next();

                    let frontTimeOut = setTimeout(function () {
                        front.removeClass('card-side-active');
                    }, 150);
                    let backTimeOut = setTimeout(function () {
                        back.addClass('card-side-active');
                    }, 170);
                });
            });
        }
    }

    $(window).resize(function (e) {
        rotateCards();
    });
    rotateCards();

});