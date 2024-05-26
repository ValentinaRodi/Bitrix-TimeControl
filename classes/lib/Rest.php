<?
namespace lib;

class Rest

{
    const BATCH_COUNT = 50;//count batch 1 query

	public static function post(string $method, array $resultDb, array $data = [])
    {
        // Очищаем данные от возможных HTML-тегов и экранируем спецсимволы
        $accessToken = htmlspecialchars($resultDb['ACCESS_TOKEN'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $domain = htmlspecialchars($resultDb['DOMAIN'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $objRes = (object) [
            'method' => $method,
            'data' => $data
        ];

        $queryUrl = 'https://' . $domain . '/rest/' . $objRes->method . '.json';

        $queryData = http_build_query(
            array_merge($objRes->data, ['auth' => $accessToken])
        );

        // Используем curl-ресурс
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $queryUrl,
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => $queryData,
        ]);
        
        $result = curl_exec($curl);
        curl_close($curl);

        // Используем функцию json_decode с вторым аргументом true для получения ассоциативного массива
        $objRes->result = json_decode($result, true);

        return $objRes->result;
    }

    /* public static function hook(string $method, array $data = [], bool $timeout = false)
    {
        $objRes = (object) [
            'method' => $method,
            'data' => $data
        ];

        $queryUrl = 'https://crm.smartbiznes-bitrix.ru/rest/7/5x6ro6f6kr9n0ags/' . $objRes->method . '.json';

        $queryData = http_build_query($objRes->data);

        // Используем curl-ресурс
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $queryUrl,
            CURLOPT_POST => 1,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_POSTFIELDS => $queryData,
        ]);

        if ($timeout) {
            curl_setopt($curl, CURLOPT_TIMEOUT_MS, 200);
        }

        $result = curl_exec($curl);
        curl_close($curl);

        // Используем функцию json_decode с вторым аргументом true для получения ассоциативного массива
        $objRes->result = json_decode($result, true);

        echo "<pre>";print_r( $queryUrl); echo "</pre>";

        return $objRes->result;
    } */

    public static function callBatch($resultDb, $arData) {
        
        $arResult = [];

        if(is_array($arData)) {

            $arDataRest = [];
            $i = 0;

            foreach($arData as $key => $data) {
                
                if(!empty($data[ 'method' ])) {
    
                    $i++;

                    if(static::BATCH_COUNT >= $i) {

                        $arDataRest[ 'cmd' ][ $key ] = $data[ 'method' ];

                        if(!empty($data[ 'params' ])) {

                            $arDataRest[ 'cmd' ][ $key ] .= '?' . http_build_query($data[ 'params' ]);
                        }
                    }
                }
            }

            //print_r($arDataRest);
            if(!empty($arDataRest))
			{
                $result = static::post('batch', $resultDb, $arDataRest);
                return $result; 
			}
        }
        return $arResult;
    }
    

   
}




