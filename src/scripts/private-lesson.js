$(document).ready(function () {

// для страницы перед календарем бронирования
    $('.book-privateless-btn').click(function (e) {
        e.preventDefault();
        $('.privateless').addClass('hide-session');
        $('#booking-calendar').addClass('show-session');
    })


});