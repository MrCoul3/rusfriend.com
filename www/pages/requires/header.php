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
    <link rel="stylesheet" href="../../styles/croppie/croppie.css"/>
    <link rel="stylesheet" href="../../styles/croppie/jquery.arcticmodal.css"/>
    <link rel="stylesheet" href="../../styles/croppie/themes/simple.css">
</head>

<body id="mysite">

<section class="login-form authorization-forms">
    <div class="form-frame">
        <div class="container">
            <h3 switch-lang="<?=switchLang()?>" switchable-text="Вход" class="form-title">Login</h3>
            <div class="logo-mobile-ver"></div>
            <div class="form-close-btn form-close-btn--login-form"></div>
            <!--img(src="../images/icons/close-btn.svg", alt="close").form-close-btn.form-close-btn--login-form-->
        </div>
        <!--img(src="../images/icons/form-decor-line.svg", alt="line").decor-line.decor-line--login-form-->
        <div class="decor-line decor-line--login-form"></div>
        <form class="form login-form">
            <input switch-lang="<?=switchLang()?>" switchable-text="почта" class="form__elem form-input form-input--email" type="email" placeholder="email" id="email">
            <div switch-lang="<?=switchLang()?>" switchable-text="формат: name@email.com" class="login-check login-check-email login-check--disable">format: name@email.com</div>
            <label class="label-email" for="email"></label>
            <input switch-lang="<?=switchLang()?>" switchable-text="пароль" class="form__elem form-input form-input--password" type="password" placeholder="password" id="password">
            <div switch-lang="<?=switchLang()?>" switchable-text="поле обязательно для заполнения" class="login-check login-check-password login-check--disable">this field is required</div>
            <label class="label-password" for="password"></label>
            <div class="login-invalid login-invalid--disable">
                <p switch-lang="<?=switchLang()?>" switchable-text="неверные почта или пароль">invalid email or password</p>
            </div>
            <p switch-lang="<?=switchLang()?>" switchable-text="У вас нет аккаунта? Регистрация" class="reg-log-changer form__elem">You don't have an account? Registration</p>
            <div class="decor-line decor-line--login-form"></div>
            <input switch-lang="<?=switchLang()?>" switchable-text="войти" class="form__elem form-submit form-submit-login button" submit="true" type="submit" value="login">
        </form>
    </div>
