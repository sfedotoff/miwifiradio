<?php
/*
 Request: http://api.ximalaya.com/openapi-gateway-app/live/get_radios_by_ids?access_token=[token]&app_key=[appkey]&client_os_type=2&device_id=[devid]&ids=1739&pack_id=com.ximalaya.xiaomi.ting&sdk_version=v1.0&sig=[signature]
 Key params: ids, split by coma
 Method: GET
 Response:
 {
    "radios":[
        {
            "id":1739,
            "kind":"radio",
            "program_name":"经典875",
            "radio_name":"FM87.5经典音乐调频",
            "radio_desc":"",
            "schedule_id":192289,
            "support_bitrates":[24,64],
            "rate24_aac_url":"http://live.xmcdn.com/live/1853/24.m3u8",
            "rate64_aac_url":"http://live.xmcdn.com/live/1853/64.m3u8",
            "rate24_ts_url":"http://live.xmcdn.com/live/1853/24.m3u8?transcode=ts",
            "rate64_ts_url":"http://live.xmcdn.com/live/1853/64.m3u8?transcode=ts",
            "radio_play_count":3605145,
            "cover_url_small":"http://fdfs.xmcdn.com/group8/M04/F4/EE/wKgDYFarFUGhU4IfAAA_8PmYlK0916_mobile_small.jpg",
            "cover_url_large":"http://fdfs.xmcdn.com/group8/M04/F4/EE/wKgDYFarFUGhU4IfAAA_8PmYlK0916_mobile_large.jpg",
            "updated_at":0,
            "created_at":0
        }
    ]
 }
*/

$idString = $requestParams['params']['ids'];
$idArray = explode(',', $idString);
$realXimalayaIds = [];
$myRadios = [];

foreach ($idArray as $id) {
    if(strpos($id, '527782') !== false) {
        $radioRow = $db->sql_fetchrow($db->sql_query("SELECT * FROM radios WHERE xid='$id' LIMIT 1"));
        $myRadios[] = '{"id":'.$radioRow['xid'].',"kind":"radio","program_name":"","radio_name":"'.addslashes($radioRow['title']).'","radio_desc":"'.addslashes($radioRow['description']).'","schedule_id":0,"support_bitrates":[64],"rate24_aac_url":"","rate64_aac_url":"http://'.$domain.'/'.$radioRow['xid'].'.m3u8","rate24_ts_url":"","rate64_ts_url":"","radio_play_count":1,"cover_url_small":"http://'.$domain.'/images/radiologos/thumb/thumb_'.$radioRow['logo'].'","cover_url_large":"http://'.$domain.'/images/radiologos/'.$radioRow['logo'].'","updated_at":0,"created_at":0}';
    } else {
        // Adding this id to list for parsing from real Ximalaya
        $realXimalayaIds[] = $id;
    }
}

// Combine real Ximalaya ids to string and replace the existing parameter in the request
$requestParams['params']['ids'] = implode(',', $realXimalayaIds);


// TODO: perform request to API if needed. Then override the response
$response = '{"radios":['.implode(',', $myRadios).']}';
$response = str_replace("\n", "", $response);
$response = str_replace("\r", "", $response);
echo $response;
