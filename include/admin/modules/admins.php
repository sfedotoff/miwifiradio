<?php
if (!defined("_KATE_MAIN")) die("You have no access to this file");
include_once("config/config.php");
include_once($global_path . "include/function.php");

$act = $_REQUEST['act'];
$subact = ($_REQUEST['subact']) ? $_REQUEST['subact'] : "";
$breadcrumbs = "<a href=\"admin.php\" class=\"breadcrumb underline\">Панель управления</a> &raquo; <a href=\"admin.php?mod=admins\">Администраторы</a>";
$pagetitle = "Администраторы";
if (strlen($act) == 0) {
    $active[0] = " class=\"active\"";
    $active[1] = "";
} else {
    $active[1] = ($act == "add") ? " class=\"active\"" : "";
    $active[0] = "";
}
$subnavmenu = "<ul>
				<li{$active[0]}><a class=\"subbutton white\" href=\"admin.php?mod=admins\"><span class=\"icon_text general\"></span>Список</a></li>
				<li{$active[1]}><a class=\"subbutton white\" href=\"admin.php?mod=admins&act=add\"><span class=\"icon_text edit\"></span>Добавить</a></li>
			</ul>";

switch ($act) {
    case "add":
        $breadcrumbs = "<a href=\"admin.php\" class=\"breadcrumb underline\">Панель управления</a> &raquo; <a href=\"admin.php?mod=admins\" class=\"breadcrumb underline\">Администраторы</a> &raquo; <a href=\"admin.php?mod=admins&act=add\" class=\"breadcrumb\">Добавить администратора</a>";
        $pagetitle .= " - Добавить";
        head();
        box_start("Администраторы - Добавить");
        echo "<form action=\"admin.php?mod=admins&act=do_add\" method=\"post\" id=\"form\">
				<table class=\"mauto\" cellspacing=\"5\" cellpadding=\"3\" border=\"0\">
				<tr><td>Логин админа: </td><td><input type=\"text\" name=\"alogin\" style=\"width:400px;\"></td></tr>
				<tr><td>Имя админа: </td><td><input type=\"text\" name=\"rname\" style=\"width:400px;\"></td></tr>
				<tr><td>Электропочта админа: </td><td><input type=\"text\" name=\"mail\" style=\"width:400px;\"></td></tr>
				<tr><td>Пароль админа: </td><td><input type=\"text\" name=\"apassword\" style=\"width:400px;\"></td></tr>
			  	<tr><td></td><td><a class=\"button themed submit\" onclick=\"$('#form').submit();\">Добавить</a></td></tr>
				</table>
			  </form>
			";
        box_end();
        foot();
        break;
    case "edit":
        $id = $_GET['id'];
        if ($id == 1) header("Location: admin.php?mod=admins");
        $breadcrumbs = "<a href=\"admin.php\" class=\"breadcrumb underline\">Панель управления</a> &raquo; <a href=\"admin.php?mod=admins\" class=\"breadcrumb underline\">Администраторы</a> &raquo; <a href=\"admin.php?mod=admins&act=edit&id=$id\" class=\"breadcrumb\">Редактировать администратора</a>";
        $pagetitle .= " - Редактировать";
        list($id, $login, $pass, $mail, $name) = $db->sql_fetchrow($db->sql_query("SELECT * FROM admins WHERE id='$id'"));
        head();
        box_start("Администраторы - Редактировать");
        echo "<form action=\"admin.php?mod=admins&act=do_edit\" method=\"post\" id=\"form\">
				<table cellspacing=\"5\" cellpadding=\"3\" border=\"0\" class=\"mauto\">
				<tr><td>Логин админа: </td><td><input type=\"text\" name=\"alogin\" value=\"$login\" style=\"width:400px;\"></td></tr>
				<tr><td>Имя админа: </td><td><input type=\"text\" name=\"rname\" value=\"$name\" style=\"width:400px;\"></td></tr>
				<tr><td>Электропочта админа: </td><td><input type=\"text\" name=\"mail\" value=\"$mail\" style=\"width:400px;\"></td></tr>
				<tr><td>Новый пароль админа: </td><td><input type=\"text\" name=\"apassword\" style=\"width:400px;\"></td></tr>
			  	<tr><td></td><td><a class=\"button themed submit\" onclick=\"$('#form').submit();\">Сохранить</a></td></tr>
				</table>
			  </form>
			";
        box_end();
        foot();
        break;
    case "do_edit":
        $id = $_POST['id'];
        $alogin = $_POST['alogin'];
        $adname = $_POST['rname'];
        $amail = $_POST['mail'];
        $apass = md5($_POST['apassword']);
        $db->sql_query("UPDATE admins SET login='$alogin', name='$adname', mail='$amail', pass='$apass' WHERE id='$id'");
        header("Location: admin.php?mod=admins&mes=saved");
        break;
    case "do_add":
        $id = $_POST['id'];
        $alogin = $_POST['alogin'];
        $adname = $_POST['rname'];
        $amail = $_POST['mail'];
        $apass = md5($_POST['apassword']);
        $db->sql_query("INSERT INTO admins (login, pass, mail, name)
						VALUES ('$alogin', '$apass', '$amail', '$adname')");
        header("Location: admin.php?mod=admins&mes=added");
        break;
    case "del":
        $id = $_GET['id'];
        if ($id == 1) header("Location: admin.php?mod=admins");
        $db->sql_query("DELETE FROM admins WHERE id='$id'");
        header("Location: admin.php?mod=admins&mes=deleted");
        break;
    case "admins":
    default:
        head();
        box_start("Администраторы");
        echo "<a href=\"?mod=admins&act=add\" class=\"button white\"><span class=\"icon_text addnew\"></span>Добавить</span></a>"
            . "<div style=\"clear: both; padding:0; height: 20px; margin: 0;\"> </div>";
        if (isset($_REQUEST['mes'])) {
            if ($_REQUEST['mes'] == "added") echo "<span class=\"message success\">Администратор успешно добавлен</span>";
            if ($_REQUEST['mes'] == "saved") echo "<span class=\"message success\">Администратор успешно изменен</span>";
            if ($_REQUEST['mes'] == "deleted") echo "<span class=\"message success\">Администратор успешно удален</span>";
        }
        echo "
<table class=\"display\" id=\"tabledata\">
	<thead>
		<tr>
				<th class=\"first tc\">Id</th>
				<th>Логин</th>
				<th>Имя</th>
				<th>Почта</th>
				<th class=\"tc nosort\"><img src=\"/images/admin/template/grayscale/options.png\" title=\"Опции\"></th>
				</tr>
				</thead>
				<tbody>";
        $pagenum = $_GET['pagenum'];
        $pagenum = (!$pagenum) ? 1 : $pagenum;
        $offset = ($pagenum - 1) * 25;
        $num = $db->sql_numrows($db->sql_query("SELECT id FROM admins"));
        $result = $db->sql_query("SELECT id, login, name, mail FROM admins" . $sql_add . " ORDER BY id ASC LIMIT $offset,25");
        while (list($id, $login, $name, $mail) = $db->sql_fetchrow($result)) {
            echo "<tr><td align=\"center\">$id</td><td>$login</td><td>$name</td><td>$mail</td><td align=\"center\" nowrap>";
            if ($id != 1) echo "<a href=\"?mod=admins&act=edit&id=$id\" title=\"Редактировать\" class=\"button-small white\"><span class=\"icon_single edit\"></span></a> <a href=\"?mod=admins&act=del&id=$id\" title=\"Удалить\" onclick=\"return del_check(this, 'Вы уверены, что хотите удалить этот аккаунт?');\" class=\"button-small white\"><span class=\"icon_single cancel\"></span></a>";
            echo "</td></tr>";
        }
        echo "</tbody>
			  </table>
			  <div class=\"clear\"></div>";
        box_end();
        foot();
        break;
}
