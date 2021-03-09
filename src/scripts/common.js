$(document).ready(function () {
    if ($('main').hasClass("private-lesson")) {
        $('.header-menu--private').addClass('menu-item-active');
    }
    if ($('main').hasClass("speaking-club")) {
        $('.header-menu--s-club').addClass('menu-item-active');
    }
    if ($('main').hasClass("guide")) {
        $('.header-menu--guide').addClass('menu-item-active');
    }
    if ($('main').hasClass("courses")) {
        $('.header-menu--courses').addClass('menu-item-active');
    }
    if ($('main').hasClass("about-page")) {
        $('.header-menu--about').addClass('menu-item-active');
    }
});
