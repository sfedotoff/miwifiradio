<?php
if (!defined("_KATE_MAIN")) die("You have no access to this file");
    $dbhost = getenv('MYSQL_HOST');
    $dbuname = getenv('MYSQL_USER');
    $dbpass = getenv('MYSQL_PASSWORD');
    $dbname = getenv('MYSQL_DATABASE');
    $global_path = getenv('MIR_WWW_PATH');
    $ffbin = "ffmpeg";
    $domain = getenv('MIR_DOMAIN_NAME');
    // Sync with Master - send your playlist to masterserver
    $sync=0;
    $master_host="ximiraga.ru";
    $ident="myvps";
    $sync_pwd="mypathforsync";
?>
