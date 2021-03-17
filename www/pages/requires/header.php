<?php session_start();
require('service.html');

if (isset($_SESSION['email'])) {
    $status = [
        'logout' => ['disable', 'disable'],
        'login'=>['active-block', 'active-flex']
    ];
} else {
    $status = [
        'logout' => ['active-block', 'active-flex'],
        'login'=>['disable', 'disable']
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8">
</head>
<body id="mysite">

<section class="login-form authorization-forms">
    <div class="form-frame">
        <div class="container">
            <h3 class="form-title">Вход</h3>
            <div class="logo-mobile-ver"></div>
            <div class="form-close-btn form-close-btn--login-form"></div>
            <!--img(src="../images/icons/close-btn.svg", alt="close").form-close-btn.form-close-btn--login-form-->
        </div>
        <!--img(src="../images/icons/form-decor-line.svg", alt="line").decor-line.decor-line--login-form-->
        <div class="decor-line decor-line--login-form"></div>
        <form class="form login-form">
            <input class="form__elem form-input form-input--email" type="email" placeholder="email" id="email">
            <div class="login-check login-check-email login-check--disable">поле обязательно для заполнения</div>
            <label class="label-email" for="email"></label>
            <input class="form__elem form-input form-input--password" type="password" placeholder="пароль"
                   id="password">
            <div class="login-check login-check-password login-check--disable">поле обязательно для заполнения</div>
            <label class="label-password" for="password"></label>
            <div class="login-invalid login-invalid--disable">
                <p>неверные email или пароль</p>
            </div>
            <p class="reg-log-changer form__elem">У вас нет аккаунта? Регистрация</p>
            <div class="decor-line decor-line--login-form"></div>
            <input class="form__elem form-submit form-submit-login button" type="submit" value="войти">
        </form>
    </div>
</section>
<section class="register-form authorization-forms">
    <div class="form-frame">
        <div class="container">
            <h3 class="form-title">Регистрация</h3>
            <div class="logo-mobile-ver"></div>
            <div class="form-close-btn form-close-btn--register-form"></div>
            <!--img(src="../images/icons/close-btn.svg", alt="close").form-close-btn.form-close-btn--register-form-->
        </div>
        <div class="decor-line decor-line--login-form"></div>
        <form class="form" method="post">
            <input class="form__elem form-input form-input--username required-input" type="text"
                   placeholder="имя пользователя" id="username" name="username">
            <div class="reg-check reg-check-name reg-check--disable">поле обязательно для заполнения</div>
            <label for="username"></label>
            <input class="form__elem form-input form-input--password required-input" type="password"
                   placeholder="пароль" id="reg-password" name="password">
            <div class="reg-check reg-check-pass reg-check--disable">поле обязательно для заполнения</div>
            <label class="label-password" for="password"></label>
            <input class="form__elem form-input form-input--re-password required-input" type="password"
                   placeholder="повторите пароль" id="re-password">
            <label class="label-re-password" for="re-reg-password"></label>
            <div class="reg-check check-re-password reg-check--disable">пароли не совпадают</div>
            <input class="form__elem form-input form-input--email required-input" type="email" placeholder="email"
                   id="reg-email" name="email">
            <div class="reg-check reg-check-email reg-check--disable">поле обязательно для заполнения</div>
            <label class="label-email" for="email"></label>
            <input class="form__elem form-input form-input--skype" type="text" placeholder="skype" id="skype"
                   name="skype">
            <label for="skype"></label>
            <p class="reg-log-changer form__elem">Уже зарегестрированы? Войти</p>
            <div class="decor-line decor-line--login-form"></div>
            <input class="form__elem form-submit form-submit-register button" type="submit" value="зарегестрироваться">
        </form>
    </div>
</section>
<section class="register-success">
    <div class="register-success__frame"><img class="success-img" src="../images/icons/succes.svg" alt="success">
        <h2>Поздравляем, <br> Вы успешно зарегистрировались!</h2>
        <h3>Теперь вы можете полностью использовать функционал сайта. <br> Что бы забронировать урок - перейдите в
            раздел<br> <a href="">“Занятие с преподавателем” </a></h3>
        <div class="button reg-success-btn">далее</div>
    </div>
</section>

<header class="header">
    <div class="header__overhead">
        <div class="social-net-btns social-net-btns--header">
            <a class="social-net-btns__elem social-net-btns__elem--instagram" href="../"></a>
            <a class="social-net-btns__elem social-net-btns__elem--tiktok" href="../"></a>
        </div>
        <a class="header-logo" href="index.php">
            <!--img(src="images/icons/logo.svg", alt="logo")--></a>
        <div class="service-btns">
            <div class="btn-change-lang language <?=$_COOKIE['btnLang'] ? $_COOKIE['btnLang'] : 'eng-lang'?>">
                <div class="lang-changer language <?=$_COOKIE['langChanger'] ? $_COOKIE['langChanger'] : 'rus-lang'?>"></div>
            </div>

            <div class="btn-login <?= $status['logout'][0] ?>">Войти</div>

            <div class="user-login <?= $status['login'][1] ?>">
                <img class="user-login__elem" src="images/icons/user-ico.svg" alt="">
                <p class="user-login__elem user-login__elem--user-name">
                    <?=$_SESSION['username']?>
                </p>
                <img class="user-login__elem"
                                                                                            src="images/icons/user-arrow.svg"
                                                                                            alt="">
                <div class="user-login-menu">
                    <a class="user-login-menu__elem user-login-menu__elem--messages" href="/">Сообщения</a>
                    <a class="user-login-menu__elem user-login-menu__elem--lessons" href="../">Мои уроки</a>
                    <a class="user-login-menu__elem user-login-menu__elem--settings" href="../">Настройки</a>
                    <div class="decor-line decor-line--user-login-menu"></div>
                    <a class="user-login-menu__elem user-login-menu__elem--logout" href="../index.php">Выход</a>
                </div>
            </div>

            <div class="burger-btn">
                <input class="burger-menu burger-menu-input" type="checkbox" id="burger">
                <label class="burger-menu-label" for="burger">
                    <div class="burger-menu-line"></div>
                    <div class="burger-menu-line"></div>
                    <div class="burger-menu-line"></div>
                </label>
            </div>
        </div>
    </div>
    <div class="decor-line decor-line--header decor-line--header-mobile"></div>
    <div class="header__lower inner">
        <div class="decor-line decor-line--header"></div>
        <nav class="header-menu">
            <a class="header-menu--about" href="about.php">Об авторе</a>
            <a class="header-menu--courses" href="courses.php">Курсы</a>
            <a class="header-menu--private" href="private-lesson.php">Занятие с преподавателем</a>
            <a class="header-menu--s-club" href="speaking-club.php">Speaking-club</a>
            <a class="header-menu--guide" href="guide.php">Гайд</a>
        </nav>
        <div class="decor-line decor-line--header decor-line-mobile-hide"></div>
    </div>
</header>