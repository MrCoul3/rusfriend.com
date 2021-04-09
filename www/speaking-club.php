<?php
require 'pages/requires/header.php';
require("vendor/autoload.php");
?>
<title switch-lang="<?=switchLang()?>" switchable-text="Разговорный клуб" >speaking-club</title>
<main class="book-lesson speaking-club">
    <div class="description-block">
        <h2 switch-lang="<?=switchLang()?>" switchable-text="Разговорный клуб" class="title">Speaking - Club</h2>
        <p switch-lang="<?=switchLang()?>" switchable-text="Если ты уже немного говоришь по-русски и хочешь увеличить словарный запас, а так же приятно провести время за разговором - Разговорный клуб как раз для тебя." class="description">If you already speak a little Russian and want to increase your vocabulary, as well as have a good time talking - Speaking-Club is just for you.</p>
        <p switch-lang="<?=switchLang()?>" switchable-text="Урок НЕ включает грамматику и работу с упражнениями." class="description">The lesson does NOT include grammar and working with exercises.</p>
        <div class="decor-line"></div>
        <div class="params">
            <div class="clock-ico clock-ico--s-club"></div>
            <p switch-lang="<?=switchLang()?>" switchable-text="60 <span> мин </span>" class="lesson-time">60 <span> min </span></p>
            <p class="price">$25</p>
        </div>
    </div>
    <div id="vue-book-calendar"></div>
</main>
<?php require 'pages/requires/footer.php' ?>
