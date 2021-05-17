$(document).ready(function () {

    const mediaQueryDesktop = window.matchMedia('(min-width: 1024px)'); // не менее 1024
    const mediaQueryTablet = window.matchMedia('(max-width: 1024px)'); // работает только не более 1024
    // const mediaQueryMobile = window.matchMedia('(max-width: 767px)'); // работает только на мобильных / не более 767
    rotateCards();
    openLinkByOffersCardsMobile();
    $(window).resize(function () {
        // при смене ширины экрана возврат в исходное карточек предложений
        if (mediaQueryTablet.matches) {
            $('.offers-cards__card').removeClass('card-rotate-forward');
            $('.card-content--front').addClass('card-side-active');
            $('.card-content--end ').removeClass('card-side-active');
        }
        rotateCards();
        openLinkByOffersCardsMobile();
    });

    function rotateCards() {
        if (mediaQueryDesktop.matches) {
            $(".detail-btn").each(function (key, val) {
                $(this).click(function (e) {
                    // // console.log($(this).parent().parent())
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

    // ---------- открытие ссылок по клику на кнопку начать карточек предложений на таблете и мобильной версии
    function openLinkByOffersCardsMobile() {
            $('.offers-cards-conteiner--courses').click(function (e) {
                if (mediaQueryTablet.matches) {
                    if ($(e.target).closest('.offers-cards__card--courses .card-content')) {
                        $(location).attr('href', '/courses');
                    }
                }
            })
            $('.offers-cards-conteiner--private').click(function (e) {
                if (mediaQueryTablet.matches) {
                    if ($(e.target).closest('.offers-cards__card--private .card-content')) {
                        $(location).attr('href', '/private-lesson');
                    }
                }
            })
            $('.offers-cards-conteiner--s-club').click(function (e) {
                if (mediaQueryTablet.matches) {
                    if ($(e.target).closest('.offers-cards__card--s-club .card-content')) {
                        $(location).attr('href', '/speaking-club');
                    }
                }
            })
        }
});