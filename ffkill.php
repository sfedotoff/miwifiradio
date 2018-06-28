#!/usr/local/bin/php
<?php
// This is required for including configs and functions. Sorry, bad code :D
define("_KATE_MAIN", true);
include_once("config/config.php");
include_once($global_path."include/function.php");
// We don't want errors to block our app from displaying info
error_reporting(0);

$result = $db->sql_query("SELECT pid,title,xid, UNIX_TIMESTAMP(lastrequest) FROM radios where lastrequest is not NULL;");
while ( list($pid, $title, $xid, $lastrequest)= $db->sql_fetchrow($result) ) {
    $delta=time()-$lastrequest;
    // If radio does not listenning more than 120 sec, then kill pid
    if(intval(time()-$lastrequest)>120) {
	// Kill PID
        exec("kill $pid");
	sleep(1);
        // Now let's remove the playing dir
        rrmdir($global_path . 'uploads/playing'.$xid);
        // Updating table radios
        $db->sql_query("UPDATE radios SET pid=NULL,lastrequest=NULL WHERE xid='$xid'");
//        echo "ffmpeg($pid) playing ($title) was killed by timeout\n";
    }
}
