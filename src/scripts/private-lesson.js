$(document).ready(function () {

    $('.book-privateless-btn').click(function (e) {
        e.preventDefault();
        $('.privateless').addClass('hide-session');
        $('#booking-calendar').addClass('show-session');
    })
});