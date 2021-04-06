$(document).ready(function () {
    if ($('main').hasClass('guide')) {
        console.log('guide.js init')
        // карусели
        $(".owl-carousel-1").owlCarousel({
            margin: 250,
            autoWidth: true,
            dotsEach: true,
            navSpeed: 500,
            loop: true,
            center: true,
            autoplay: false,

            // navText:[`<img src=${require('../images/icons/icon-arrow--left.svg')}>`, `<img src=${require('../images/icons/icon-arrow--right.svg')}>`],
        });
    }
});