<?php
require 'pages/requires/header.php';
require("vendor/autoload.php");
?>

<title>Об авторе</title>
<main class="about-page">
    <section class="about">
        <div class="inner">
            <div class="owl-carousel owl-carousel-3 owl-theme about__element about__element--left">
                <img
                        class="owl-carousel__element owl-carousel__element--photo"
                        about-social-net__elem about-social-net__elem--insta   src="images/index/top-index-main-photo.png">
                <img
                        class="owl-carousel__element owl-carousel__element--diplom" src="images/about/diplom.png">
                <img
                        class="owl-carousel__element owl-carousel__element--certificate"
                        src="images/about/certificate.png">
            </div>
            <div class="about__element about__element--right">
                <h1 switch-lang="<?= switchLang() ?>" switchable-text="Привет!" class="title about-title">Hello!</h1>
                <div class="about-social-net">
                    <a class="about-social-net__elem about-social-net__elem--insta" href="https://www.instagram.com/svetlana_totrova/" target="_blank">
                        <!--img(src="../images/icons/about-insta-icon.svg")--></a>
                    <a class="about-social-net__elem about-social-net__elem--tiktok" href="../..">
                        <!--img(src="../images/icons/about-tiktok.svg")--></a>
                </div>
                <div class="about-items">
                    <p switch-lang="<?= switchLang() ?>" switchable-text="Привет всем и добро пожаловать в Россию! <br><br> Меня зовут Светлана, я сертифицированный преподаватель русского языка как иностранного. Я хотела бы поделиться своими знаниями и стать вашим учителем и другом. Я преподаю русский язык уже более 3 лет и стараюсь сделать курсы и уроки как можно более интересными и простыми. <br><br>
                    Я хочу, чтобы вы больше узнали не только о русском языке, но и о России, о нашей культуре и поняли, что не все стереотипы о нас это правда. Больше информации вы можете найти в моем блоге в Instagram и Tik-Tok."
                       class="about-items__item a"> Hello everyone and welcome to Russia! <br><br>
                        My name is Svetlana, I'm a certified teacher of Russian as a foreign language. I would like to share my knowledge and become your teacher and friend. I've been teaching Russian for more then 3 years and trying to make courses and lessons as interesting and simple as possible.<br><br>
                        I want you to learn more about not only the Russian language, but also about Russia, our culture and understand that not all the stereotypes about us are true. You can find out more on my blog on Instagram and Tik-Tok.</p>
                    <p switch-lang="<?= switchLang() ?>"
                       switchable-text="После наших уроков мы заговорим на одном языке." class="about-items__item b">
                        After our lessons we will speak the same language.</p>
                    <!--p.about-items__item.c Веду блог о русском языке, России и своей культуре в Instagram и Tik Tok-->
                    <!--p.about-items__item.d Основатель онлайн-школы Taiga и автор образовательных курсов по русскому языку-->
                </div>
                <h3 switch-lang="<?= switchLang() ?>" switchable-text="Светлана" class="slogan about-slogan">
                    Svetlana</h3>
            </div>
        </div>
        <h2 switch-lang="<?= switchLang() ?>"
            switchable-text="Буду очень рада видеть тебя <br> на моих online-занятиях " class="detail-slogan">I'll be
            very happy to see you <br> in my online classes</h2>
        <!--a(href="../").button.detail-btn.red-btn  подробнее-->
    </section>

    <?php require 'pages/requires/offers.php' ?>

</main>
<?php require 'pages/requires/footer.php' ?>
