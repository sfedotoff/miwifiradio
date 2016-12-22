<?php
if(!defined("_KATE_MAIN")) die("You have no access to this file");
include_once("config/config.php");
include_once($global_path."include/mysql.php");
global $global_path;
error_reporting(1);
if($db->sql_numrows($db->sql_query("SELECT id FROM admins LIMIT 1"))==0) {
	if(!isset($_POST['login'])) {
		$messages = "<span class=\"message alert\">Не создано ни одной учетной записи администратора. Создайте новую запись, используя форму ниже</span>";
		$redirect = (strlen($_SERVER['HTTP_REFERER'])>0) ? $_SERVER['HTTP_REFERER'] : $_SERVER['PHP_SELF'];
		$thefile = "\$r_file=\"".addslashes(file_get_contents("templates/admin/adm_create.html"))."\";";
		eval($thefile);
		echo stripslashes($r_file);
	} else {
		$login = $_POST['login'];
		$password = $_POST['password'];
		$pass2 = $_POST['password2'];
		$mail = $_POST['adm_mail'];
		$name = addslashes($_POST['name']);
		if(strlen($login)==0 OR strlen($password)==0 OR strlen($pass2)==0 OR strlen($mail)==0 OR strlen($name)==0) $error = "<span class=\"message error\">Не заполнено одно из полей. Все поля являются обязательными к заполнению.</span>";
		if($password!=$pass2) $error = "<span class=\"message error\">Введенные пароли не совпадают</span>";
		if($error) {
			$messages = "<span class=\"message information\">Не создано ни одной учетной записи администратора. Создайте новую запись, используя форму на странице</span>".$error;
			$redirect = (strlen($_SERVER['HTTP_REFERER'])>0) ? $_SERVER['HTTP_REFERER'] : $_SERVER['PHP_SELF'];
			$thefile = "\$r_file=\"".addslashes(file_get_contents("templates/admin/adm_create.html"))."\";";
			eval($thefile);
			echo stripslashes($r_file);
			exit;
		} else {
			$db->sql_query("INSERT INTO admins VALUES(NULL, '$login', '".md5($password)."', '$mail', '$name')");
			header("Location: admin.php");
		}
	}
exit;
}

function showLoginForm($error="") {
	$messages = $error;
	$redirect = (strlen($_SERVER['REQUEST_URI'])>0) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF'];
	$thefile = "\$r_file=\"".addslashes(file_get_contents("templates/admin/login.html"))."\";";
	eval($thefile);
	echo stripslashes($r_file);
}

function login() {
	global $db;
	$password = isset($_COOKIE['ad_pass']) ? $_COOKIE['ad_pass'] : "";
	$login = isset($_COOKIE['ad_login']) ? $_COOKIE['ad_login'] : "";
	if(strlen($password)>0) $num = $db->sql_numrows($db->sql_query("SELECT id FROM admins WHERE login='$login' AND pass='$password' LIMIT 1")); else $num = 0;
	if(!isset($_POST['password']) AND $num == 0) {
		$error = "<span class=\"message warning\">Данное действие требует авторизации. Введите свои данные в форму выше</span>";
//		if(strlen($password)>0) $error .= "<div class=\"message-box error\">Неверно указан логин или пароль</div>";
		showLoginForm($error);
		exit();
	} else if (isset($_POST['password'])) {
		$pass = isset($_POST['password']) ? $_POST['password'] : '';
		$login = isset($_POST['login']) ? $_POST['login'] : '';
		$result = $db->sql_query("SELECT * FROM admins WHERE login='$login' AND pass='".md5($pass)."'");
		$num = $db->sql_numrows($result);
		if ($num==0) {
			$error = "<span class=\"message warning\">Данное действие требует авторизации. Введите свои данные в форму выше</span>";
			if(strlen($pass)>0) $error .= "<span class=\"message error\">Неверно указан логин или пароль</span>";
			showLoginForm($error);
			exit();
		} else {
			$time = ($_POST['remember']) ? time()+604800 : 0;
			$row = $db->sql_fetchrow($result);
			setcookie("ad_pass", md5($pass), $time);
			setcookie("ad_login", $login, $time);
			setcookie("ad_mail", $row['mail'], $time);
			setcookie("ad_name", $row['name'], $time);
			header("Location: ".$_POST['redirect']);
		}
	}

}

login();
if(isset($_REQUEST['logout'])) {
	$redirect = (strlen($_SERVER['REQUEST_URI'])>0) ? $_SERVER['REQUEST_URI'] : $_SERVER['PHP_SELF'];
	setcookie("ad_pass", "");
	setcookie("ad_login", "");
	setcookie("ad_mail", "");
	setcookie("ad_name", "");
	if(!preg_match("/logout/", $redirect)) header("Location: $redirect"); else header("Location: admin.php");
}
?>