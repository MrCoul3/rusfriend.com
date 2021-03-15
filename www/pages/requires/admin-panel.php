<?php
?>
<title>Страница преподавателя</title>
<body class="admin" id="mysite">

<header class="admin-header"><a class="header-logo" href="index.php"></a>
    <h1 class="header-title">Светик, приветик!</h1>
    <div class="btn-exit">Выход</div>
</header>

<div class="decor-line decor-line--admin-header admin-inner"></div>
<nav class="admin-menu admin-inner">
    <div class="admin-menu__element admin-menu__element--mycalendar">Мой календарь</div>
    <div class="admin-menu__element admin-menu__element--myschedule">Мое расписание</div>
    <div class="admin-menu__element admin-menu__element--mystudents">Мои ученики</div>
    <div class="admin-menu__element admin-menu__element--messages">Сообщения</div>
    <div class="admin-menu__element admin-menu__element--reviews">Отзывы</div>
</nav>

<div class="decor-line admin-inner"></div>
<main class="admin-main">
    <div id="vue-my-calendar"></div>
    <div id="vue-my-schedule"></div>
    <div id="vue-my-students"></div>
</main>
<footer class="admin-footer"></footer>

</body>