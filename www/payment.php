<?php session_start();

require("vendor/autoload.php");
$objCalendar = new \Classes\Calendar();
$result = $objCalendar->getLessons();

foreach ($result as $k=>$val) {
    $userName = $val[1];
    $conf = $val[6];
    if ($userName === $_SESSION['name'] && $conf === '0') {
        $price += $val[7];
        $time = $val[3];
    }
}
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
    <title switch-lang="<?=switchLang()?>" switchable-text="Страница оплаты">Payment</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8">
    <link href="styles/app.css" rel="stylesheet">

<body class="payment-page" id="mysite">
<header class="header">
    <div class="header-inner">
        <a href="/index.php" class="logo"></a>
        <div class="instruction">
            <p switch-lang="<?=switchLang()?>" switchable-text="1. Выберите удобное для вас время" class="instruction__item">1. Choose a convenient time for you</p>
            <p class="instruction__item separator">></p>
            <p switch-lang="<?=switchLang()?>" switchable-text="2. Оплатите урок" class="instruction__item instruction__item--two instuction-active">2. Pay for the lesson</p>
            <p class="instruction__item separator">></p>
            <p switch-lang="<?=switchLang()?>" switchable-text="3. Готовьтесь к уроку" class="instruction__item instruction__item--three">3. Prepare for the lesson</p>
        </div>
    </div>
</header>

