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
    <title switch-lang="<?=switchLang()?>" switchable-text="Мои занятия">My lessons</title>
    <main class="student-lessons">
        <section class="inner">
            <h2 switch-lang="<?=switchLang()?>" switchable-text="Мои занятия" class="main-title">My lessons</h2>
            <div class="empty-lesson-block <?=$activity?>">
                <h3 switch-lang="<?=switchLang()?>" switchable-text="у тебя пока нет предстоящих занятий" class="secondary-title">you don't have any upcoming classes yet</h3>
                <div class="flex">
                    <div class="elem elem--left">
                        <p switch-lang="<?=switchLang()?>" switchable-text="Если ты только начинаешь изучать русский язык, то забронируй 60-минутный урок с
                            преподавателем">If you are just starting to learn Russian, then book a 60-minute lesson with
                            as a tutor</p>
                        <a switch-lang="<?=switchLang()?>" switchable-text="забронировать" href="/private-lesson.php" class="button book-btn book-btn--private">book</a>
                    </div>

                    <div class="elem elem--right">
                        <p switch-lang="<?=switchLang()?>" switchable-text="Для тех, кто немного говорит по-русски и хочет улучшить разговорные навыки -
                            Разговорный клуб">For those who speak a little Russian and want to improve their conversational skills -
                            Speaking-Club</p>
                        <a switch-lang="<?=switchLang()?>" switchable-text="забронировать" href="/speaking-club.php" class="button book-btn book-btn--s-club">book</a>
                    </div>
                </div>

            </div>
            <div class="decor-line <?=$decorLine?>"></div>
            <div class="block free-less <?= $freeActive ?>">
                <div switch-lang="<?=switchLang()?>" switchable-text="Пробные уроки" class="block__elem block__elem--title">Trial lessons</div>
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
                <div switch-lang="<?=switchLang()?>" switchable-text="Занятия с преподавателем" class="block__elem block__elem--title">Individual lesson</div>
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
                <div switch-lang="<?=switchLang()?>" switchable-text=" Разговорный клуб" class="block__elem block__elem--title">Speaking - club</div>
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