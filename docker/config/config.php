<?php
if (!defined("_KATE_MAIN")) die("You have no access to this file");
    $dbhost = "$MYSQL_HOST";
    $dbuname = "$MYSQL_ROOT_USER";
    $dbpass = "$MYSQL_ROOT_PASSWORD";
    $dbname = "$MYSQL_DATABASE";
    $global_path = "/zdata/www/miwifiradio/";
    $ffbin = "ffmpeg";
    $domain = "$DOMAIN_NAME";
    // Sync with Master - send your playlist to masterserver
    $sync=0;
    $master_host="ximiraga.ru";
    $ident="myvps";
    $sync_pwd="mypathforsync";
?>
