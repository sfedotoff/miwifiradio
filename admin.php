<?php
define("_KATE_MAIN", true);
define("_ADMIN", true);
include_once("config/config.php");
include_once($global_path."include/admin/check_logged.php");
include_once($global_path."include/function.php");
Error_Reporting(0);
//Определяем подключаемый админ модуль
$mod_connect = $_REQUEST['mod'];
if(!isset($_REQUEST['mod'])) $mod_connect = "default";

include($global_path."include/admin/modules/".$mod_connect.".php");


?>