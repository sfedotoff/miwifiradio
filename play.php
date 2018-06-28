<?php
// This is required for including configs and functions. Sorry, bad code :D
define("_KATE_MAIN", true);
include_once("config/config.php");
include_once($global_path."include/function.php");
include_once($global_path."include/ffcontrol.php");

// We don't want errors to block our app from displaying info
error_reporting(1);

$m3uFname = substr($_SERVER['QUERY_STRING'], 4);
$xid = intval($m3uFname);
$pid=ffstart($xid);
$db->sql_query("UPDATE radios SET requests=requests+1,lastrequest=now() WHERE xid='$xid'");
output_file($global_path . 'uploads/playing/' . $xid . '/pl.m3u8', 'pl.m3u8');
