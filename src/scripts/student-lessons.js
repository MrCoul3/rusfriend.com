$(document).ready(function () {
    if ($('main').hasClass('student-lessons')) {
        console.log('student-lessons.js init')

        $('.content-elem').each((k, val) => {
            if ($(val).attr('confirmation') == 0 && $(val).attr('payment') === 'unpayed') {
                console.log($(val).siblings('a'))
                $(val).addClass('unconfirmed');
                $(val).siblings('a').addClass('pay-btn-active');
            }
            if ($(val).attr('confirmation') == 1 && $(val).attr('payment') === 'unpayed') {
                $(val).addClass('unpaid');
                $(val).siblings('p').addClass('unpaid-lesson-active');
            }
            if ($(val).attr('confirmation') == 1 && $(val).attr('payment') === 'payed') {
                $(val).addClass('payed');
                $(val).siblings('span').addClass('payed-lesson-active');
            }
        })


    }
});