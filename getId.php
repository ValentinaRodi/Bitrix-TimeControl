<?
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');
require_once ("/var/www/smb_smartbiz_usr46/data/www/education.smartbiznes-bitrix.ru/timecontrol/utils/autoload.php");
use app\Smart;

$resultDb = array(
    'DOMAIN' => 'crm.smartbiznes-bitrix.ru',
    'ACCESS_TOKEN'=> 'b997b36500689ebe0065d7ba00000007201c07c74ba35f16cf0aa2b90208d0a90b1ab0'
);
$result = new Smart();
$result->getSmartInfo($resultDb, 'UsersSmart');
print_r($result);
die(json_encode($result));
