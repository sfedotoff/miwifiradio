<?php
define("_KATE_MAIN", true);
include_once("../../config/config.php");
include_once($global_path."include/function.php");
// We don't want errors to block our app from displaying info
error_reporting(0);
if($sync==1) {
    $result = $db->sql_query("SELECT xid, title, streamurl, description, logo, country, genre, header, noencode FROM radios");
    $radios = [];
    while($radioRow = $db->sql_fetchrow($result)) {
	$radios[] = '{"xid":"'.$radioRow['xid'].'","title":"'.addcslashes($radioRow['title'], '"\\/').'","streamurl":"'.$radioRow['streamurl'].'","description":"'.addcslashes($radioRow['description'], '"\\/').'","logo":"'.$radioRow['logo'].'","country":"'.$radioRow['country'].'","genre":"'.$radioRow['genre'].'","header":"'.addcslashes($radioRow['header'], '"\\/').'","noencode":"'.$radioRow['noencode'].'"}';
    }
    $response = '['.implode(",", $radios).']';
    $response = str_replace("\n", "", $response);
    $response = str_replace("\r", "", $response);
    
    echo $response;
} else {
    echo "Syncronisation is disabled in config file";
}
exit;
