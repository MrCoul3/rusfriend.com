<?php
//phpinfo();
require 'pages/requires/header.php';
require("vendor/autoload.php");
?>
<?php if ($_SESSION['status'] === 'admin'): ?>
    <?php require 'pages/requires/admin-panel.php' ?>
<?php else: ?>
    <?php require 'pages/requires/main-page.php' ?>
    <?php require 'pages/requires/footer.php' ?>
<?php endif; ?>

