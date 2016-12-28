<?php
if (!defined("_KATE_MAIN")) die("You have no access to this file");

    $dbhost = "localhost";
    $dbuname = "miradio";
    $dbpass = "password";
    $dbname = "miradio";
    $global_path = "/zdata/www/miradio/";
    // $ffkill: 1 - use cron script ffkill.php; 0 - kill all ffmpeg
    //    $ffkill = 1; // not working yet
    $domain="111.111.111.111"; // your server domain name 'xxx.com' or ip
    
    // Sync with Master - send your playlist to masterserver
    $sync=0;
    $master_host="radio.nixadm.ru";
    $ident="yourident";
    $sync_pwd="yourpassword";
?>
