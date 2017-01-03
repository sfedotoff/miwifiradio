<?php
/* This is the format for radios list from ximalaya.com
     {
        "total_page":59, // total pages
        "total_count":1162, // total number of stations
        "current_page":1, // current page number
        "radios":[  // radios array
            {
                "id":527782701, // radio id. used for saving to favs
                "kind":"radio", // no changes here! kind can be album or radio.
                "program_name":"", // dunno wtf is this
                "radio_name":"Radio title", // title for the radio
                "radio_desc":"", // description for the radio
                "schedule_id":0, // this should be 0 as we have no shedule in ximalaya
                "support_bitrates":[64], // can be [24,64] or [24] or [64]. no need to change
                "rate24_aac_url":"", // url for m3u8 containing 24kbit chunks. no needed to change
                "rate64_aac_url":"http://api.ximalaya.com/527782701.m3u8", // url for m3u8 containing 64kbit chunks.
                "rate24_ts_url":"", // url for m3u8 containing 24kbit ts chunks. not needed for Mi WiFi Radio
                "rate64_ts_url":"", // url for m3u8 containing 64kbit ts chunks. not needed for Mi WiFi Radio
                "radio_play_count":20, // looks like number of radio listeners
                "cover_url_small":"https://i.vimeocdn.com/portrait/12983590_60x60.jpg", // cover 60x60
                "cover_url_large":"http://cache.lovethispic.com/uploaded_images/225898-True-Love-Never-Dies.jpg", // cover 640x640
                "updated_at":0, // update time, not needed
                "created_at":0 // creation time, not needed
            }
        ]
    }
*/
$query = urldecode($requestParams['params']['q']);
$curPage = $requestParams['params']['page'];
$starting = ($curPage > 1) ? 20 * ($curPage - 1) : 0;
list($resultNum) = $db->sql_fetchrow($db->sql_query("SELECT COUNT(*) FROM radios WHERE title LIKE '%$query%' OR description LIKE '%$query%'"));
if($resultNum == 0) {
    echo '{"total_page":0,"total_count":0,"current_page":1,"radios":[]}';
    exit;
} else {
    $result = $db->sql_query("SELECT id, xid, title, description, logo FROM radios WHERE title LIKE '%$query%' OR description LIKE '%$query%' ORDER BY xid ASC LIMIT $starting, 20");
    $radios = [];
    while($radioRow = $db->sql_fetchrow($result)) {
        $radios[] = '{"id":'.$radioRow['xid'].',"kind":"radio","program_name":"","radio_name":"'.addslashes($radioRow['title']).'","radio_desc":"'.addslashes($radioRow['description']).'","schedule_id":0,"support_bitrates":[64],"rate24_aac_url":"","rate64_aac_url":"http://'.$domain.'/'.$radioRow['xid'].'.m3u8","rate24_ts_url":"","rate64_ts_url":"","radio_play_count":1,"cover_url_small":"http://'.$domain.'/images/radiologos/thumb/thumb_'.$radioRow['logo'].'","cover_url_large":"http://'.$domain.'/'.$radioRow['logo'].'","updated_at":0,"created_at":0}';
    }
    $response = '{"total_page":'.ceil($resultNum/20).',"total_count":'.$resultNum.',"current_page":'.$curPage.',"radios":['.implode(",", $radios).']}';
    $response = str_replace("\n", "", $response);
    $response = str_replace("\r", "", $response);
    echo $response;
    exit;
}