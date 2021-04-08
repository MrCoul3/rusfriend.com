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
                        src="images/index/top-index-main-photo.png">
                <img
                        class="owl-carousel__element owl-carousel__element--diplom" src="images/about/diplom.png">
                <img
                        class="owl-carousel__element owl-carousel__element--certificate"
                        src="images/about/certificate.png">
            </div>
            <div class="about__element about__element--right">
                <h1 switch-lang="<?=switchLang()?>" switchable-text="Привет!" class="title about-title">Hello!</h1>
                <div class="about-social-net">
                    <a class="about-social-net__elem about-social-net__elem--insta" href="../..">
                        <!--img(src="../images/icons/about-insta-icon.svg")--></a>
                    <a class="about-social-net__elem about-social-net__elem--tiktok" href="../..">
                        <!--img(src="../images/icons/about-tiktok.svg")--></a>
                </div>
                <div class="about-items">
                    <p switch-lang="<?=switchLang()?>" switchable-text="" class="about-items__item a">Я сертифицированный преподаватель русского языка как иностранного. Я
                        преподаю русский уже более 3-х лет и мои студенты по всему миру уже стали моими друзьями и я с
                        удовольствием стану твоим другом тоже. В моем блоге в Instagram И TikTok рассказываю больше о
                        России и нашей культуре.</p>
                    <p switch-lang="<?=switchLang()?>" switchable-text="" class="about-items__item b">После наших уроков мы заговорим на одном языке.</p>
                    <!--p.about-items__item.c Веду блог о русском языке, России и своей культуре в Instagram и Tik Tok-->
                    <!--p.about-items__item.d Основатель онлайн-школы Taiga и автор образовательных курсов по русскому языку-->
                </div>
                <h3 switch-lang="<?=switchLang()?>" switchable-text="" class="slogan about-slogan">Светлана</h3>
            </div>
        </div>
        <h2 switch-lang="<?=switchLang()?>" switchable-text="" class="detail-slogan">Буду очень рада видеть тебя <br> на моих online-занятиях</h2>
        <!--a(href="../").button.detail-btn.red-btn  подробнее-->
    </section>

    <?php require 'pages/requires/offers.php' ?>

</main>
<?php require 'pages/requires/footer.php' ?>
