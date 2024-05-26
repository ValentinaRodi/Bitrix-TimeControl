<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once ("utils/autoload.php");
use app\DbConnect;

$raw =  (json_decode(file_get_contents("php://input"), true)) ? json_decode(file_get_contents("php://input"), true) : [];
$_POST= array_merge((array) $raw,$_POST);

$error = [];
$data_value = ['access_token','refresh_token', 'expires_in', 'domain', 'member_id'];

foreach ($data_value as $value) {
    if(empty($_POST[$value])){
        $error[$value]=[
            'error'=>'not found ' . $value
        ];
    }
}

if(count($error)){
    die(json_encode($error)); 
}

$result = new DbConnect();

$data = [
    ":DOMAIN" => $_POST['domain'],
    ":ACCESS_TOKEN" => $_POST['access_token'],
    ":REFRESH_TOKEN" => $_POST['refresh_token'],
    ":STATUS" => "true",
    ":GMT" => $_POST['gmt'],
];

$portals = $result->getQuerySelect();

if(!empty($portals)) {

    foreach($portals as $portal) {

        if($_POST['domain'] === $portal['DOMAIN'] && $portal['STATUS'] === 'false') {
            
            die((json_encode($result->getQueryUpdatePortal('true', $_POST['gmt'], $_POST['domain']), true)));
        }
    }
}

die((json_encode($result->getQueryIsert($data), true)));