</section>
<section class="register-form authorization-forms">
    <div class="form-frame">
        <div class="container">
            <h3 switch-lang="<?=switchLang()?>" switchable-text="Регистрация" class="form-title">Registration</h3>
            <div class="logo-mobile-ver"></div>
            <div class="form-close-btn form-close-btn--register-form"></div>
            <!--img(src="../images/icons/close-btn.svg", alt="close").form-close-btn.form-close-btn--register-form-->
        </div>
        <div class="decor-line decor-line--login-form"></div>
        <form class="form" method="post">
            <input switch-lang="<?=switchLang()?>" switchable-text="имя пользователя" class="form__elem form-input form-input--username required-input" type="text" placeholder="user name" id="username" name="username">
            <div class="reg-check reg-check-name reg-check--disable">поле обязательно для заполнения</div>
            <label for="username"></label>
            <input switch-lang="<?=switchLang()?>" switchable-text="пароль" class="form__elem form-input form-input--password required-input" type="password"
                   placeholder="password" id="reg-password" name="password">
            <div class="reg-check reg-check-pass reg-check--disable">поле обязательно для заполнения</div>
            <label class="label-password" for="password"></label>
            <input switch-lang="<?=switchLang()?>" switchable-text="повторите пароль" class="form__elem form-input form-input--re-password required-input" type="password"
                   placeholder="repeat the password" id="re-password">
            <label class="label-re-password" for="re-reg-password"></label>
            <div switch-lang="<?=switchLang()?>" switchable-text="пароли не совпадают" class="reg-check check-re-password reg-check--disable">passwords don't match</div>
            <input switch-lang="<?=switchLang()?>" switchable-text="почта" class="form__elem form-input form-input--email required-input" type="email" placeholder="email"
                   id="reg-email" name="email">
            <div switch-lang="<?=switchLang()?>" switchable-text="поле обязательно для заполнения" class="reg-check reg-check-email reg-check--disable">this field is required</div>
            <label class="label-email" for="email"></label>
            <input switch-lang="<?=switchLang()?>" switchable-text="скайп" class="form__elem form-input form-input--skype" type="text" placeholder="skype" id="skype"
                   name="skype">
            <label for="skype"></label>
            <p switch-lang="<?=switchLang()?>" switchable-text="Уже зарегестрированы? Войти" class="reg-log-changer form__elem">Already registered? Login</p>
            <div class="decor-line decor-line--login-form"></div>
            <input switch-lang="<?=switchLang()?>" switchable-text="зарегестрироваться" class="form__elem form-submit form-submit-register button" submit="true" type="submit" value="register now">
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
            <h3 switch-lang="<?=switchLang()?>" switchable-text="Настройки" class="settings-title">Settings</h3>
            <div class="close-btn close-btn--settings"></div>
        </div>
        <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
        <div class="settings-main-frame__elem settings-main-frame__elem--content">
            <div class="setting-content-elem setting-content-elem--name">
                <div class="wrap">
                    <div class="flex">
                        <p switch-lang="<?=switchLang()?>" switchable-text="имя пользователя" class="placeholder">user name</p>
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" class="change-btn change-btn--input">change</div>
                    </div>
                    <div class="main-text main-text--user-name"><?= $_SESSION['name'] ?></div>
                </div>
                <div class="input-wrap">
                    <div class="flex">
                        <div class="check"></div>
                        <input switch-lang="<?=switchLang()?>" switchable-text="введите новое имя" class="input input--name" type="text" placeholder="enter a new name">
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" data-type='name' class="button change-button">change</div>
                    </div>
                </div>
            </div>
            <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
            <div class="setting-content-elem setting-content-elem--password">
                <div class="wrap wrap--pass">
                    <div class="flex">
                        <p switch-lang="<?=switchLang()?>" switchable-text="пароль" class="placeholder">password</p>
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" class="change-btn change-btn--input">change</div>
                    </div>
                    <div class="main-text main-text--password">**********</div>
                </div>
                <div class="input-wrap input-wrap--pass">
                    <div switch-lang="<?=switchLang()?>" switchable-text="неверный пароль" class="check check--old-pass">invalid password</div>
                    <input switch-lang="<?=switchLang()?>" switchable-text="введите старый пароль" class="input input--old-pas input--password" type="password" placeholder="enter your old password">
                    <input switch-lang="<?=switchLang()?>" switchable-text="введите новый пароль" class="input input--new-pas input--password" type="password" placeholder="enter your new password">
                    <div class="flex">
                        <div class="check"></div>
                        <input switch-lang="<?=switchLang()?>" switchable-text="повторите новый пароль" class="input input--repeat-new-pas input--password" type="password" placeholder="repeat the new password">
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" data-type="password" class="button change-button change-button--password">change</div>
                    </div>
                </div>
            </div>
            <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
            <div class="setting-content-elem setting-content-elem--email">
                <div class="wrap wrap--email">
                    <div class="flex">
                        <p switch-lang="<?=switchLang()?>" switchable-text="почта" class="placeholder">email</p>
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" class="change-btn change-btn--input">change</div>
                    </div>
                    <div class="main-text main-text--email"><?= $_SESSION['email'] ?></div>
                </div>
                <div class="input-wrap input-wrap--email">
                    <div class="flex">
                        <div class="check check--email"></div>
                        <input switch-lang="<?=switchLang()?>" switchable-text="введите новую почту" class="input input--email" type="text" placeholder="enter your new email address">
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" data-type='email' class="button change-button change-button--email">change</div>
                    </div>
                </div>
            </div>
            <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
            <div class="setting-content-elem setting-content-elem--skype">
                <div class="wrap">
                    <div class="flex">
                        <p switch-lang="<?=switchLang()?>" switchable-text="скайп" class="placeholder">skype</p>
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" class="change-btn change-btn--input">change</div>
                    </div>
                    <div class="main-text main-text--skype"><?= $res['skype'] ?></div>
                </div>
                <div class="input-wrap">
                    <div class="flex">
                        <div class="check"></div>
                        <input switch-lang="<?=switchLang()?>" switchable-text="введите скайп" class="input input--skype" type="text" placeholder="enter skype">
                        <div switch-lang="<?=switchLang()?>" switchable-text="изменить" data-type='skype' class="button change-button">change</div>
                    </div>
                </div>
            </div>
            <div class="settings-main-frame__elem settings-main-frame__elem--decor-line decor-line"></div>
            <div class="setting-content-elem setting-content-elem--avatar">
                <div class="flex">
                    <p switch-lang="<?=switchLang()?>" switchable-text="фото профиля" class="placeholder">profile photo</p>
                    <div class="perscab-photoedit-body">
                        <a switch-lang="<?=switchLang()?>" switchable-text="изменить" href="#" class="add-photo download-avatar-btn">change</a>
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
                            <button switch-lang="<?=switchLang()?>" switchable-text="сохранить" class="button reg-btn reg-btn_empty reg-btn_empty-wht reg-btn_blk-hover js-main-image">
                                save
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

            <div switch-lang="<?=switchLang()?>" switchable-text="Войти" class="btn-login <?= $status['logout'][0] ?>">Login</div>

            <div class="user-login <?= $status['login'][1] ?>">
                <img class="user-login__elem user-login__elem--avatar" src="<?=$userInfo['avatar'] ? $userInfo['avatar'] : '../images/icons/user-ico.svg'?>" alt="">


                <p class="user-login__elem user-login__elem--user-name">
                    <?= $_SESSION['name'] ?>
                </p>
                <img class="user-login__elem"
                     src="images/icons/user-arrow.svg"
                     alt="">
                <div class="user-login-menu">
                    <a switch-lang="<?=switchLang()?>" switchable-text="Сообщения" class="user-login-menu__elem user-login-menu__elem--messages" href="/">Messages</a>
                    <a switch-lang="<?=switchLang()?>" switchable-text="Мои уроки" class="user-login-menu__elem user-login-menu__elem--lessons" href="/student-lessons.php">My lessons</a>
                    <div switch-lang="<?=switchLang()?>" switchable-text="Настройки" class="user-login-menu__elem user-login-menu__elem--settings">Settings</div>
                    <div class="decor-line decor-line--user-login-menu"></div>
                    <a switch-lang="<?=switchLang()?>" switchable-text="Выход" class="user-login-menu__elem user-login-menu__elem--logout" href="../index.php">Logout</a>
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
            <a switch-lang="<?=switchLang()?>" switchable-text="Об авторе" class="header-menu--about" href="about.php">About me</a>
            <a switch-lang="<?=switchLang()?>" switchable-text="Курсы" class="header-menu--courses" href="courses.php">Courses</a>
            <a switch-lang="<?=switchLang()?>" switchable-text="Занятие с преподавателем" class="header-menu--private" href="private-lesson.php">Individual lesson</a>
            <a switch-lang="<?=switchLang()?>" switchable-text="Разговорный клуб" class="header-menu--s-club" href="speaking-club.php">Speaking-club</a>
            <a switch-lang="<?=switchLang()?>" switchable-text="Гайд" class="header-menu--guide" href="guide.php">Guide</a>
        </nav>
        <div class="decor-line decor-line--header decor-line-mobile-hide"></div>
    </div>
</header>
