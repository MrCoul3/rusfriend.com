<?php session_start();
require('service.html');
//var_dump($_SESSION);
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8">
    <link rel="stylesheet" href="../../styles/croppie/croppie.css"/>
    <link rel="stylesheet" href="../../styles/croppie/jquery.arcticmodal.css"/>
    <link rel="stylesheet" href="../../styles/croppie/themes/simple.css">
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
        <h2>Поздравляем, <br> Ты успешно зарегистрировался!</h2>
        <h3>Теперь ты можешь полностью использовать функционал сайта. <br> Что бы забронировать урок - перейди в
            раздел<br> <a href="/private-lesson.php">“Занятие с преподавателем”,</a>если ты только начинаешь учить
            русский,
            <br> или в раздел <a href="/speaking-club.php">“Speaking - Club”,</a>
            если ты уже немного говоришь по-русски.

        </h3>
        <div class="button reg-success-btn">закрыть</div>
    </div>
</section>

<section class="settings">
    <div class="settings-main-frame">
        <div class="settings-main-frame__elem settings-main-frame__elem--header">
            <div class="move-icon"></div>
            <h3 class="settings-title">Настройки</h3>
            <div class="close-btn close-btn--settings"></div>
        </div>
        <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
        <div class="settings-main-frame__elem settings-main-frame__elem--content">
            <div class="setting-content-elem setting-content-elem--name">
                <div class="wrap">
                    <div class="flex">
                        <p class="placeholder">имя пользователя</p>
                        <div class="change-btn change-btn--input">изменить</div>
                    </div>
                    <div class="main-text main-text--user-name"><?= $_SESSION['name'] ?></div>
                </div>
                <div class="input-wrap">
                    <div class="flex">
                        <div class="check"></div>
                        <input class="input input--name" type="text" placeholder="введите новое имя">
                        <div data-type='name' class="button change-button">изменить</div>
                    </div>
                </div>
            </div>
            <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
            <div class="setting-content-elem setting-content-elem--password">
                <div class="wrap wrap--pass">
                    <div class="flex">
                        <p class="placeholder">пароль</p>
                        <div class="change-btn change-btn--input">изменить</div>
                    </div>
                    <div class="main-text main-text--password">**********</div>
                </div>
                <div class="input-wrap input-wrap--pass">
                    <div class="check check--old-pass">неверный пароль</div>
                    <input class="input input--old-pas input--password" type="password"
                           placeholder="введите старый пароль">
                    <input class="input input--new-pas input--password" type="password"
                           placeholder="введите новый пароль">
                    <div class="flex">
                        <div class="check"></div>
                        <input class="input input--repeat-new-pas input--password" type="password"
                               placeholder="повторите новый пароль">
                        <div data-type="password" class="button change-button change-button--password">изменить</div>
                    </div>
                </div>
            </div>
            <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
            <div class="setting-content-elem setting-content-elem--email">
                <div class="wrap wrap--email">
                    <div class="flex">
                        <p class="placeholder">email</p>
                        <div class="change-btn change-btn--input">изменить</div>
                    </div>
                    <div class="main-text main-text--email"><?= $_SESSION['email'] ?></div>
                </div>
                <div class="input-wrap input-wrap--email">
                    <div class="flex">
                        <div class="check check--email"></div>
                        <input class="input input--email" type="text" placeholder="введите новый email">
                        <div data-type='email' class="button change-button change-button--email">изменить</div>
                    </div>
                </div>
            </div>
            <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
            <div class="setting-content-elem setting-content-elem--skype">
                <div class="wrap">
                    <div class="flex">
                        <p class="placeholder">skype</p>
                        <div class="change-btn change-btn--input">изменить</div>
                    </div>
                    <div class="main-text main-text--skype"><?= $res['skype'] ?></div>
                </div>
                <div class="input-wrap">
                    <div class="flex">
                        <div class="check"></div>
                        <input class="input input--skype" type="text" placeholder="введите skype">
                        <div data-type='skype' class="button change-button">изменить</div>
                    </div>
                </div>
            </div>
            <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
            <div class="setting-content-elem setting-content-elem--avatar">
                <div class="flex">
                    <p class="placeholder">фото профиля</p>
                    <div class="perscab-photoedit-body">
                        <a href="#" class="add-photo download-avatar-btn">изменить</a>
                        <input style="display:none;" id="c_input24" name="file" multiple="false" type="file">
                        <input style="display:none;" name="photo_c" multiple="false" type="hidden" value="">
                        <input style="display:none;" name="photo_i" value="" multiple="false" type="hidden">
                    </div>
                </div>
                <div class="perscab-photoedit-img">
                    <img src="#" alt="">
                </div>
                <div style="display:none">
                    <div class="profile-modal-photo box-modal">
                        <div class="box-modal_close arcticmodal-close"></div>
                        <div>
                            <img class="profile_photo_i" src="">
                        </div>
                        <div class="modal-footer center-wrap">
                            <button class="button reg-btn reg-btn_empty reg-btn_empty-wht reg-btn_blk-hover js-main-image">
                                сохранить
                            </button>
                        </div>
                    </div>
                </div>
                <div class="avatar"></div>
            </div>
        </div>
    </div>
</section>

<header class="header">
    <div class="header__overhead">
        <div class="social-net-btns social-net-btns--header">
            <a class="social-net-btns__elem social-net-btns__elem--instagram"
               href="https://www.instagram.com/svetlana_totrova/" target="_blank"></a>
            <a class="social-net-btns__elem social-net-btns__elem--tiktok" href="../"></a>
        </div>
        <a class="header-logo" href="index.php">
            <!--img(src="images/icons/logo.svg", alt="logo")--></a>
        <div class="service-btns">
            <div class="btn-change-lang language <?= $_COOKIE['btnLang'] ? $_COOKIE['btnLang'] : 'eng-lang' ?>">
                <div class="lang-changer language <?= $_COOKIE['langChanger'] ? $_COOKIE['langChanger'] : 'rus-lang' ?>"></div>
            </div>

            <div class="btn-login <?= $status['logout'][0] ?>">Войти</div>

            <div class="user-login <?= $status['login'][1] ?>">
                <img class="user-login__elem user-login__elem--avatar" src="<?=$userInfo['avatar'] ? $userInfo['avatar'] : '../images/icons/user-ico.svg'?>" alt="">


                <p class="user-login__elem user-login__elem--user-name">
                    <?= $_SESSION['name'] ?>
                </p>
                <img class="user-login__elem"
                     src="images/icons/user-arrow.svg"
                     alt="">
                <div class="user-login-menu">
                    <a class="user-login-menu__elem user-login-menu__elem--messages" href="/">Сообщения</a>
                    <a class="user-login-menu__elem user-login-menu__elem--lessons" href="/student-lessons.php">Мои
                        уроки</a>
                    <div class="user-login-menu__elem user-login-menu__elem--settings">Настройки</div>
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
    <div class="header__lower">
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
