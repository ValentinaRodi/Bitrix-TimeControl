
<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once ("/var/www/smb_smartbiz_usr46/data/www/education.smartbiznes-bitrix.ru/timecontrol/utils/autoload.php");
use app\Logic;

include_once 'constant.php';

$entity = ENTITY;
$entityIdUsersSmart = entityIdUsersSmart;
$idUsersSmart = idUsersSmart;
$entityIdMonthSmart = entityIdMonthSmart;
$idMonthSmart = idMonthSmart;
$entityIdDaysSmart = entityIdDaysSmart;
$idDaysSmart = idDaysSmart;

$batchCallQuery = [];
$resUserSmart = [];
$batchCallQueryUsers = [];
$batchCallQueryMonths = [];
$batchCallQueryDays = [];
$batchCallQueryDaysAdd = [];
$batchCallQueryMonthsNew = [];
$batchCallQueryMonthsAdd = [];
$batchCallQueryDaysAddMonthDay = [];
$resItemToAddDay = [];

$month_list_day = array(
    1  => 'января',
    2  => 'февраля',
    3  => 'марта',
    4  => 'апреля',
    5  => 'мая', 
    6  => 'июня',
    7  => 'июля',
    8  => 'августа',
    9  => 'сентября',
    10 => 'октября',
    11 => 'ноября',
    12 => 'декабря'
);

$month_list_month = array(
    1  => 'Январь',
    2  => 'Февраль',
    3  => 'Март',
    4  => 'Апрель',
    5  => 'Май', 
    6  => 'Июнь',
    7  => 'Июль',
    8  => 'Август',
    9  => 'Сентябрь',
    10 => 'Октябрь',
    11 => 'Ноябрь',
    12 => 'Декабрь'
);


// Получение данных пользователей из Битрикс
$resultDb = $result->getQuerySelect();

