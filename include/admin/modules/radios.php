<?php
if (!defined("_KATE_MAIN")) die("You have no access to this file");
include_once("config/config.php");
include_once($global_path . "include/function.php");
include_once($global_path . "include/template.php");

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
        $genre_html='';
        $result=$db->sql_query("SELECT gid, en FROM genre");
        while( list($gid,$name)=$db->sql_fetchrow($result)){

		$genre_html.="<option value=\"$gid\">$name</option>";
        }
        $country_html='';
        $result=$db->sql_query("SELECT cid, en FROM country");
        while( list($cid,$name)=$db->sql_fetchrow($result)){

		$country_html.="<option value=\"$cid\">$name</option>";
        }
        

        echo "<form action=\"admin.php?mod=radios&act=do_add\" method=\"post\" enctype=\"multipart/form-data\" id=\"form\">
				<table width=\"100%\" cellspacing=\"5\" cellpadding=\"3\" border=\"0\">
				<tr><td>Название радио: </td><td><input type=\"text\" name=\"title\" style=\"width:400px;\"></td></tr>
				<tr><td>URL потока:</td><td><input type=\"text\" name=\"streamurl\" style=\"width:400px;\"></td></tr>
				<tr><td>Radio Country:</td><td>
				<select name=\"country\" style=\"width:400px;\">
".$country_html."
				</select></td></tr>
				
				<tr><td>Genre:</td><td>
				<select name=\"genre\" style=\"width:400px;\">
