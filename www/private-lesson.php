<?php
require("vendor/autoload.php");
?>
<?php require 'pages/requires/header.php'?>
<title switch-lang="<?=switchLang()?>" switchable-text="Занятие с преподавателем">Individual lesson</title>
<main class="book-lesson private-lesson">
    <div class="description-block">
        <h2 switch-lang="<?=switchLang()?>" switchable-text="Занятие с преподавателем" class="title">Individual lesson</h2>
        <p switch-lang="<?=switchLang()?>" switchable-text="Забронируй 60-минутный урок с преподавателем в удобное для тебя время. Вместе мы определим индивидуальный план развития." class="description">Book a 60-minute lesson with a teacher at your convenience. Together, we will define an individual development plan.</p>
        <p switch-lang="<?=switchLang()?>" switchable-text="Урок включает грамматику и работу с упражнениями." class="description">The lesson includes grammar and working with exercises.</p>
        <div class="decor-line"></div>
        <div class="params">
            <div class="clock-ico clock-ico--private"></div>
            <p switch-lang="<?=switchLang()?>" switchable-text="60 <span> мин </span>" class="lesson-time">60 <span> min </span></p>
            <p class="price"> $25</p>
        </div>
    </div>
    <div id="vue-book-calendar"></div>
</main>
<?php require 'pages/requires/footer.php' ?>