<main class="payment">

    <section class="payment-gateway">
        <div class="payment-gateway__elem payment-gateway__elem--event">
            <div class="payment-gateway-head">
                <p switch-lang="<?=switchLang()?>" switchable-text="Произведите оплату, что бы забронировать урок" class="payment-gateway-head__title">Make a payment to book a lesson</p>
            </div>
            <div class="decor-line"></div>
            <div class="payment-gateway-main">
                <p switch-lang="<?=switchLang()?>" switchable-text="Для оплаты занятия необходимо перевести на счет PayPal" class="payment-gateway-main__descr">To pay for the lesson, you need to transfer it to a PayPal
                    account</p>
                <p class="payment-gateway-main__price">$<?=$price?>.00</p>
                <div  class="payment-gateway-main__container flex">
                    <a switch-lang="<?=switchLang()?>" switchable-text="Ссылка для быстрой оплаты" class="payment-gateway-main__quick-link" href="https://www.paypal.com/paypalme/svetlanatotr?locale.x=ru_RU" target="_blank">Link for quick payment</a>
                    <div class="payment-gateway-main__faq"></div>
                </div>
                <p switch-lang="<?=switchLang()?>" switchable-text="Адрес получателя " class="payment-gateway-main__adress-descr">Address of the payee</p>
                <p class="payment-gateway-main__adress-email">svetlanatotr@gmail.com</p>
                <div switch-lang="<?=switchLang()?>" switchable-text="подтвердить оплату" class="button payment-gateway-main__confirm-btn">confirm payment</div>
            </div>
        </div>
        <div class="info-container">
            <?php foreach ($result as $k=>$val):?>
                <?php $date = $val[2]; $time = $val[3]; $userName = $val[1]; $conf = $val[6]; $gmt = $val[8]; if ($userName === $_SESSION['name'] && $conf === '0'):?>
                    <div name="<?=$userName?>" time="<?=$time?>" date="<?=$date?>" gmt="<?=$gmt?>" class="payment-gateway__elem payment-gateway__elem--info">
                        <p switch-lang="<?=switchLang()?>" switchable-text="Дата и время" class="info-descr info-descr--date">Date and time</p>
                        <p class="info-date"><?=$val[2] . ', ' . $val[3]?></p>
                        <p class="info-descr info-descr--gmt"><?=$val[8]?></p>
                        <div class="decor-line"></div>
                        <p switch-lang="<?=switchLang()?>" switchable-text="Подробности заказа" class="info-descr info-descr--details">Order Details</p>
                        <div class="flex">
                            <p switch-lang="<?=switchLang()?>" switchable-text="Время занятия">Class time</p>
                            <p switch-lang="<?=switchLang()?>" switchable-text="1 час">1 hour</p>
                        </div>
                        <div class="flex">
                            <p switch-lang="<?=switchLang()?>" switchable-text="Цена">Price</p>
                            <p>$<?=$val[7]?>.00</p>
                        </div>
                        <div class="flex">
                            <p switch-lang="<?=switchLang()?>" switchable-text="Возможность отмены">Possibility of cancellation</p>
                            <p switch-lang="<?=switchLang()?>" switchable-text="за 24 часа">in 24 hours</p>
                        </div>
                        <div class="decor-line"></div>
                        <div class="flex flex-total">
                            <p switch-lang="<?=switchLang()?>" switchable-text="Итого" class="total">Total</p>
                            <p class="total">$<?=$val[7]?>.00</p>
                        </div>
                    </div>
                <?php endif;?>
            <?php endforeach;?>
        </div>
    </section>

    <section class="faq">
        <div class="faq-frame">
            <div class="close-btn"></div>
            <h2  class="faq-frame-title">How to make a payment</h2>
            <div class="screen screen--one"></div>
            <p  class="faq-frame-item"><span>1</span>. Click on the button “Send”</p>
            <div class="screen screen--two"></div>
            <p class="faq-frame-item"><span>2</span>. Enter the required amount</p>
            <p class="faq-frame-item"><span>3</span>. Necessarily enter your name as indicated on the website</p>
            <p class="faq-frame-item"><span>4</span>. Click on the button “Continue”</p>
            <p class="faq-frame-item"><span>5</span>. Go back to the previous page</p>
            <div class="screen screen--three"></div>
            <p class="faq-frame-item"><span>6</span>. And confirm the payment</p>
        </div>
    </section>

    <section class="success-frame">
        <div class="success-frame-content">
            <h2 switch-lang="<?=switchLang()?>" switchable-text="Вы успешно оплатили урок" class="success-title">You have successfully paid for the lesson</h2>
            <p switch-lang="<?=switchLang()?>" switchable-text="В ближайшее время преподавателсь подтвердит оплату">In the near future, the teacher will confirm the payment</p>
            <p switch-lang="<?=switchLang()?>" switchable-text="После подтверждения оплаты вам на почту будет выслано <br> письмо с информацией о бронировании">After confirming the payment, you will receive an <br> email with the booking information.</p>
            <div class="flex success-flex"><a href="/private-lesson.php">
                    <div class="arrow"></div>
                </a><a switch-lang="<?=switchLang()?>" switchable-text="Вернуться в календарь занятий" class="return-link" href="/private-lesson.php">Go back to the class calendar</a></div>
        </div>
    </section>

</main>

<footer class="footer">
    <div class="decor-line decor-line--footer"></div>
    <div class="footer-content"><a class="footer-content__element footer-content__element--logo" href="/index.php">
            <!--img(src="../images/icons/logo.svg", alt="logo").footer-content__element.footer-content__element--logo--></a>
        <div class="footer-content__element footer-content__element--text">
            <h2 switch-lang="<?=switchLang()?>" switchable-text="Если возникли вопросы:" class="footer-questions">If you have any questions:</h2>
            <!--a(href="../")-->
            <h2  class="footer-email">svetlana.totr@gmail.com</h2>
            <!--a(href="../")-->
            <!--    h2.footer-skype @svetlana.totr-->
        </div>
        <div class="footer-content__element social-net-btns"><a
                    class="social-net-btns__elem social-net-btns__elem--instagram"
                    href="https://www.instagram.com/svetlana_totrova/" target="_blank">
                <!--img(src="../images/icons/insta-icon.svg")--></a><a
                    class="social-net-btns__elem social-net-btns__elem--tiktok" href="/">
                <!--img(src="../images/icons/tiktok.svg")--></a></div>
    </div>
</footer>
</html>
<script type="text/javascript" src="scripts/app.js"></script>
