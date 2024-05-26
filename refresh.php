<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once ("/var/www/smb_smartbiz_usr46/data/www/education.smartbiznes-bitrix.ru/timecontrol/utils/autoload.php");
use app\DbConnect;
$result = new DbConnect();

include_once 'constant.php';
$clientId = CLIENT_ID;
$clientSecret = CLIENT_SECRET;

$resultDb = $result->getQuerySelect();

if(!empty($resultDb)){

    foreach ($resultDb as $item) {
        $domain = $item['DOMAIN'];
        $refreshToken = $item['REFRESH_TOKEN'];
        
        $params = array(
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $refreshToken
        );
        
        $url = 'https://oauth.bitrix.info/oauth/token/?' . http_build_query($params);

        //Отправляем запрос на получение нового access_token Декодируем ответ в формате JSON
        $data = json_decode(file_get_contents($url), true);

        // Получаем новый access_token
        $accessToken = $data['access_token'];
        $newRefreshToken = $data['refresh_token'];

        // Проверяем успешность запроса
        if (isset($data['error'])) {
            echo 'Error: ' . $data['error_description'];
        } else {
            print_r($accessToken);
            print_r($newRefreshToken);
            print_r($result->getQueryUpdate($accessToken, $newRefreshToken, $domain));
        } 
    } 
} 
