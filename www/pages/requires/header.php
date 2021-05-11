<?php session_start();
if (isset($_SESSION['email'])) {
    $status = [
        'logout' => ['disable', 'disable'],
        'login' => ['active-block', 'active-flex']
    ];
} else {
    $status = [
        'logout' => ['active-block', 'active-flex'],
        'login' => ['disable', 'disable']
    ];
}

require("vendor/autoload.php");
$obj = new \Classes\User();
$res = $obj->checkSkype();
$userInfo = $obj->getUserInfo();
function switchLang()
{
    if ( $_COOKIE['btnLang']) {
        return $_COOKIE['btnLang'];
    } else {
        return 'eng-lang';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8">
    <link href="styles/app.css" rel="stylesheet">
    <link rel="stylesheet" href="../../styles/croppie/croppie.css"/>
    <link rel="stylesheet" href="../../styles/croppie/jquery.arcticmodal.css"/>
    <link rel="stylesheet" href="../../styles/croppie/themes/simple.css">
</head>

<body id="mysite">

<?php require 'pages/requires/login-form.php' ?>

<?php require 'pages/requires/register-form.php' ?>



<section class="register-success">
    <div class="register-success__frame"><img class="success-img" src="../images/icons/succes.svg" alt="success">
        <h2 switch-lang="<?=switchLang()?>" switchable-text="Поздравляем, <br> Ты успешно зарегистрировался!">Congratulations, <br> You have successfully registered!</h2>
        <h3 switch-lang="<?=switchLang()?>" switchable-text="Теперь ты можешь полностью использовать функционал сайта. <br> Что бы забронировать урок - перейди в раздел<br>">Now you can fully use the site's functionality. <br> To book a lesson, go to the section<br></h3>
            <a switch-lang="<?=switchLang()?>" switchable-text="Занятие с преподавателем," href="/private-lesson">Individual lesson,</a>
            <span switch-lang="<?=switchLang()?>" switchable-text="если ты только начинаешь учить русский, <br> или в раздел">if you are just starting to learn Russian, <br> or in the section</span>
            <a switch-lang="<?=switchLang()?>" switchable-text="Разговорный клуб" href="/speaking-club">Speaking - Club,</a>
            <span switch-lang="<?=switchLang()?>" switchable-text="если ты уже немного говоришь по-русски">if you already speak a little Russian</span>

        <div switch-lang="<?=switchLang()?>" switchable-text="закрыть" class="button reg-success-btn">close</div>
    </div>
</section>

<?php require 'pages/requires/settings.php' ?>

<header class="header">
    <div class="header__overhead">
        <div class="social-net-btns social-net-btns--header">
            <a class="social-net-btns__elem social-net-btns__elem--instagram"
               href="https://www.instagram.com/svetlana_totrova/" target="_blank"></a>
            <a class="social-net-btns__elem social-net-btns__elem--tiktok" href="../"></a>
        </div>
        <a class="header-logo" href="index">
            <!--img(src="images/icons/logo.svg", alt="logo")--></a>
        <div class="service-btns">
            <div class="btn-change-lang language <?= $_COOKIE['btnLang'] ? $_COOKIE['btnLang'] : 'eng-lang' ?>">
                <div class="lang-changer language <?= $_COOKIE['langChanger'] ? $_COOKIE['langChanger'] : 'rus-lang' ?>"></div>
            </div>

            <div switch-lang="<?=switchLang()?>" switchable-text="Войти" class="btn-login <?= $status['logout'][0] ?>">Login</div>

            <div class="user-login <?= $status['login'][1] ?>">
                <img class="user-login__elem user-login__elem--avatar" src="<?=(trim($userInfo['avatar']) !== "") ? $userInfo['avatar'] : '../images/icons/user-ico.svg'?>" alt="SD">


                <p class="user-login__elem user-login__elem--user-name">
                    <?= $_SESSION['name'] ?>
                </p>
                <img class="user-login__elem"
                     src="images/icons/user-arrow.svg"
                     alt="">
                <div class="user-login-menu">
<!--                    <a switch-lang="--><?//=switchLang()?><!--" switchable-text="Сообщения" class="user-login-menu__elem user-login-menu__elem--messages" href="/">Messages</a>-->
                    <a switch-lang="<?=switchLang()?>" switchable-text="Мои уроки" class="user-login-menu__elem user-login-menu__elem--lessons" href="/student-lessons">My lessons</a>
                    <div switch-lang="<?=switchLang()?>" switchable-text="Настройки" class="user-login-menu__elem user-login-menu__elem--settings">Settings</div>
                    <div class="decor-line decor-line--user-login-menu"></div>
                    <a switch-lang="<?=switchLang()?>" switchable-text="Выход" class="user-login-menu__elem user-login-menu__elem--logout" href="../index">Logout</a>
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
    <div class="header__lower">
        <div class="decor-line decor-line--header"></div>
        <nav class="header-menu">
            <a switch-lang="<?=switchLang()?>" switchable-text="Об авторе" class="header-menu--about" href="about">About me</a>
            <a switch-lang="<?=switchLang()?>" switchable-text="Курсы" class="header-menu--courses" href="courses">Courses</a>
            <a switch-lang="<?=switchLang()?>" switchable-text="Занятие с преподавателем" class="header-menu--private" href="private-lesson">Individual lesson</a>
            <a switch-lang="<?=switchLang()?>" switchable-text="Разговорный клуб" class="header-menu--s-club" href="speaking-club">Speaking-club</a>
            <a switch-lang="<?=switchLang()?>" switchable-text="Гайд" class="header-menu--guide" href="guide">Guide</a>
        </nav>
        <div class="decor-line decor-line--header decor-line-mobile-hide"></div>
    </div>
</header>
