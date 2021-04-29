<title>Главная</title>
<main class="main-page">

    <section class="cookie-warn">
        <div class="cookie-warn-frame">
            <p>Этот сайт использует cookie для хранения
                данных. Продолжая использовать сайт,
                вы даете  согласие на работу с этими файлами</p>
            <div class="close">принять и закрыть</div>
        </div>
    </section>

    <section class="about-school-video">
        <div class="video-container">
            <div switch-lang="<?=switchLang()?>" switchable-text="Подробнее про нашу школу" class="close-line">Learn more about our school
                <div class="close-button"></div>
            </div>
            <iframe id="about-video" class="detailed-about-school" width="1200px" height="315" src="https://www.youtube.com/embed/mUPs1h9TZSg?enablejsapi=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </section>
    <section class="top-index">
        <div class="inner">

            <div class="top-index__element top-index__element--left">
                <h1 switch-lang="<?=switchLang()?>" switchable-text="Онлайн - школа <span>русского</span> языка как иностранного" class="top-index-title">Online school of <span>Russian</span> as a foreign language</h1>
                <h2 switch-lang="<?=switchLang()?>" switchable-text="Русский язык от носителя <br> с любовью из России" class="top-index-second-title">Russian with a native speaker <br> from Russia with love</h2>
                <h2 switch-lang="<?=switchLang()?>" switchable-text="Начни изучать алфавит <br> прямо сейчас" class="top-index-first-title">Start learning the alphabet <br> right now</h2>
                <a switch-lang="<?=switchLang()?>" switchable-text="получить гайд <br> бесплатно" class="button get-guide-btn red-btn" href="/guide.php"><span>guide for free</span></a>
            </div>
            <div class="top-index__element top-index__element--right">
                <div class="top-index-photo">
                    <div class="top-index-photo__elem top-index-photo__elem--name"></div>
                    <div class="top-index-photo__elem top-index-photo__elem--description"></div>
                    <!--img(src="../images/index/photoname.svg").top-index-photo__elem.top-index-photo__elem--name-->
                    <!--img(src="../images/index/photodescription.svg").top-index-photo__elem.top-index-photo__elem--description-->
                </div>
            </div>
            <div class="about-school-btn">
                <p switch-lang="<?=switchLang()?>" switchable-text="Подробнее про нашу школу">Learn more about our school</p>
                <div class="about-school-btn--play-btn"></div>
                <!--img(src="../images/icons/play.png" alt="play").about-school-btn--play-btn-->
            </div>
        </div>
    </section>


    <section class="for-whom section">
        <h1 switch-lang="<?=switchLang()?>" switchable-text="ДЛЯ КОГО НАША ШКОЛА?" class="title for-whom-title">WHO IS OUR SCHOOL FOR?</h1>
        <div class="owl-carousel owl-theme owl-carousel-1">
            <div class="carousel-img carousel-img--one">
                <div switch-lang="<?=switchLang()?>" switchable-text="Для тех, кто хочет найти вторую <br> половинку" class="carousel-img-description">For those who want to find a <br> soul mate</div>
            </div>
            <div class="carousel-img carousel-img--two">
                <div switch-lang="<?=switchLang()?>" switchable-text="Для тех, кто любит русскую культуру" class="carousel-img-description">For those who love Russian culture</div>
            </div>
            <div class="carousel-img carousel-img--three">
                <div switch-lang="<?=switchLang()?>" switchable-text="Для тех, чья вторая половинка <br>говорит по русски" class="carousel-img-description">For those whose partner <br> speaks Russian </div>
            </div>
            <div class="carousel-img carousel-img--four">
                <div switch-lang="<?=switchLang()?>" switchable-text="Для тех, кто хочет приехать в Россию" class="carousel-img-description">For those who want to come to Russia</div>
            </div>
            <div class="carousel-img carousel-img--five">
                <div switch-lang="<?=switchLang()?>" switchable-text="Для тех, кому нужен русский для работы" class="carousel-img-description">For those who need Russian for work</div>
            </div>
        </div>
        <div class="flex">
            <div switch-lang="<?=switchLang()?>" switchable-text="пользователь уже использовал бесплатный урок" class="check">the user has already used the free lesson</div>
            <div switch-lang="<?=switchLang()?>" switchable-text="получить <br> бесплатное занятие" class="get-free-lesson-btn button red-btn">get a free <br>  lesson</div>
        </div>
    </section>

    <?php require 'pages/requires/offers.php' ?>  <!-- section offers -->

    <section class="about">
        <div class="inner">
            <div class="about__element about__element--left">
                <!--img(src="../images/index/top-index-main-photo.png")-->
            </div>
            <div class="about__element about__element--right">
                <h1 switch-lang="<?=switchLang()?>" switchable-text="ОБО МНЕ" class="title about-title">ABOUT ME</h1>
                <div class="about-social-net">
                    <a class="about-social-net__elem about-social-net__elem--insta" href="https://www.instagram.com/svetlana_totrova/" target="_blank">
