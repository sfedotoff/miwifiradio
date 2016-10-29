<?php
if (!defined("_KATE_MAIN")) die("You have no access to this file");
include_once("config/config.php");
$breadcrumbs = "<a href=\"admin.php\" class='breadcrumb'>Панель управления</a>";
$pagetitle = "Панель управления";
head(0);
box_start("Панель управления сайтом");
?>
    Панель предназначена для управления содержимым сайта, его настройками и свойствами
<?php
box_end();
foot(0);
?>