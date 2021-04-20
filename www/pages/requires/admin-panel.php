<?php
//require("vendor/autoload.php");

$request = json_decode(file_get_contents('php://input'), true);
if ($request['method'] == 'requireAdminComponents') {
    $result = $request['type'];
}
?>
<title>Страница преподавателя</title>
<body class="admin" id="mysite">

<header class="admin-header admin-inner"><a class="header-logo" href="index.php"></a>
    <h1 class="header-title">Светик, приветик!</h1>
    <div class="btn-exit">Выход</div>
<!--    <div class="admin-burger-btn">-->
<!--        <input class="burger-menu burger-menu-input" type="checkbox" id="burger">-->
<!--        <label class="burger-menu-label" for="burger">-->
<!--            <div class="burger-menu-line"></div>-->
<!--            <div class="burger-menu-line"></div>-->
<!--            <div class="burger-menu-line"></div>-->
<!--        </label>-->
<!--    </div>-->
</header>


<div class="decor-line decor-line--admin-header admin-inner"></div>
<nav class="admin-menu admin-inner">
    <div class="admin-menu__element admin-menu__element--mycalendar" type="my-calendar">Мой календарь</div>
    <div class="admin-menu__element admin-menu__element--myschedule" type="my-schedule">Мое расписание</div>
    <div class="admin-menu__element admin-menu__element--mystudents" type="my-students">Мои ученики</div>
<!--    <div class="admin-menu__element admin-menu__element--messages" type="my-messages">Сообщения</div>-->
<!--    <div class="admin-menu__element admin-menu__element--reviews" type="my-reviews">Отзывы</div>-->
</nav>

<div class="decor-line decor-line--nav-menu admin-inner"></div>
<main class="admin-main">
    <div id="vue-my-calendar"></div>
    <div id="vue-my-schedule"></div>
    <div id="vue-my-students"></div>
</main>
<footer class="admin-footer"></footer>

</body>