<!--                        <img src="../images/icons/about-insta-icon.png">-->
                    </a>
                    <a class="about-social-net__elem about-social-net__elem--tiktok" href="../">
                        <!--img(src="../images/icons/about-tiktok.svg")--></a>
                </div>
                <h3 switch-lang="<?=switchLang()?>" switchable-text="Носитель русского языка из России" class="slogan about-slogan">Native Russian speaker from Russia</h3>
                <div class="about-items">
                    <p switch-lang="<?=switchLang()?>" switchable-text="Сертифицированный преподаватель <br> русского языка как иностранного" class="about-items__item a">Certified teacher of Russian as a foreign language</p>
                    <p switch-lang="<?=switchLang()?>" switchable-text="Более 3-х лет обучаю иностранцев со всего мира" class="about-items__item b">I have been teaching foreigners from all over the world for more than 3 years</p>
                    <p switch-lang="<?=switchLang()?>" switchable-text="Веду блог о русском языке, России и своей культуре в Instagram и Tik-Tok" class="about-items__item c">I have blogs on Instagram and Tik-Tok about the Russian language, Russia, and my culture</p>
                    <p switch-lang="<?=switchLang()?>" switchable-text="Основатель онлайн-школы и автор образовательных курсов по русскому языку" class="about-items__item d">Author of educational courses in the Russian language</p>
                </div>
<!--                <h3 switch-lang="--><?//=switchLang()?><!--" switchable-text="Светлана" class="slogan about-slogan about-slogan--name">Svetlana</h3>-->
            </div>
        </div>
        <h2 switch-lang="<?=switchLang()?>" switchable-text="Буду очень рада видеть тебя <br> на моих online-занятиях" class="detail-slogan">I'll be very happy to see you in my online classes</h2>
        <a switch-lang="<?=switchLang()?>" switchable-text="подробнее" class="button detail-btn red-btn" href="/about.php">read more</a>
    </section>

    <section class="reviews">
        <h1 switch-lang="<?=switchLang()?>" switchable-text="ЧТО ГОВОРЯТ СТУДЕНТЫ" class="title reviews-title">WHAT STUDENTS ARE SAYING</h1>
        <div class="inner">
            <div class="reviews-container">
                <div class="reviews-col reviews-col--left">
                    <!--div.review.review--a-->
                    <!--div.review.review--b-->
                    <!--div.review.review--c-->
                    <img src="../images/index/reviews-left_1.png">
                    <img src="../images/index/reviews-left_2.png"><img src="../images/index/reviews-left_3.png">
                </div>
                <div class="reviews-col reviews-col--right">
                    <!--div.review.review--d-->
                    <!--div.review.review--e-->
                    <!--div.review.review--f-->
                    <img src="../images/index/reviews-right_1.png">
                    <img src="../images/index/reviews-right_2.png"><img src="../images/index/reviews-right_3.png">
                </div>
            </div>
            <div class="owl-carousel owl-carousel-2 owl-theme">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(1).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(2).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(3).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(4).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(5).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(6).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(7).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(8).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(9).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(10).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(11).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(12).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(13).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(14).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(15).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(16).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(17).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(18).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(19).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(20).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(21).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(22).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(23).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(24).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(25).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(26).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(27).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(28).jpg">
                <img class="carousel-item" src="../images/index/rewiews/reviews-carousel(29).jpg">
            </div>
        </div>
    </section>

</main>