".$genre_html."
				</select></td></tr>
				<tr><td>Custom Header:</td><td><input type=\"text\" name=\"header\" style=\"width:400px;\"></td></tr>
				<tr><td>Disable encoding:</td><td><input type=\"checkbox\" name=\"noencode\">&nbsp;Disable encoding (just for testing!)</td></tr>
				

				
			    <tr><td>Logo:<br><small>(640x640px)</small> </td><td><input type=\"file\" name=\"userfile\" style=\"width:400px;\"></td></tr>
			    <tr><td valign=\"top\">Description:<br><small>(теги не включать!)</small> </td><td><textarea name=\"description\" cols=\"60\" rows=\"10\" style='width:400px;'></textarea></td></tr>
			    <tr><td></td><td><a class=\"button themed submit\" href=\"javascript:;\" onclick=\"$('#form').submit();\">Add</a></td></tr>
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
        $genre = $_POST['genre'];
        $country = $_POST['country'];
        $header = $_POST['header'];
        $noencode = $_POST['noencode'];
        if($noencode == 'on') $noencode=1; else $noencode=0;
        $image = upload_file("userfile", "images/radiologos", "", "images/radiologos/thumb", 64, 64, true);

        $db->sql_query("INSERT INTO radios (title, description, streamurl, logo, pid, lastrequest,xid,genre,country,header,noencode)
						VALUES ('$title', '$description', '$streamurl', '$image',NULL,NULL,527782000,$genre,$country,'$header',$noencode)");

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
        list($id, $title, $description, $streamurl, $logo, $genre, $country, $header, $noencode) = $db->sql_fetchrow($db->sql_query("SELECT id, title, description, streamurl, logo, genre, country, header, noencode FROM radios WHERE id='$id' LIMIT 1"));

        $genre_html='';
        $result=$db->sql_query("SELECT gid, en FROM genre");
        while( list($gid,$name)=$db->sql_fetchrow($result)){
	    if($gid==$genre) {		
		    $genre_html.="<option value=\"$gid\" selected>$name</option>";
		} else {
		    $genre_html.="<option value=\"$gid\">$name</option>";
		}
        }
        $country_html='';
        $result=$db->sql_query("SELECT cid, en FROM country");
        while( list($cid,$name)=$db->sql_fetchrow($result)){
	    if($cid==$country) {
		$country_html.="<option value=\"$cid\" selected>$name</option>";
	    } else {
	    	$country_html.="<option value=\"$cid\">$name</option>";
	    }
        }
        if($noencode == 1) $noencode='checked'; else $noencode='';


        head();
        box_start("Радиостанции - Редактировать");
        echo "<form action=\"admin.php?mod=radios&act=do_edit\" method=\"post\" enctype=\"multipart/form-data\" id=\"form\">
				<input type=\"hidden\" name=\"id\" value=\"$id\">
				<table width=\"100%\" cellspacing=\"5\" cellpadding=\"3\" border=\"0\">
				<tr><td>Название радио: </td><td><input type=\"text\" name=\"title\" style=\"width:400px;\" value='".htmlspecialchars($title)."'></td></tr>
				<tr><td>URL потока:</td><td><input type=\"text\" name=\"streamurl\" style=\"width:400px;\" value='".$streamurl."'></td></tr>
				<tr><td>Radio Country:</td><td>
				<select name=\"country\" style=\"width:400px;\">
".$country_html."
				</select></td></tr>
				
				<tr><td>Genre:</td><td>
				<select name=\"genre\" style=\"width:400px;\">
".$genre_html."
				</select></td></tr>
				<tr><td>Custom Header:</td><td><input type=\"text\" name=\"header\" style=\"width:400px;\" value='".htmlspecialchars($header)."'></td></tr>
				<tr><td>Disable encoding:</td><td><input type=\"checkbox\" name=\"noencode\" ".$noencode.">&nbsp;Disable encoding (just for testing!)</td></tr>

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
        $genre = $_POST['genre'];
        $country = $_POST['country'];
        $header = $_POST['header'];
        $noencode = $_POST['noencode'];
        $image = upload_file("userfile", "images/radiologos", "", "images/radiologos/thumb", 64, 64, true);
        if ($_POST['del_image'])
            $db->sql_query("UPDATE radios SET logo='' WHERE id='$id'");
        if (strlen($image) > 0) $db->sql_query("UPDATE radios SET logo='$image' WHERE id='$id'");
        if($noencode == 'on') $noencode=1; else $noencode=0;
        $db->sql_query("UPDATE radios SET title='$title', description='$description', streamurl='$streamurl', genre=$genre,country=$country,header='$header',noencode=$noencode
						WHERE id='$id'");
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
                        <th>URL</th>
                        <th>Genre</th>
                        <th>Country</th>
                        <th>Noencode</th>
                        <th>PID</th>
                        <th>Requests</th>
                        <th class=\"nosort tc\"><img src=\"/images/admin/template/grayscale/options.png\" title=\"Опции\"></th>
                    </tr>
                </thead>
                <tbody>";
        $result = $db->sql_query("SELECT radios.id, radios.xid, radios.title, radios.description, radios.streamurl, radios.logo, genre.en, country.en, radios.header, radios.noencode, radios.pid, radios.requests FROM radios,genre,country where genre.gid=radios.genre and  country.cid=radios.country ORDER BY id ASC;");

        while (list($id, $xid, $title, $description, $streamurl, $logo, $genre, $country, $header, $noencode, $pid, $requests) = $db->sql_fetchrow($result)) {
            echo "<tr onDblClick=\"location.href='?mod=radios&act=edit&id=$id'\">
                    <td align=\"center\">$xid</td>
                    <td title=\"" . mb_substr(htmlspecialchars(strip_tags($description)), 0, 250) . "\">" . stripslashes($title) . "</td>
                    <td>" . stripslashes($streamurl) . "</td>
                    <td>" . $genre . "</td>
                    <td>" . $country . "</td>
                    <td>" . $noencode . "</td>
                    <td>" . $pid . "</td>
                    <td>" . $requests . "</td>
                    <td align=\"center\" nowrap>
			            <a href=\"?mod=radios&act=edit&id=$id\" title=\"Редактировать\" class=\"button-small white\"><span class=\"icon_single edit\"></span></a>
			            <a href=\"?mod=radios&act=del&id=$id\" title=\"Удалить\" onclick=\"return del_check(this, 'Вы уверены, что хотите удалить эту запись?');\" class=\"button-small white\"><span class=\"icon_single cancel\"></span></a>
			            <a title=\"Остановить\" onclick=\"sync('http://".$domain."/control.php?act=stop&xid=".$xid."');\" class=\"button-small white\"><span class=\"icon_single stop\"></span></a>
			            <a title=\"Запустить\" onclick=\"sync('http://".$domain."/control.php?act=start&xid=".$xid."');\" class=\"button-small white\"><span class=\"icon_single start\"></span></a>
				    <a title=\"Перезапустить\" onclick=\"sync('http://".$domain."/control.php?act=restart&xid=".$xid."');\" class=\"button-small white\"><span class=\"icon_single restart\"></span></a>
			        </td>
			      </tr>";
        }
        echo "</tbody>
			  </table>";
        box_end();
        foot();
        break;
}
