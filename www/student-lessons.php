<?php
require 'pages/requires/header.php';
require("vendor/autoload.php");
$monthes = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "October", "November", "December"];
$objCalendar = new \Classes\Calendar();
$result = $objCalendar->getLessons();
// для бесплатного занятия
$activity = 'empty-lesson-block-active';
$decorLine = 'decor-disable';
foreach ($result as $item) {
    if ($item[1] === $_SESSION['name']) {
        $activity = '';
        $decorLine = '';
        if ($item[4] === 'free') {
            $activity = '';
            $freeActive = 'block-active';
        }
        if ($item[4] === 'private') {
            $privateActive = 'block-active';
        }
        if ($item[4] === 's-club') {
            $sClubActive = 'block-active';
        }
    }
}

?>
    <title>Мои занятия</title>
    <main class="student-lessons">
        <section class="inner">
            <h2 class="main-title">Мои занятия</h2>
            <div class="empty-lesson-block <?=$activity?>">
                <h3 class="secondary-title">у тебя пока нет предстоящих занятий</h3>
                <div class="flex">
                    <div class="elem elem--left">
                        <p>Если ты только начинаешь изучать русский язык, то забронируй 60-минутный урок с
                            преподавателем</p>
                        <a href="/private-lesson.php" class="button book-btn book-btn--private">забронировать</a>
                    </div>

                    <div class="elem elem--right">
                        <p>Для тех, кто немного говорит по-русски и хочет улучшить разговорные навыки -
                            Speaking - Club</p>
                        <a href="/speaking-club.php" class="button book-btn book-btn--s-club">забронировать</a>
                    </div>
                </div>

            </div>
            <div class="decor-line <?=$decorLine?>"></div>
            <div class="block free-less <?= $freeActive ?>">
                <div class="block__elem block__elem--title">Пробные уроки</div>
                <div class="block__elem block__elem--decor-line-vertical"></div>
                <div class="block__elem block__elem--content">
                    <?php foreach ($result as $item):
                        if (($item[1] === $_SESSION['name']) and $item[4] === 'free'):
                            $arr = explode('.', $item[2]);
                            $arr[1] = $monthes[+$arr[1] - 1]; ?>
                            <div class="content-elem"><?= $arr[0] . ' ' . $arr[1] . ' ' . $item[3] ?></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="decor-line  <?=$decorLine?>"></div>
            <div class="block private-less <?= $privateActive ?>">
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
            <div class="decor-line  <?=$decorLine?>"></div>
            <div class="block s-club-less <?= $sClubActive ?>">
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
            <div class="decor-line  <?=$decorLine?>"></div>
        </section>
    </main>
<?php require 'pages/requires/footer.php' ?>