<?php
if (!defined("_KATE_MAIN")) die("You have no access to this file");
include_once("config/config.php");
include_once($global_path . "include/function.php");
global $global_path;

$act = $_REQUEST['act'];
$subact = ($_REQUEST['subact']) ? $_REQUEST['subact'] : "";
$breadcrumbs = "<a href=\"admin.php\" class=\"breadcrumb underline\">Панель управления</a> &raquo; <a href=\"admin.php?mod=radios\">Радиостанции</a>";
$pagetitle = "Радиостанции";
if (strlen($act) == 0) {
    $active[0] = " class=\"active\"";
    $active[1] = "";
} else {
    $active[1] = ($act == "add") ? " class=\"active\"" : "";
    $active[0] = "";
}
$subnavmenu = "<ul>
				<li{$active[0]}><a class=\"subbutton white\" href=\"admin.php?mod=radios\"><span class=\"icon_text general\"></span>Список радиостанций</a></li>
				<li{$active[1]}><a class=\"subbutton white\" href=\"admin.php?mod=radios&act=add\"><span class=\"icon_text edit\"></span>Добавить радиостанцию</a></li>
			</ul>";

switch ($act) {
    // Create station form
    case "add":
        $breadcrumbs = "<a href=\"admin.php\" class=\"breadcrumb underline\">Панель управления</a> &raquo; <a href=\"admin.php?mod=radios\" class=\"breadcrumb underline\">Радиостанции</a> &raquo; <a href=\"admin.php?mod=radios&act=add\">Добавить радиостанцию</a>";
        $pagetitle .= " - Добавить радиостанцию";
        head();
        box_start("Радиостанции - Добавить");
        echo "<form action=\"admin.php?mod=radios&act=do_add\" method=\"post\" enctype=\"multipart/form-data\" id=\"form\">
				<table width=\"100%\" cellspacing=\"5\" cellpadding=\"3\" border=\"0\">
				<tr><td>Название радио: </td><td><input type=\"text\" name=\"title\" style=\"width:400px;\"></td></tr>
				<tr><td>URL потока:</td><td><input type=\"text\" name=\"streamurl\" style=\"width:400px;\"></td></tr>
			    <tr><td>Логотип:<br><small>(640x640px)</small> </td><td><input type=\"file\" name=\"userfile\" style=\"width:400px;\"></td></tr>
			    <tr><td valign=\"top\">Описание:<br><small>(теги не включать!)</small> </td><td><textarea name=\"description\" cols=\"60\" rows=\"10\" style='width:400px;'></textarea></td></tr>
			    <tr><td></td><td><a class=\"button themed submit\" href=\"javascript:;\" onclick=\"$('#form').submit();\">Добавить</a></td></tr>
				</table>
			</form>
			";
        box_end();
        foot();
        break;

    // Create station DB actions
    case "do_add":
        $title = $_POST['title'];
        $streamurl = $_POST['streamurl'];
        $description = $_POST['description'];
        $image = upload_file("userfile", "images/radiologos", "", "images/radiologos/thumb", 64, 64, true);

        $db->sql_query("INSERT INTO radios (title, description, streamurl, logo, pid, lastrequest,xid)
						VALUES ('$title', '$description', '$streamurl', '$image',NULL,NULL,527782000)");

        // We need a 9 digit long id for storing it on Xiaomi server for further interaction
        // This is the way we generate it. I am using standard template and replacing its last
        // digits with my id from database
        $id = $db->sql_nextid();
        $xid = substr('527782000', 0, (9-strlen($id))) . $id;
        $db->sql_query("UPDATE radios SET xid='$xid' WHERE id='$id'");
        header("Location: admin.php?mod=radios&mes=added");
        break;

    // Update station form
    case "edit":
        $id = $_GET['id'];
        $breadcrumbs .= " &raquo; <a href=\"admin.php?mod=radios&act=edit&id=$id\">Редактировать радиостанцию</a>";
        $pagetitle .= " - Редактировать";
        list($id, $title, $description, $streamurl, $logo) = $db->sql_fetchrow($db->sql_query("SELECT id, title, description, streamurl, logo FROM radios WHERE id='$id' LIMIT 1"));
        head();
        box_start("Радиостанции - Редактировать");
        echo "<form action=\"admin.php?mod=radios&act=do_edit\" method=\"post\" enctype=\"multipart/form-data\" id=\"form\">
				<input type=\"hidden\" name=\"id\" value=\"$id\">
				<table width=\"100%\" cellspacing=\"5\" cellpadding=\"3\" border=\"0\">
				<tr><td>Название радио: </td><td><input type=\"text\" name=\"title\" style=\"width:400px;\" value='".htmlspecialchars($title)."'></td></tr>
				<tr><td>URL потока:</td><td><input type=\"text\" name=\"streamurl\" style=\"width:400px;\" value='".$streamurl."'></td></tr>
			    <tr><td>Логотип: <br><small>(640x640px)</small> </td><td>";

        if (strlen($logo) > 0)
            echo "<input type=\"checkbox\" name=\"del_image\"> Отметьте, чтобы удалить, или выберите новое<br>";

        echo "<input type=\"file\" name=\"userfile\" style=\"width:400px;\"></td></tr>
			  <tr><td valign=\"top\">Описание: </td><td><textarea name=\"description\" cols=\"60\" rows=\"10\" style='width:400px;'>" . stripslashes($description) . "</textarea></td></tr>
			  <tr><td></td><td><a class=\"button themed submit\" href=\"javascript:;\" onclick=\"$('#form').submit();\">Сохранить</a> <a href=\"?mod=radios&act=del&id=$id\" title=\"Удалить\" onclick=\"return del_check(this, 'Вы уверены, что хотите удалить эту запись?');\" class=\"button white fr\"><span class=\"icon_single cancel\"></span></a></td></tr>
			  </table>
			</form>
			";
        box_end();
        foot();
        break;

    // Update station DB actions
    case "do_edit":
        $id = $_POST['id'];
        $title = $_POST['title'];
        $streamurl = $_POST['streamurl'];
        $description = $_POST['description'];
        $image = upload_file("userfile", "images/radiologos", "", "images/radiologos/thumb", 64, 64, true);
        if ($_POST['del_image'])
            $db->sql_query("UPDATE radios SET logo='' WHERE id='$id'");
        if (strlen($image) > 0) $db->sql_query("UPDATE radios SET logo='$image' WHERE id='$id'");
        $db->sql_query("UPDATE radios SET title='$title', description='$description', streamurl='$streamurl' WHERE id='$id'");
        header("Location: admin.php?mod=radios&mes=saved");
        break;

    // Deleting station
    case "del":
        $id = $_GET['id'];
        $db->sql_query("DELETE FROM radios WHERE id='$id'");
        header("Location: admin.php?mod=radios&mes=deleted");
        break;

    case "radios":
    default:
        head();
        box_start("Радиостанции");
        echo "<a href=\"?mod=radios&act=add\" class=\"button white\"><span class=\"icon_text addnew\"></span>Добавить</a>";
        if($sync==1) echo "<a onClick=\"sync('http://$master_host/syncws.php?vps_id=$ident&vps_key=$sync_pwd');\" class=\"button white\"><span class=\"icon_text sync\"></span>Синхронизация</a>";
        echo "<div style=\"clear: both; padding:0; height: 10px; margin: 0;\"> </div>";
        if (isset($_REQUEST['mes'])) {
            if ($_REQUEST['mes'] == "added") echo "<span class=\"message success\">Радиостанция успешно добавлена</span>";
            if ($_REQUEST['mes'] == "saved") echo "<span class=\"message success\">Радиостанция успешно изменена</span>";
            if ($_REQUEST['mes'] == "deleted") echo "<span class=\"message success\">Радиостанция успешно удалена</span>";
        }
        echo "<table class=\"display\" id=\"tabledata\">
	            <thead>
				    <tr>
                        <th class=\"nosort tc\">xid</th>
                        <th>Название</th>
                        <th class=\"nosort tc\"><img src=\"/images/admin/template/grayscale/options.png\" title=\"Опции\"></th>
                    </tr>
                </thead>
                <tbody>";
        $result = $db->sql_query("SELECT id, xid, title, description, streamurl, logo FROM radios ORDER BY id ASC");
        while (list($id, $xid, $title, $description, $streamurl, $logo) = $db->sql_fetchrow($result)) {
            echo "<tr>
                    <td align=\"center\">$xid</td>
                    <td title=\"" . mb_substr(htmlspecialchars(strip_tags($description)), 0, 250) . "\">" . stripslashes($title) . "</td>
                    <td align=\"center\" nowrap>
			            <a href=\"?mod=radios&act=edit&id=$id\" title=\"Редактировать\" class=\"button-small white\"><span class=\"icon_single edit\"></span></a>
			            <a href=\"?mod=radios&act=del&id=$id\" title=\"Удалить\" onclick=\"return del_check(this, 'Вы уверены, что хотите удалить эту запись?');\" class=\"button-small white\"><span class=\"icon_single cancel\"></span></a>
			        </td>
			      </tr>";
        }
        echo "</tbody>
			  </table>";
        box_end();
        foot();
        break;
}
