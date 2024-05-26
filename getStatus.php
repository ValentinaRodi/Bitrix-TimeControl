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

die((json_encode($result->getQuerySelectPortal($_POST['domain']),true)));