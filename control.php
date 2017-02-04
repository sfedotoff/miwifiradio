<?php
define("_KATE_MAIN", true);
include_once("config/config.php");
//include_once($global_path."include/admin/check_logged.php");
include_once($global_path."include/function.php");
include_once($global_path."include/ffcontrol.php");
Error_Reporting(1);
//echo "Huy!";
if(!isset($_GET['xid']) or !isset($_GET['act'])) {
    echo "Error: no param";
    exit(0);
}
$xid=$_GET['xid'];
$act=$_GET['act'];
if($act=='stop'){
  ffstop($xid);
} elseif ($act=='start') {
  $pid=ffstart($xid);
  if($pid=='') {
    echo "Error: ffmpeg not runing";
  } else {
    echo "ffmpeg runing with PID: $pid";
  }
} elseif ($act=='restart') {
  ffstop($xid);
  sleep(2);
  ffstart($xid);
  echo "ffmpeg restarted";
} else {
    echo "Error: No such action!";
}
//echo "$id $act";
