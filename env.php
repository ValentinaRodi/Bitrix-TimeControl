<?
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
require_once ("/var/www/smb_smartbiz_usr46/data/www/education.smartbiznes-bitrix.ru/timecontrol/utils/autoload.php");
use app\GetBX;

$result = new GetBX();
$result->response();
//print_r($result);
die(json_encode($result));