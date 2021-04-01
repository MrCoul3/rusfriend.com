<?php
require 'pages/requires/header.php';
require("vendor/autoload.php");
?>
<title>Об авторе</title>
<main class="about-page">
    <section class="about">
        <div class="inner">
            <div class="owl-carousel owl-carousel-3 owl-theme about__element about__element--left"><img
                        class="owl-carousel__element owl-carousel__element--photo"
                        src="images/index/top-index-main-photo.png"><img
                        class="owl-carousel__element owl-carousel__element--diplom" src="images/about/diplom.png"><img
                        class="owl-carousel__element owl-carousel__element--certificate"
                        src="images/about/certificate.png"></div>
            <div class="about__element about__element--right">
                <h1 class="title about-title">Привет!</h1>
                <div class="about-social-net">
                    <a class="about-social-net__elem about-social-net__elem--insta" href="../..">
                        <!--img(src="../images/icons/about-insta-icon.svg")--></a>
                    <a class="about-social-net__elem about-social-net__elem--tiktok" href="../..">
                        <!--img(src="../images/icons/about-tiktok.svg")--></a>
                </div>
                <div class="about-items">
                    <p class="about-items__item a">Я сертифицированный преподаватель русского языка как иностранного. Я
                        преподаю русский уже более 3-х лет и мои студенты по всему миру уже стали моими друзьями и я с
                        удовольствием стану твоим другом тоже. В моем блоге в Instagram И TikTok рассказываю больше о
                        России и нашей культуре.</p>
                    <p class="about-items__item b">После наших уроков мы заговорим на одном языке.</p>
                    <!--p.about-items__item.c Веду блог о русском языке, России и своей культуре в Instagram и Tik Tok-->
                    <!--p.about-items__item.d Основатель онлайн-школы Taiga и автор образовательных курсов по русскому языку-->
                </div>
                <h3 class="slogan about-slogan">Светлана</h3>
            </div>
        </div>
        <h2 class="detail-slogan">Буду очень рада видеть тебя <br> на моих online-занятиях</h2>
        <!--a(href="../").button.detail-btn.red-btn  подробнее-->
    </section>
    <section class="offers section inner">
        <h1 class="title offers-title">НАШИ ПРЕДЛОЖЕНИЯ</h1>
        <h3 class="slogan offers-slogan">После наших уроков мы заговорим на одном языке</h3>
        <div class="offers-cards">
            <div class="offers-cards-conteiner offers-cards-conteiner--courses">
                <div class="offers-cards__card offers-cards__card--courses">
                    <div class="card-content card-content--front card-side-active">
                        <div class="card-icon"></div>
                        <!--img(src="../images/index/card-logo-bear.svg").card-icon-->
                        <div class="wrap">
                            <h3 class="card-title">Курсы</h3>
                            <p class="card-description card-description--front card-side-active">Подписка на видеокурс, который подходит именно тебе</p>
                        </div>
                        <div class="begin-btn detail-btn">подробнее</div>
                    </div>
                    <div class="card-content card-content--end">
                        <p class="card-description card-description--back">Здесь ты можешь выбрать грамматический курс , который подходит именно тебе, в каждом курсе ты получишь видеоуроки с домашними заданиями, полезными материалами и обратной связью.</p>
                        <p class="card-content-price">от 25$</p><a class="begin-btn" href="/courses.php">начать</a>
                    </div>
                </div>
            </div>
            <div class="offers-cards-conteiner offers-cards-conteiner--private">
                <div class="offers-cards__card offers-cards__card--private">
                    <div class="card-content card-content--front card-side-active">
                        <div class="card-icon"></div>
                        <!--img(src="../images/index/card-logo-balalayka.svg").card-icon-->
                        <div class="wrap">
                            <h3 class="card-title">Занятия с <br> преподавателем</h3>
                            <p class="card-description card-description--front">Индивидуальные занятия по видеосвязи для любого уровня</p>
                        </div>
                        <div class="begin-btn detail-btn">подробнее</div>
                    </div>
                    <div class="card-content card-content--end">
                        <p class="card-description card-description--back">Забронируй 60-минутный урок с преподавателем в удобное для тебя время. Вместе мы определим индивидуальный план развития. <br> <br> Урок включает грамматику и работу с упражнениями.</p>
                        <p class="card-content-price">от 25$</p><a class="begin-btn" href="/private-lesson.php">начать</a>
                    </div>
                </div>
            </div>
            <div class="offers-cards-conteiner offers-cards-conteiner--s-club">
                <div class="offers-cards__card offers-cards__card--s-club">
                    <div class="card-content card-content--front card-side-active">
                        <div class="card-icon"></div>
                        <!--img(src="../images/index/card-logo-samovar.svg").card-icon-->
                        <div class="wrap">
                            <h3 class="card-title">Speaking-Сlub</h3>
                            <p class="card-description card-description--front">Для тех, кто немного говорит по-русски и хочет улучшить разговорные навыки</p>
                        </div>
                        <div class="begin-btn detail-btn">подробнее</div>
                    </div>
                    <div class="card-content card-content--end">
                        <p class="card-description card-description--back">Если ты уже немного говоришь по-русски и хочешь увеличить словарный запас, а так же приятно провести время за разговором - Speaking-Club как раз для тебя.</p>
                        <p class="card-description card-description--back card-description--addition">Не включает грамматику и подходит для любого уровня.</p>
                        <p class="card-content-price">от 25$</p><a class="begin-btn" href="/speaking-club.php">начать</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php require 'pages/requires/footer.php' ?>
