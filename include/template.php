<?php
if(!defined("_KATE_MAIN")) die("You have no access to this file");
include_once($global_path."config/config.php");

if(!defined("_ADMIN")) {
	function head() {
		global $pagetitle, $meta_keywords, $meta_description, $site_keywords, $site_description, $site_title, $db, $global_path;
		$metakeys = ($meta_keywords AND strlen($meta_keywords)>0) ? $meta_keywords.", ".$site_keywords : $site_keywords;
		$metadesc = ($meta_description AND strlen($meta_description)>0) ? $meta_description.", ".$site_description : $site_description;
		$pagetitle = (strlen($pagetitle)>0) ? $pagetitle." - ".$site_title : $site_title;
		$thefile = "\$r_file=\"".addslashes(file_get_contents("templates/site/header.html"))."\";";
		eval($thefile);
		echo stripslashes($r_file);
	}
	function foot() {
		global $db;
		$sqlinfo = $db->sql_info();
		$thefile = "\$r_file=\"".addslashes(file_get_contents("templates/site/footer.html"))."\";";
		eval($thefile);
		echo stripslashes($r_file);
	}
	function error($text){
		global $error;
		$error = "1";
		echo "<div style=\"text-align: center;\"><h1 style=\"color: red;\">Ошибка!</h1><p style=\"text-align:center; font-size: 12px;\">$text</p></div>";
		echo "</td></tr></table><!-- end of content -->";
		foot();
		exit;
	}


	function get_template($template_name) {
		$content = file_get_contents("templates/site/".$template_name.".html");
		return preg_replace_callback('/{%block-(\w+)%}/i', "block_parse", $content);
	}

	function parse_template($arr,$template) {
		if(!isset($arr['pagesnum'])) $arr['pagesnum'] = "";
		date_default_timezone_set("Europe/London");
		$arr['sitedate_l'] = date("d/m/Y H:i");
		date_default_timezone_set("Europe/Moscow");
		$arr['sitedate_m'] = date("d/m/Y H:i");
		foreach($arr as $key => $value) {
			$template = str_replace("{".$key."}", $value, $template);
		}
		return $template;
	}
	function block_parse($matches){
		global $global_path;
		ob_start();
		include("templates/site/blocks/".$matches[1].".php");
		$b_content = ob_get_contents();
		ob_end_clean();
		return $b_content;
	}
} else {
	function head() {
		global $pagetitle, $breadcrumbs, $db, $subnavmenu;
		$user_real = $_COOKIE['ad_name'];
		if(preg_match("/gzip/", $_SERVER['HTTP_ACCEPT_ENCODING'])) ob_start("ob_gzhandler");
		$menu = top_admin_menu();
		if($_COOKIE['fullsize']=="yes") $hider = " style=\"width: 100%;\""; else $hider = "";
		$sqlinfo = $db->sql_info();
		$thefile = "\$r_file=\"".addslashes(file_get_contents("templates/admin/header_full.html"))."\";";
		eval($thefile);
		echo stripslashes($r_file);
	}
	function foot() {
		global $db;
		$sqlinfo = $db->sql_info();
		if($_COOKIE['fullsize']=="yes") $hider2 = " style=\"display:none\""; else $hider2 = "";
		$thefile = "\$r_file=\"".addslashes(file_get_contents("templates/admin/footer.html"))."\";";
		eval($thefile);
		echo stripslashes($r_file);
	}

	function get_block_contents($mod_connect) {
		global $global_path;
		include_once($global_path."include/admin/blocks/$mod_connect.php");
		$block_ = array($btitle, $bcontent);
		return $block_;
	}
	function box_start($title, $hidden='0') {
		if($hidden=="1") $hide = " style=\"display:none;\""; else $hide = "";
		$thefile = "\$r_file=\"".addslashes(file_get_contents("templates/admin/box_start.html"))."\";";
		eval($thefile);
		echo stripslashes($r_file);
	}
	function box_end() {
		$thefile = "\$r_file=\"".addslashes(file_get_contents("templates/admin/box_end.html"))."\";";
		eval($thefile);
		echo stripslashes($r_file);
	}
}

?>