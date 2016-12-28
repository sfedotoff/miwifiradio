<?php
// This is required for including configs and functions. Sorry, bad code :D
define("_KATE_MAIN", true);
include_once("config/config.php");
include_once($global_path."include/function.php");
// We don't want errors to block our app from displaying info
error_reporting(1);

$m3uFname = substr($_SERVER['QUERY_STRING'], 4);
$xid = intval($m3uFname);

//Getting PID of ffmpeg processing XID
exec("ps axwww | grep $xid | grep -v grep | head -n 1 | awk '{print $1}'", $pid);
//Starting ffmpeg if it is not running
$radioRow = $db->sql_fetchrow($db->sql_query("SELECT * FROM radios WHERE xid='$xid' LIMIT 1"));
if($radioRow['streamurl']=='') {
//  echo "Error! No radiostation with XID: $xid in db.";
    header("HTTP/1.0 404 Not Found");
    exit;
}
if($pid[0]=='')
{
    //Starting ffmpeg
    //Now let's remove the playing dir
    rrmdir($global_path . 'uploads/playing/'.$xid);
    //And create a new one
    mkdir($global_path . 'uploads/playing/'.$xid, 0777, true);
    //Then launch ffmpeg in background, redirect its output to devnull and sleep 7sec before returning playlist contents
    exec('/usr/local/bin/ffmpeg -headers \'User-Agent: "Dalvik/1.6.0 (Linux; U; Android 4.2.2; C2004 Build/15.2.A.2.5)"\' -i "'.$radioRow['streamurl'].'" -c:a libfdk_aac -b:a 64k -f ssegment -segment_list '.escapeshellarg($global_path . 'uploads/playing/' . $xid . '/pl.m3u8').' -segment_list_flags +live -segment_time 7 -segment_list_size 3 -segment_wrap 5 -segment_list_entry_prefix '.escapeshellarg('http://'.$domain.'/uploads/playing/' . $xid . '/').' ' . escapeshellarg($global_path . 'uploads/playing/' . $xid . '/64%03d.aac') . '  > /dev/null 2>&1 < /dev/null &');
    sleep(7);
    //Update PID and lastrequest in database
    exec("ps axwww | grep $xid | grep -v grep | head -n 1 | awk '{print $1}'", $pid);
    if($pid[0]==''){
	// ffmpeg cant runing
	echo "ffmpeg cant runing!";
    }
}
$db->sql_query("UPDATE radios SET pid='$pid[0]',lastrequest=now() WHERE xid='$xid'");
output_file($global_path . 'uploads/playing/' . $xid . '/pl.m3u8', 'pl.m3u8');
