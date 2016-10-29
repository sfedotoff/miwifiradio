<?php
if (!defined("_KATE_MAIN")) die("You have no access to this file");
include_once("config/config.php");
include_once($global_path . "include/function.php");

$breadcrumbs = "<a href=\"admin.php\" class=\"breadcrumb underline\">Панель управления</a> &raquo; <a href=\"admin.php?mod=kate_configurator\" class=\"breadcrumb\">Настройки</a>";
$pagetitle = "Настройки сайта";
$subnavmenu = "<ul>
				<li class=\"active\"><a class=\"subbutton white\" href=\"admin.php?mod=kate_configurator\"><span class=\"icon_text general\"></span>Настройки</a></li>
			</ul>";

head(0);
box_start("Настройки сайта");
if (!is_writeable($global_path . "config/config.php")) echo "<span class=\"message error\">Данные не могут быть сохранены, т.к. система не может получить доступ к файлу <b>" . $global_path . "config/config.php</b></span>";
if (count($_POST) > 0) {
    $content = "
    \$dbhost = \"" . $_POST['dbhost'] . "\";
    \$dbuname = \"" . $_POST['dbuname'] . "\";
    \$dbpass = \"" . $_POST['dbpass'] . "\";
    \$dbname = \"" . $_POST['dbname'] . "\";
    \$global_path = \"" . $_POST['global_path'] . "\";";

    writefile("config/config.php", $content);
    echo "<span class=\"message success\">Настройки сайта сохранены</span>";
}
include($global_path . "config/config.php");
echo "<form action=\"admin.php?mod=kate_configurator\" method=\"post\" id=\"form\">
	  <table cellspacing=\"3\" cellpadding=\"5\" border=\"0\" width=\"100%\">
	   <tr><td>MySQL хост: </td><td><input style=\"width: 400px;\" type=\"text\" name=\"dbhost\" value=\"" . stripslashes($dbhost) . "\"></td></tr>
	   <tr><td>MySQL пользователь: </td><td><input style=\"width: 400px;\" type=\"text\" name=\"dbuname\" value=\"" . stripslashes($dbuname) . "\"></td></tr>
	   <tr><td>MySQL пароль: </td><td><input style=\"width: 400px;\" type=\"text\" name=\"dbpass\" value=\"" . stripslashes($dbpass) . "\"></td></tr>
	   <tr><td>MySQL имя базы: </td><td><input style=\"width: 400px;\" type=\"text\" name=\"dbname\" value=\"" . stripslashes($dbname) . "\"></td></tr>
	   <tr><td>Абсолютный путь к корневому каталогу: </td><td><input style=\"width: 400px;\" type=\"text\" name=\"global_path\" value=\"" . stripslashes($global_path) . "\"></td></tr>
	   <tr><td></td><td><a class=\"button themed submit\" onclick=\"$('#form').submit();\">Сохранить</a></td></tr>
	  </table>
	  </form>";
box_end();
foot(0);
