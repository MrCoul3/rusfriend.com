<?php
require("vendor/autoload.php");
?>

<footer class="footer">
    <div class="decor-line decor-line--footer"></div>
    <div class="footer-content">
        <a class="footer-content__element footer-content__element--logo" href="/index.php"></a>
        <div class="footer-content__element footer-content__element--text">
            <h2 switch-lang="<?=switchLang()?>" switchable-text="Если возникли вопросы:" class="footer-questions">If you have any questions:</h2>
            <h2 class="footer-email">svetlana.totr@gmail.com</h2>
        </div>
        <div class="footer-content__element social-net-btns">
            <a class="social-net-btns__elem social-net-btns__elem--instagram" href="https://www.instagram.com/svetlana_totrova/" target="_blank"></a>
            <a class="social-net-btns__elem social-net-btns__elem--tiktok" href="/"></a>
        </div>
    </div>
</footer>

</body>
<script src="../../scripts/croppie/jquery-3.1.1.min.js"></script>
<script src="../../scripts/croppie/croppie.min.js"></script>
<script src="../../scripts/croppie/jquery.arcticmodal.js"></script>
<script src="../../scripts/croppie/script.js"></script>

</html>