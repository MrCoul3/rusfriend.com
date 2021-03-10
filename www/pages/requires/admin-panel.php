<?php
require("vendor/autoload.php");
?>
<title>Страница преподавателя</title>
<style>
    .day-time span {
        background-color: #5fe3e0;
        border: 0.5px solid #C4C4C4;
        box-sizing: border-box;
        border-radius: 5px;
        color: white;
        display: block;
        margin: 2px 0;
    }
</style>

<body class="admin" id="mysite">
<header class="admin-header inner"><a class="header-logo" href="../../index.php"></a>
    <h1 class="header-title">Светик, приветик!</h1>
    <div class="btn-exit">Выход</div>
</header>
<div class="decor-line decor-line--admin-header inner"></div>
<nav class="admin-menu admin-inner">
    <div class="admin-menu__element admin-menu__element--mycalendar">Мой календарь</div>
    <div class="admin-menu__element admin-menu__element--myschedule">Мое расписание</div>
    <div class="admin-menu__element admin-menu__element--mystudents">Мои ученики</div>
    <div class="admin-menu__element admin-menu__element--messages">Сообщения</div>
    <div class="admin-menu__element admin-menu__element--reviews">Отзывы</div>
</nav>
<div class="decor-line inner"></div>
<main class="admin-main">

    <?php include '../src/pages/include/my-calendar.html' ?>
    <?php include '../src/pages/include/my-schedule.html' ?>

</main>
<footer class="admin-footer"></footer>

<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<!--    <script src="scripts/admin-panel.js"></script>-->
<!--    <script src="scripts/admin-template.js"></script>-->
</body>