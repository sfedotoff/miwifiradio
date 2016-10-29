<?php
// Including composer autoloader
require __DIR__ . '/vendor/autoload.php';
// Then registering autoloader for Requests library
Requests::register_autoloader();
// This is required for including configs and functions. Sorry, bad code :D
define("_KATE_MAIN", true);
include_once("config/config.php");
include_once($global_path."include/function.php");
// We don't want errors to block our app from displaying info
error_reporting(0);

$requestParams = request_compose();
$url = $requestParams['httpScheme'] . '://' . $requestParams['httpHost'] . $requestParams['requestPath'];

if($requestParams['requestPath'] == '/openapi-gateway-app/search/radios') {
    // Radio search request
    include($global_path . 'include/api/radiosearch.php');
} elseif($requestParams['requestPath'] == '/openapi-gateway-app/live/get_radios_by_ids') {
    // Radio list by ids
    include($global_path . 'include/api/get_radios_by_ids.php');
} else {
    // Requests which we don't intercept
     if($requestParams['method'] == 'GET') {
         $url .= '?' . $requestParams['paramsString'];
         $response = Requests::get($url);
     } else {
         $response = Requests::post($url, array(), $requestParams['params']);
     }
     echo $response->body;

     // Logging unknown/untracked requests
     //addlog($url); // URL composed by our wrapper
     //addlog($requestParams['requestPath']); // API path
     //addlog($response->body); // Response from API
}