<?php
require("vendor/autoload.php");
require('service.html');
$objCalendar = new \Classes\Calendar();
sleep(1);
$result = $objCalendar->getLessons();
//echo "<pre>";
//print_r($result);
//echo "</pre>";
foreach ($result as $k=>$val) {
  $price += $val[7];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Страница оплаты</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8">
<body class="payment-page" id="mysite">
<header class="header">
    <div class="header-inner">
        <a href="/index.php" class="logo"></a>
        <div class="instruction">
            <p class="instruction__item">1. Choose a convenient time for you</p>
            <p class="instruction__item separator">></p>
            <p class="instruction__item instruction__item--two instuction-active">2. Pay for the lesson</p>
            <p class="instruction__item separator">></p>
            <p class="instruction__item instruction__item--three">3. Prepare for the lesson</p>
        </div>
    </div>
</header>


<main class="payment">

    <section class="payment-gateway">
        <div class="payment-gateway__elem payment-gateway__elem--event">
            <div class="payment-gateway-head">
                <p class="payment-gateway-head__title">Make a payment to book a lesson</p>
            </div>
            <div class="decor-line"></div>
            <div class="payment-gateway-main">
                <p class="payment-gateway-main__descr">To pay for the lesson, you need to transfer it to a PayPal
                    account</p>
                <p class="payment-gateway-main__price">$<?=$price?>.00</p>
                <div class="payment-gateway-main__container flex"><a class="payment-gateway-main__quick-link"
                                                                     href="https://www.paypal.com/paypalme/svetlanatotr?locale.x=ru_RU"
                                                                     target="_blank">Link for quick payment</a>
                    <div class="payment-gateway-main__faq"></div>
                </div>
                <p class="payment-gateway-main__adress-descr">Address of the payee</p>
                <p class="payment-gateway-main__adress-email">svetlanatotr@gmail.com</p>
                <div class="button payment-gateway-main__confirm-btn">confirm payment</div>
            </div>
        </div>
        <div class="info-container">
            <?php foreach ($result as $k=>$val):?>
            <div class="payment-gateway__elem payment-gateway__elem--info">
                <p class="info-descr info-descr--date">Дата и время</p>
                <p class="info-date"><?=$val[2] . ', ' . $val[3]?></p>
                <p class="info-descr info-descr--gmt"><?=$val[8]?></p>
                <div class="decor-line"></div>
                <p class="info-descr info-descr--details">Подробности заказа</p>
                <div class="flex">
                    <p>Время занятия</p>
                    <p>1 час</p>
                </div>
                <div class="flex">
                    <p>Цена</p>
                    <p>$<?=$val[7]?>.00</p>
                </div>
                <div class="flex">
                    <p>Возможность отмены</p>
                    <p>за 24 часа</p>
                </div>
                <div class="decor-line"></div>
                <div class="flex flex-total">
                    <p class="total">Итого</p>
                    <p class="total">$<?=$val[7]?>.00</p>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </section>

    <section class="faq">
        <div class="faq-frame">
            <div class="close-btn"></div>
            <h2 class="faq-frame-title">How to make a payment</h2>
            <div class="screen screen--one"></div>
            <p class="faq-frame-item"><span>1</span>. Click on the button “Send”</p>
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
            <h2 class="success-title">Вы успешно оплатили урок</h2>
            <p>В ближайшее время преподавателсь подтвердит оплату</p>
            <p>После подтверждения оплаты вам на почту будет выслано <br> письмо с информацией о бронировании</p>
            <div class="flex success-flex"><a href="/private-lesson.php">
                    <div class="arrow"></div>
                </a><a class="return-link" href="/private-lesson.php">Вернуться в календарь занятий</a></div>
        </div>
    </section>

</main>

<footer class="footer">
    <div class="decor-line decor-line--footer"></div>
    <div class="footer-content"><a class="footer-content__element footer-content__element--logo" href="/index.php">
            <!--img(src="../images/icons/logo.svg", alt="logo").footer-content__element.footer-content__element--logo--></a>
        <div class="footer-content__element footer-content__element--text">
            <h2 class="footer-questions">Если возникли вопросы:</h2>
            <!--a(href="../")-->
            <h2 class="footer-email">svetlana.totr@gmail.com</h2>
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