<?php
require 'pages/requires/header.php';
require("vendor/autoload.php");
$monthes = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "October", "November", "December"];
$objCalendar = new \Classes\Calendar();
$result = $objCalendar->getLessons();
?>
    <title>Ваши занятия</title>
    <main class="student-lessons">
        <section class="inner">
            <h2 class="main-title">Ваши занятия</h2>
            <div class="decor-line"></div>
            <div class="block private-less">
                <div class="block__elem block__elem--title">Занятия с преподавателем</div>
                <div class="block__elem block__elem--decor-line-vertical"></div>
                <div class="block__elem block__elem--content">
                    <?php foreach ($result as $item):
                        if (($item[1] === $_SESSION['name']) and $item[4] === 'private'):
                            $arr = explode('.', $item[2]);
                            $arr[1] = $monthes[+$arr[1] - 1]; ?>
                            <div class="content-elem"><?= $arr[0] . ' ' . $arr[1] . ' ' . $item[3] ?></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="decor-line"></div>
            <div class="block s-club-less">
                <div class="block__elem block__elem--title">Speaking - club</div>
                <div class="block__elem block__elem--decor-line-vertical"></div>
                <div class="block__elem block__elem--content">
                    <?php foreach ($result as $item):
                        if (($item[1] === $_SESSION['name']) and $item[4] === 's-club'):
                            $arr = explode('.', $item[2]);
                            $arr[1] = $monthes[+$arr[1] - 1]; ?>
                            <div class="content-elem"><?= $arr[0] . ' ' . $arr[1] . ' ' . $item[3] ?></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>
<?php require 'pages/requires/footer.php' ?>