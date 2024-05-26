<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once ("utils/autoload.php");
use app\DbConnect;

$raw =  (json_decode(file_get_contents("php://input"), true)) ? json_decode(file_get_contents("php://input"), true) : [];
$_POST= array_merge((array) $raw,$_POST);
print_r($_POST);
$error = [];
$data_value = 'domain';

if(empty($_POST[$data_value])){
    $error[$data_value]=[
        'error'=>'not found ' . $data_value
    ];
}

if(count($error)){
    die(json_encode($error)); 
}

$result = new DbConnect();

if(!empty($_POST['gmt'])) {
    die((json_encode($result->getQueryUpdateGpt($_POST['gmt'], $_POST['domain']),true)));
}

die((json_encode($result->getQueryUpdateStatus('false', $_POST['domain']),true)));