if(!empty($resultDb)){

    foreach ($resultDb as $itemDb) {

        $resultUsers = $result->getRestUsers($itemDb);

        if(!empty($resultUsers)) {

            foreach ($resultUsers['result'] as $user) {

                $arData =  array(
                    'method' => 'timeman.status',
                    'params' => array('user_id' => $user['ID'])
                );

                $batchCallQuery['user' . ($user['ID'])] = $arData;
            }; 
        }
        //$resulbatchTimemanStatus = $result->call($itemDb, $batchCallQuery)['result']['result']; не верно
        $resulbatchTimemanStatus = $result->call($itemDb, $batchCallQuery);
        //$resulbatchTimemanStatus = (!empty($resulbatchTimemanStatus['result']['result'])) ? $resulbatchTimemanStatus['result']['result'] : [];
        
        //Получение данных из смарт-процессов
        $data = array('ENTITY' => $entity);

        if(!empty($result->getEntity($itemDb, $data))){
            
            $resultEntity = $result->getEntity($itemDb, $data);

            foreach ($resultEntity['result'] as $itemEntity) {

                $nameId = preg_replace("/[\d:]/", "", $itemEntity['NAME']);

                if($nameId === $entityIdUsersSmart) {
                    $entityIdUsers = intval(preg_replace('/[^0-9]+/', '', $itemEntity['NAME']));
                
                    $data = array('entityTypeId' => $entityIdUsers);

                    $resUserSmart = $result->getItemsSmart($itemDb, $data);
                }

                if($nameId === $idUsersSmart) {

                    $idUsers = intval(preg_replace('/[^0-9]+/', '', $itemEntity['NAME']));
                }

                if($nameId === $entityIdMonthSmart) {
                    $entityIdMonths = intval(preg_replace('/[^0-9]+/', '', $itemEntity['NAME']));

                    $data = array('entityTypeId' => $entityIdMonths);
                    $resMonthSmart = $result->getItemsSmart($itemDb, $data);
                }

                if($nameId === $idMonthSmart) {

                    $idMonths = intval(preg_replace('/[^0-9]+/', '', $itemEntity['NAME']));

                }

                if($nameId === $entityIdDaysSmart) {
                    $entityIdDays = intval(preg_replace('/[^0-9]+/', '', $itemEntity['NAME']));

                    $data = array('entityTypeId' => $entityIdDays);
                    $resDaySmart = $result->getItemsSmart($itemDb, $data);
                }

                if($nameId === $idDaysSmart) {
                    
                    $idDays = intval(preg_replace('/[^0-9]+/', '', $itemEntity['NAME']));
                }
                //Массив данных с перебором
            }
        } 
        
        //Сравнение пользователей Битрикс в смарт-процессе Пользователи
        if(!empty($resulbatchTimemanStatus) && !empty($resUserSmart)){

            $fieldIdUsersSmart = 'ufCrm' . $idUsers . 'IdUserCalendarSmb'; 

            $userId = array_keys($resulbatchTimemanStatus['result']['result']);
            
            $resultAddUser = array_filter($userId, function($user_id) use ($resUserSmart, $fieldIdUsersSmart) {
                $userIdNumber = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
            
                foreach ($resUserSmart['result']['items'] as $user) {
                    
                    $userIdSmart = $user[$fieldIdUsersSmart];

                    if(intval($userIdNumber) === $userIdSmart) {
                        return true;
                    }
                }
                return false;
            });

            $resultNewUser = array_filter($userId, function($user_id) use ($resUserSmart, $fieldIdUsersSmart) {
                $userIdNumber = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);

                foreach ($resUserSmart['result']['items'] as $user) {
                    $userIdSmart = $user[$fieldIdUsersSmart];

                    if(intval($userIdNumber) === $userIdSmart) {
                        return false;
                    }
                }
                return true;
            });
        }

        //Добаление данных новых пользователей
        if(!empty($resultNewUser)) {

            //Добавление новых пользователей в смарт-процесс Пользователи
            foreach ($resultNewUser as $newUser) {
                
                $idNewUser = preg_replace("/[^0-9]/", "", $newUser);

                if(!empty($resultUsers)) {

                    foreach ($resultUsers['result'] as $user) {

                        if($idNewUser === $user['ID']) {

                            $secondName = !empty($user['SECOND_NAME']) ? $user['SECOND_NAME'] : 'не задано';
                            
                            $arData =  array(
                                'method' => 'crm.item.add',
                                'params' => array(
                                    'entityTypeId' => $entityIdUsers,
                                    'fields' => array(
                                        'title' => $user['LAST_NAME'] . ' ' . $user['NAME'] . ' ' . $secondName,
                                        'ufCrm' . $idUsers . 'IdUserCalendarSmb' => $user['ID'],
                                        'ufCrm' . $idUsers . 'LastNameCalendarSmb' => $user['LAST_NAME'],
                                        'ufCrm' . $idUsers . 'NameCalendarSmb' => $user['NAME'],
                                        'ufCrm' . $idUsers . 'SecondNameCalendarSmb' => $secondName,
                                    )
                                )
                            );
            
                            $batchCallQueryUsers['user' . ($user['ID'])] = $arData;
                        }
                    }; 
                }
            }
            $resulbatchNewUsers = $result->call($itemDb, $batchCallQueryUsers);

            //Добавление новых пользователей в смарт-процесс Месяц
            if(!empty($resulbatchTimemanStatus) && !empty($resulbatchNewUsers)) {
                
                $userId = array_keys($resulbatchTimemanStatus['result']['result']);
                
                foreach ($resultNewUser as $newUser) {
                    
                    $idNewUser = preg_replace("/[^0-9]/", "", $newUser);

                    foreach ($userId as $id) {

                        $idUser = preg_replace("/[^0-9]/", "", $id);
                        $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);
                    
                        if($idNewUser === $userIdNumber && $resulbatchTimemanStatus['result']['result'][$id]['STATUS'] === 'CLOSED' && !empty($resulbatchTimemanStatus['result']['result'][$id]['TIME_FINISH']) && strpos($resulbatchTimemanStatus['result']['result'][$id]['DURATION'], '-') === false) {

                            $idElementsUsersSmart = $resulbatchNewUsers['result']['result'][$id]['item']['id'];


                            $resultId = $resulbatchTimemanStatus['result']['result'][$id];
                            $dataFinish = $resultId['TIME_FINISH'];
                            $duration = $resultId['DURATION'];
                            $dateString = strtotime($dataFinish);
                            $month = $month_list_month[date('n', $dateString)] . ' ' . date('Y', $dateString);
                            $monthNumber = date('n', $dateString);
                            
                            $arData =  array(
                                'method' => 'crm.item.add',
                                'params' => array(
                                    'entityTypeId' => $entityIdMonths,
                                    'fields' => array(
                                        'title' => $month,
                                        'ufCrm' . $idMonths . 'TimeMonthCalendarSmb' => $duration,
                                        'ufCrm' . $idMonths . 'DayMonthCalendarSmb' => '1',
                                        'ufCrm' . $idMonths . 'IdUserCalendarSmb' => $idNewUser,
                                        'ufCrm' . $idMonths . 'MonthCalendarSmb' => $monthNumber,
                                        'parentId' . $entityIdUsers => $idElementsUsersSmart,
                                    )
                                )
                            );

                            $batchCallQueryMonths['user' . $idNewUser] = $arData;
                        }  
                    } 
                }
            }
            $resulbatchNewUsersMonth = $result->call($itemDb, $batchCallQueryMonths);

            //Добавление новых пользователей в смарт-процесс День
            if(!empty($resulbatchNewUsersMonth)) {
                
                foreach ($resultNewUser as $newUser) {
                    
                    $idNewUser = preg_replace("/[^0-9]/", "", $newUser);

                    foreach ($userId as $id) {

                        $idUser = preg_replace("/[^0-9]/", "", $id);
                        $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);
                    
                        if($idNewUser === $userIdNumber && $resulbatchTimemanStatus['result']['result'][$id]['STATUS'] === 'CLOSED' && !empty($resulbatchTimemanStatus['result']['result'][$id]['TIME_FINISH'])) {
                            
                            $idElementsMonthsSmart = $resulbatchNewUsersMonth['result']['result'][$id]['item']['id'];
                            
                            /*  $day = date('d F Y', strtotime($resulbatchTimemanStatus['result']['result'][$id]['TIME_START']));
                                echo $day.' г.'; 
                                
                                setlocale(LC_ALL, 'ru_RU.utf8');
                                $day = strftime('%e %B %Y', strtotime($resulbatchTimemanStatus['result']['result'][$id]['TIME_START']));
                                echo $day.' г.'; 

                                setlocale(LC_ALL, 'ru_RU.utf8');
                                $day = date('d F Y', strtotime($resulbatchTimemanStatus['result']['result'][$id]['TIME_START']));
                                echo iconv('windows-1251', 'utf-8', $day).' г.';
                                echo $day.' г.'; 
                            */


                            $resultId = $resulbatchTimemanStatus['result']['result'][$id];
                            $dataFinish = $resultId['TIME_FINISH'];
                            $duration = $resultId['DURATION'];
                            $leaks = $resultId['TIME_LEAKS'];
                            
                            $dateString = strtotime($dataFinish);
                            $day = date('d', $dateString) . ' ' . $month_list_day[date('n', $dateString)] . ' ' . date('Y', $dateString) . ' г.';
                                
                            $arData =  array(
                                'method' => 'crm.item.add',
                                'params' => array(
                                    'entityTypeId' => $entityIdDays,
                                    'fields' => array(
                                        'title' => $day,
                                        'ufCrm' . $idDays . 'DayCalendarSmb' => $dataFinish,
                                        'ufCrm' . $idDays . 'DayDurationCalendarSmb' => $duration,
                                        'ufCrm' . $idDays . 'DayLeaksCalendarSmb' => $leaks,
                                        'ufCrm' . $idDays . 'IdUserCalendarSmb' => $idNewUser,
                                        'parentId' . $entityIdMonths => $idElementsMonthsSmart,
                                    )
                                )
                            );

                            $batchCallQueryDaysAdd['user' . $idNewUser] = $arData; 
                        }  
                    } 
                }
            }

            $resulbatchNewUsersDays = $result->call($itemDb, $batchCallQueryDaysAdd);
        } 
        
        //Обновление данных "старых" пользователей
        if(!empty($resultAddUser)) {
            $idMaxUsers = array();
            //Проверка данных пользователей
            if(!empty($resulbatchTimemanStatus)) {
                
                $userId = array_keys($resulbatchTimemanStatus['result']['result']);
                $resAddItemDay = [];

                foreach ($userId as $id) {

                    $idUser = preg_replace("/[^0-9]/", "", $id);
                    $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);     

                    $timemanUserDayKey =  isset($resulbatchTimemanStatus['result']['result'][$id]['TIME_FINISH']);

                    if(!empty($timemanUserDayKey)) {

                        $timemanUserData = $resulbatchTimemanStatus['result']['result'][$id]['TIME_FINISH'];

                        if(!empty($resDaySmart) && !empty($resMonthSmart)) {

                            $maxDayCalendarSmb = null;
                            $idMax = null;
                            $monthSmartIdMax = null;
                            foreach ($resDaySmart['result']['items'] as $itemDay) {

                                $idUserDay = $itemDay['ufCrm' . $idDays . 'IdUserCalendarSmb'];
                                $userDataSmart = $itemDay['ufCrm' . $idDays . 'DayCalendarSmb'];
                                
                                if((int)$userIdNumber === $idUserDay) {
                                    if ($maxDayCalendarSmb === null || $userDataSmart > $maxDayCalendarSmb) {
                                        $maxDayCalendarSmb = $userDataSmart;
                                        $idMax = $idUserDay;
                                        
                                    }
                                }
                            }    
                       
                            $monthMax = null;
            
                            foreach ($resMonthSmart['result']['items'] as $resMonthSmartItem) {
                                if($idMax === $resMonthSmartItem['ufCrm' . $idMonths . 'IdUserCalendarSmb']) {
                                    $month = $resMonthSmartItem['ufCrm' . $idMonths . 'MonthCalendarSmb'];
                                    if ($monthMax === null || $month > $monthMax) {
                                        $monthMax = $month;
                                        $monthSmartIdMax = $resMonthSmartItem['id'];
                                    }
                                }
                            }
                            
                            if(!empty($maxDayCalendarSmb) && !empty($monthMax && $timemanUserData !== $maxDayCalendarSmb)) {

                                $dateString = strtotime($timemanUserData);
                                $monthNumber = date('n', $dateString);

                                //Добавление данных в смарт-процессы, если месяц тот же
                                if((int)$monthNumber === $monthMax) {
                                   
                                    //Добавление данных в смарт-процесс День
                                    

                                    $resultId = $resulbatchTimemanStatus['result']['result'][$id];
                                    $dataFinish = $resultId['TIME_FINISH'];
                                    $duration = $resultId['DURATION'];
                                    $leaks = $resultId['TIME_LEAKS'];
                                    
                                    $dateString = strtotime($dataFinish);
                                    $day = date('d', $dateString) . ' ' . $month_list_day[date('n', $dateString)] . ' ' . date('Y', $dateString) . ' г.';
                                    
                                    $arDataDay =  array(
                                        'method' => 'crm.item.add',
                                        'params' => array(
                                            'entityTypeId' => $entityIdDays,
                                            'fields' => array(
                                                'title' => $day,
                                                'ufCrm' . $idDays . 'DayCalendarSmb' => $dataFinish,
                                                'ufCrm' . $idDays . 'DayDurationCalendarSmb' => $duration,
                                                'ufCrm' . $idDays . 'DayLeaksCalendarSmb' => $leaks,
                                                'ufCrm' . $idDays . 'IdUserCalendarSmb' => $userIdNumber,
                                                'parentId' . $entityIdMonths => $monthSmartIdMax,
                                            )
                                        )
                                    );

                                    $batchCallQueryDaysAdd['userDay' . $userIdNumber] = $arDataDay; 

                                    
                                    //Обновление данных в смарт-процессе Месяц
                                    foreach ($resMonthSmart['result']['items'] as $itemsMonthSmart) {
                                        
                                        if($monthSmartIdMax === $itemsMonthSmart['id']) {
                                    
                                            $itemsMonthSmartDuration = $itemsMonthSmart['ufCrm' . $idMonths . 'TimeMonthCalendarSmb'];
                                            
                                            $itemsMonthSmartDuration_seconds = strtotime($itemsMonthSmartDuration);
                                            $duration_seconds = strtotime($duration);
                                            $total_seconds = $itemsMonthSmartDuration_seconds + $duration_seconds;
                                            $total_time = date("H:i:s", $total_seconds);

                                            $itemsMonthSmartDay = $itemsMonthSmart['ufCrm' . $idMonths . 'DayMonthCalendarSmb'];
                                            $itemsMonthDay = $itemsMonthSmartDay + 1;

                                            $arDataMonth =  array(
                                                'method' => 'crm.item.update',
                                                'params' => array(
                                                    'entityTypeId' => $entityIdMonths,
                                                    'id' => $itemDay['parentId' . $entityIdMonths],
                                                    'fields' => array(
                                                        'ufCrm' . $idMonths . 'TimeMonthCalendarSmb' => $total_time,
                                                        'ufCrm' . $idMonths . 'DayMonthCalendarSmb' => $itemsMonthDay,
                                                    )
                                                )
                                            );       

                                            $batchCallQueryDaysAdd['userMonth' . $userIdNumber] = $arDataMonth; 
                                        }
                                    }
                                }
                                
                                //Добавление данных в смарт-процессы, если месяц другой
                                if((int)$monthNumber !== $monthMax) {
                                    array_push($idMaxUsers, 'user' . $userIdNumber);
                                    //Добавление данных в смарт-процесс Месяц
                                   
        
                                    $resultId = $resulbatchTimemanStatus['result']['result'][$id];
                                    $dataFinish = $resultId['TIME_FINISH'];
                                    $duration = $resultId['DURATION'];
                                    $dateString = strtotime($dataFinish);
                                    $month = $month_list_month[date('n', $dateString)] . ' ' . date('Y', $dateString);
                                    $monthNumber = date('n', $dateString);
                                    
                                    $idSmartUser = null;
                                    foreach ($resUserSmart['result']['items'] as $userSmartItem) {
                                        if((int)$userSmartItem['ufCrm' . $idUsers . 'IdUserCalendarSmb'] === (int)$userIdNumber) {
                                            $idSmartUser = $userSmartItem['id'];
                                        }
                                    }
                                   
                                    $arData =  array(
                                        'method' => 'crm.item.add',
                                        'params' => array(
                                            'entityTypeId' => $entityIdMonths,
                                            'fields' => array(
                                                'title' => $month,
                                                'ufCrm' . $idMonths . 'TimeMonthCalendarSmb' => $duration,
                                                'ufCrm' . $idMonths . 'DayMonthCalendarSmb' => '1',
                                                'ufCrm' . $idMonths . 'IdUserCalendarSmb' => $userIdNumber,
                                                'ufCrm' . $idMonths . 'MonthCalendarSmb' => $monthNumber,
                                                'parentId' . $entityIdUsers => $idSmartUser,
                                            )
                                        )
                                    );
        
                                    $batchCallQueryMonthsAdd['user' . $userIdNumber] = $arData;
                                }  
                            } 
                        }         
                    }          
                }  
             
                $resulbatchAddUsersDays = $result->call($itemDb, $batchCallQueryDaysAdd);
                $resulbatchAddUsersMonth = $result->call($itemDb, $batchCallQueryMonthsAdd);

                //Добавление данных в смарт-процесс День, если месяц другой
                if(!empty($resulbatchAddUsersMonth)) {
                    foreach ($idMaxUsers as $addUserMonth) {
                    
                        $idAddUser = preg_replace("/[^0-9]/", "", $addUserMonth);
    
                        foreach ($userId as $id) {
    
                            $idUser = preg_replace("/[^0-9]/", "", $id);
                            $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);
                        
                            if($idAddUser === $userIdNumber && $resulbatchTimemanStatus['result']['result'][$id]['STATUS'] === 'CLOSED' && !empty($resulbatchTimemanStatus['result']['result'][$id]['TIME_FINISH'])) {
                                
                                $idElementsMonthsSmart = $resulbatchAddUsersMonth['result']['result'][$id]['item']['id'];
    
                                $resultId = $resulbatchTimemanStatus['result']['result'][$id];
                                $dataFinish = $resultId['TIME_FINISH'];
                                $duration = $resultId['DURATION'];
                                $leaks = $resultId['TIME_LEAKS'];
                                
                                $dateString = strtotime($dataFinish);
                                $day = date('d', $dateString) . ' ' . $month_list_day[date('n', $dateString)] . ' ' . date('Y', $dateString) . ' г.';
                                    
                                $arData =  array(
                                    'method' => 'crm.item.add',
                                    'params' => array(
                                        'entityTypeId' => $entityIdDays,
                                        'fields' => array(
                                            'title' => $day,
                                            'ufCrm' . $idDays . 'DayCalendarSmb' => $dataFinish,
                                            'ufCrm' . $idDays . 'DayDurationCalendarSmb' => $duration,
                                            'ufCrm' . $idDays . 'DayLeaksCalendarSmb' => $leaks,
                                            'ufCrm' . $idDays . 'IdUserCalendarSmb' => $idAddUser,
                                            'parentId' . $entityIdMonths => $idElementsMonthsSmart,
                                        )
                                    )
                                );
    
                                $batchCallQueryDaysAddMonthDay['user' . $idAddUser] = $arData; 
                            }  
                        } 
                    }
                    $resulbatchNewUsersDays = $result->call($itemDb, $batchCallQueryDaysAddMonthDay);
                
                }
            }  
        }
    }
}