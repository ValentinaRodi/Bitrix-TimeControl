<?
// header('Content-Type: application/json; charset=utf-8');
// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
namespace app;

require_once ("/var/www/smb_smartbiz_usr46/data/www/education.smartbiznes-bitrix.ru/timecontrol/utils/autoload.php");
use app\Smart;
use lib\Rest;

class UpdaterBX
{
    public array $portal;
    public array $resultUsers;
    public $smartConnect;
    public array $resultUsersTimeman;
    
    public array $resultSmartUsers;
    public array $resultSmartMonth;
    public array $resultSmartDays;

    public array $resultAddUsers;
    public array $resultNewUsers;
    public array $resulBatchNewSmartUsers;

    public array $month_list_month;
    public array $month_list_day;
    
	public function __construct()
    {
        $this->portal = [];
        $this->resultUsers = [];
        $this->smartConnect = new Smart();
        $this->resultUsersTimeman = [];
        
        $this->resultSmartUsers = [];
        $this->resultSmartMonth = [];
        $this->resultSmartDays = [];

        $this->resultAddUsers = [];
        $this->resultNewUsers = [];

        $this->resulBatchNewSmartUsers = [];
        $this->resulBatchNewSmartMonth = [];
        $this->resulBatchNewSmartDays = [];

        $this->month_list_month = ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];
        $this->month_list_day = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];
    }

    public function updaterBX($itemDb)
	{
        $this->portal = $itemDb;

        $resultUsersSmart = $this->getSmartUsers();

        if(!empty($this->getUsersBX()) && !empty($resultUsersSmart)){

            if(!empty($resultUsersSmart['result'])) {

                $resultMonthSmart = $this->getSmartMonth();
                $resultDaySmart = $this->getSmartDays();

                if(!empty($resultMonthSmart['result']) && !empty($resultDaySmart['result'])) {

                    $this->resultAddUsers = $this->comparetUsers(true, false);
                    $this->resultNewUsers = $this->comparetUsers(false, true);

                    if(!empty($this->resultNewUsers) && !empty($this->resultAddUsers)) {
                        
                        return [$this->addNewUsers(), $this->addAddUsers()];
                    }
                    
                    if(!empty($this->resultNewUsers)) {
                        
                        return $this->addNewUsers();
                    }

                    if(!empty($this->resultAddUsers)) {
                        
                        return $this->addAddUsers();
                    }

                    return ['not data to update Smart'];
                }

                //Если смарт-процесс Месяц пустой
                if(!empty($resultDaySmart['result'])) {

                    $userId = array_keys($this->resultUsersTimeman);

                    foreach ($userId as $id) {

                        $idUser = preg_replace("/[^0-9]/", "", $id);
                        $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);
                            
                        if($this->resultUsersTimeman[$id]['STATUS'] === 'CLOSED' && !empty($this->resultUsersTimeman[$id]['TIME_FINISH']) && strpos($this->resultUsersTimeman[$id]['DURATION'], '-') === false) {
            
                            $idElementsUsersSmart = $userIdNumber;
                            
                            $arData = $this->getBatchMonth($this->resultUsersTimeman[$id], $userIdNumber, $idElementsUsersSmart);
                            
                            if(!empty($arData)) {
                                $batchCallQueryMonths['user' . $userIdNumber] = $arData;
                            }       
                        }  
                    
                    }

                    $resulbatchNewUsersMonth = $this->smartConnect->call($this->portal , $batchCallQueryMonths);
                
                    if(!empty($resulbatchNewUsersMonth['result']['result'])) {

                        $this->resulBatchNewSmartMonth = $resulbatchNewUsersMonth['result']['result'];
        
                        return $this->addItemSmartDays();
                    }
                }
                
                //Если смарт-процесс День пустой
                if(!empty($resultMonthSmart['result'])) {

                    $userId = array_keys($this->resultUsersTimeman);

                    foreach ($userId as $id) {

                        $idUser = preg_replace("/[^0-9]/", "", $id);
                        $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);

                        foreach ($this->resultSmartMonth['result'] as $resMonthSmartItem) {

                            if((int)$userIdNumber === (int)$resMonthSmartItem['ufCrm' . $this->resultSmartMonth['idNumber'] . 'IdUserCalendarSmb'] && $this->resultUsersTimeman[$id]['STATUS'] === 'CLOSED' && !empty($this->resultUsersTimeman[$id]['TIME_FINISH']) && strpos($this->resultUsersTimeman[$id]['DURATION'], '-') === false) {

                                $idElementsMonthsSmart = $resMonthSmartItem['id'];
                                $resultId = $this->resultUsersTimeman[$id];
                                
                                $arData = $this->getBatchDay($this->resultUsersTimeman[$id], $userIdNumber, $idElementsMonthsSmart);
    
                                if(!empty($arData)) {
                                    $batchCallQueryDays['user' . $userIdNumber] = $arData; 
                                }
                            }
                        }
                    }

                    $resulbatchNewUsersDays = $this->smartConnect->call($this->portal , $batchCallQueryDays);

                    return [$resulbatchNewUsersDays, ['success updater Smart new user']];
                }

                return ['dfgdfg'];
            }
            
            return $this->addNewUsers();
        }
            
        return ["error updater BX"];
	}

    public function getUsersBX()
	{
            
        $resultUsersBX = $this->smartConnect->getRestUsers($this->portal);
        
        if(!empty($resultUsersBX['result'])){
            $this->resultUsers = $resultUsersBX['result'];
        }

        if(count($this->resultUsers)){

            foreach ($this->resultUsers as $user) {
                $arData =  array(
                    'method' => 'timeman.status',
                    'params' => array('user_id' => $user['ID'])
                );

                $batchCallQuery['user' . ($user['ID'])] = $arData;
            }; 
            
            $resulbatchTimemanStatus = $this->smartConnect->call($this->portal, $batchCallQuery);

            if(!empty($resulbatchTimemanStatus['result']['result'])){
                $this->resultUsersTimeman = $resulbatchTimemanStatus['result']['result'];
            }
            
            if(count($this->resultUsers)){
                return $this->resultUsersTimeman;
            }
        }
            
        return ["error"=>"user bx not found"];
	}

    //Получение данных смрат-процесса Пользователи
    public function getSmartUsers()
	{
        $this->resultSmartUsers = $this->smartConnect->getSmartInfo($this->portal, 'UsersSmart');

        return $this->resultSmartUsers;
    }

    //Получение данных смрат-процесса Месяц
    public function getSmartMonth()
	{
        $this->resultSmartMonth = $this->smartConnect->getSmartInfo($this->portal, 'MonthSmart');

        if(!empty($this->resultSmartMonth)){

            return $this->resultSmartMonth;
        }

        return ["error"=>"smart Users bx not found"];
    }

    //Получение данных смрат-процесса Дни
    public function getSmartDays()
	{
        $this->resultSmartDays = $this->smartConnect->getSmartInfo($this->portal, 'DaysSmart');

        if(!empty($this->resultSmartDays)){
           
            return $this->resultSmartDays;
        }

        return ["error"=>"smart Users bx not found"];
    }

    // Сравнение пользователей Битрикс и пользователей в смарт-процессе Пользователи
    public function comparetUsers($bool1, $bool2)
	{
        $fieldIdUsersSmart = 'ufCrm' . $this->resultSmartUsers['idNumber'] . 'IdUserCalendarSmb'; 

        $userId = array_keys($this->resultUsersTimeman);
        $smartUsers = $this->resultSmartUsers;

        $resultUsers = array_filter($userId, function($user_id) use ($smartUsers, $fieldIdUsersSmart, $bool1, $bool2) {
            $userIdNumber = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);

            foreach ($this->resultSmartUsers['result'] as $user) {
            
                $userIdSmart = $user[$fieldIdUsersSmart];

                if(intval($userIdNumber) === $userIdSmart) {
                    return (bool) $bool1;
                }
            }

            return (bool) $bool2;
        });

        return $resultUsers;
    }

    //Добавление новых пользователей в смарт-процессы
    public function addNewUsers() {
        
        $resultAddItemSmartUsers = $this->addItemSmartUsers();

        if(!empty($resultAddItemSmartUsers['result']['result'])) {

            $this->resulBatchNewSmartUsers = $resultAddItemSmartUsers['result']['result'];

            $resultAddItemSmartMonth = $this->addItemSmartMonth();

            if(!empty($resultAddItemSmartMonth['result']['result'])) {

                $this->resulBatchNewSmartMonth = $resultAddItemSmartMonth['result']['result'];

                return $this->addItemSmartDays();
            }
            
        }
        
        return "error -> don't add new users";
    }

    //Добавление новых пользователей в смарт-процесс Пользователи
    public function addItemSmartUsers() {
        
        foreach ($this->resultUsers as $user) {

            if(!empty($this->resultNewUsers)) {

                foreach ($this->resultNewUsers as $newUser) {
                
                    $idNewUser = preg_replace("/[^0-9]/", "", $newUser);
        
                    if($idNewUser === $user['ID']) {

                        $batchUsers = $this->getBatchUsers($user);

                        if(!empty($batchUsers)) {
                            $batchCallQueryUsers[$user['ID']] = $batchUsers; 
                        }
                    }
                }
            }

            $batchUsers = $this->getBatchUsers($user);

            if(!empty($batchUsers)) {
                $batchCallQueryUsers[$user['ID']] = $batchUsers; 
            }
        }
        
        $resulbatchNewUsers = $this->smartConnect->call($this->portal, $batchCallQueryUsers);
        
        return $resulbatchNewUsers; 
    }

    //Добавление новых пользователей в смарт-процесс Месяц
    public function addItemSmartMonth() {
  
        $userId = array_keys($this->resultUsersTimeman);

        foreach ($userId as $id) {

            $idUser = preg_replace("/[^0-9]/", "", $id);
            $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);

            if(!empty($this->resultNewUsers)) {

                foreach ($this->resultNewUsers as $newUser) {
        
                    $idNewUser = preg_replace("/[^0-9]/", "", $newUser);
    
                    if($idNewUser === $userIdNumber && $this->resultUsersTimeman[$id]['STATUS'] === 'CLOSED' && !empty($this->resultUsersTimeman[$id]['TIME_FINISH']) && strpos($this->resultUsersTimeman[$id]['DURATION'], '-') === false) {
    
                        $idElementsUsersSmart = $this->resulBatchNewSmartUsers[$id]['item']['id'];
                        
                        $arData = $this->getBatchMonth($this->resultUsersTimeman[$id], $idNewUser, $idElementsUsersSmart);
                        
                        if(!empty($arData)) {
                            $batchCallQueryMonths['user' . $idNewUser] = $arData;
                        }
                        
                    }  
                } 
            }

            foreach ($this->resultUsers as $user) {

                if((int)$user['ID'] === (int)$userIdNumber && $this->resultUsersTimeman[$id]['STATUS'] === 'CLOSED' && !empty($this->resultUsersTimeman[$id]['TIME_FINISH']) && strpos($this->resultUsersTimeman[$id]['DURATION'], '-') === false) {
    
                    $idElementsUsersSmart = $this->resulBatchNewSmartUsers[$userIdNumber]['item']['id'];
                    
                    $arData = $this->getBatchMonth($this->resultUsersTimeman[$id], $user['ID'], $idElementsUsersSmart);
                    
                    if(!empty($arData)) {
                        $batchCallQueryMonths['user' . $user['ID']] = $arData;
                    }       
                }  
            } 
        }
        
        $resulbatchNewUsersMonth = $this->smartConnect->call($this->portal , $batchCallQueryMonths);

        return $resulbatchNewUsersMonth;
    }

    //Добавление новых пользователей в смарт-процесс День
    public function addItemSmartDays() {

        $userId = array_keys($this->resultUsersTimeman);

        foreach ($userId as $id) {

            $idUser = preg_replace("/[^0-9]/", "", $id);
            $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);

            if(!empty($this->resultNewUsers)) {

                foreach ($this->resultNewUsers as $newUser) {
                    
                    $idNewUser = preg_replace("/[^0-9]/", "", $newUser);
                
                    if($idNewUser === $userIdNumber && $this->resultUsersTimeman[$id]['STATUS'] === 'CLOSED' && !empty($this->resultUsersTimeman[$id]['TIME_FINISH']) && strpos($this->resultUsersTimeman[$id]['DURATION'], '-') === false) {
                        
                        $idElementsMonthsSmart = $this->resulBatchNewSmartMonth[$id]['item']['id'];
                        $resultId = $this->resultUsersTimeman[$id];
                        
                        $arData = $this->getBatchDay($this->resultUsersTimeman[$id], $idNewUser, $idElementsMonthsSmart);
    
                        if(!empty($arData)) {
                            $batchCallQueryDays['user' . $idNewUser] = $arData; 
                        }
                    }  
                } 
            }

            if($this->resultUsersTimeman[$id]['STATUS'] === 'CLOSED' && !empty($this->resultUsersTimeman[$id]['TIME_FINISH']) && strpos($this->resultUsersTimeman[$id]['DURATION'], '-') === false) {
                    
                $idElementsMonthsSmart = $this->resulBatchNewSmartMonth[$id]['item']['id'];
                $resultId = $this->resultUsersTimeman[$id];
                
                $arData = $this->getBatchDay($this->resultUsersTimeman[$id], $userIdNumber, $idElementsMonthsSmart);

                if(!empty($arData)) {
                    $batchCallQueryDays['user' . $userIdNumber] = $arData; 
                }
            }    
        }
    
        $resulbatchNewUsersDays = $this->smartConnect->call($this->portal , $batchCallQueryDays);

        return [$resulbatchNewUsersDays, ['success updater Smart new user']];
    }

    //Обновление пользователей уже добавленных в смарт-процессы
    public function addAddUsers() {

        $resultUpdater = $this->comparetUsersData();
        
        if(!empty($resultUpdater)) {

            return $resultUpdater;
        }

        return ["error -> don't updater add users"];
    }

    //Сравнение данных пользователей уже добавленных
    public function comparetUsersData() {

        $userId = array_keys($this->resultUsersTimeman);
        $idMaxUsers = [];
        $resAddItemDay = [];
        $addDataOnlyDay = [];
        $addDataMonthDay = [];
        $monthSmartIdMax = null;
        $smartDays = $this->resultSmartDays;
        $userTimeman = $this->resultUsersTimeman;
        $idUserNewMonth = [];

        //Если нет ни одного рабочего дня у пользователя в смарт-процессе День
        $daysNew = array_filter($userId, function($user_id) use ($smartDays, $userTimeman) {
            $userIdNumber = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);

            $timemanUserDayKey = isset($userTimeman[$user_id]['TIME_FINISH']);

            if(!empty($timemanUserDayKey)) {

                $timemanUserData = $userTimeman[$user_id]['TIME_FINISH'];

                foreach ($smartDays['result'] as $itemDay) {

                    $idUserDay = $itemDay['ufCrm' . $smartDays['idNumber'] . 'IdUserCalendarSmb'];
                    $userDataSmart = $itemDay['ufCrm' . $smartDays['idNumber'] . 'DayCalendarSmb'];
                    
                    if((int)$userIdNumber === $idUserDay) {
                        
                        return false;
                    }
                } 
                return true;
            }
        });

        foreach ($userId as $id) {

            $idUser = preg_replace("/[^0-9]/", "", $id);
            $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);     
    
            $timemanUserDayKey = isset($this->resultUsersTimeman[$id]['TIME_FINISH']);
    
            if(!empty($timemanUserDayKey)) {
               
                $timemanUserData = $this->resultUsersTimeman[$id]['TIME_FINISH'];
                $maxDayCalendarSmb = null;
                $idMax = null;
                $monthSmartIdMax = null;
                $monthMax = null;
                
                foreach ($this->resultSmartDays['result'] as $itemDay) {

                    $idUserDay = $itemDay['ufCrm' . $this->resultSmartDays['idNumber'] . 'IdUserCalendarSmb'];
                    $userDataSmart = $itemDay['ufCrm' . $this->resultSmartDays['idNumber'] . 'DayCalendarSmb'];
                    
                    if((int)$userIdNumber === $idUserDay) {
                        
                        if ($maxDayCalendarSmb === null || $userDataSmart > $maxDayCalendarSmb) {
                            $maxDayCalendarSmb = $userDataSmart;
                            $idMax = $idUserDay; 
                        }
                    }
                } 
                
                $parentIdUsersSmart = 0;

                foreach ($this->resultSmartMonth['result'] as $resMonthSmartItem) {
                
                    $idUserNewMonth[$idMax] = $id;

                    if($idMax === $resMonthSmartItem['ufCrm' . $this->resultSmartMonth['idNumber'] . 'IdUserCalendarSmb']) {
                        $month = $resMonthSmartItem['ufCrm' . $this->resultSmartMonth['idNumber'] . 'MonthCalendarSmb'];
                        
                        if ($monthMax === null || $month > $monthMax) {
                            $monthMax = $month;
                            $monthSmartIdMax = $resMonthSmartItem['id'];
                            $parentIdUsersSmart = $resMonthSmartItem['parentId' . $this->resultSmartUsers['entityIdNumber']];
                        }

                        unset($idUserNewMonth[$idMax]);

                        break;
                    }
                }

                if(!empty($maxDayCalendarSmb) && !empty($monthMax) && $timemanUserData !== $maxDayCalendarSmb) {
                    $dateString = strtotime($timemanUserData);
                    $monthNumber = date('n', $dateString);
    
                    if((int)$monthNumber === $monthMax) {
    
                        $addDataOnlyDay[$userIdNumber] = $this->resultUsersTimeman[$id];
                        $addDataOnlyDay[$userIdNumber]['monthSmartId'] = $monthSmartIdMax;
                    }

                    if((int)$monthNumber !== $monthMax) {

                        $addDataMonthDay[$userIdNumber] = $this->resultUsersTimeman[$id];
                        $addDataMonthDay[$userIdNumber]['parentIdUser'] = $parentIdUsersSmart;
                    }
                }
            }  
        } 

        $arrDataNewDay = [];

        if(!empty($daysNew)) {
            
            foreach ($daysNew as $id) {

                $idUser = preg_replace("/[^0-9]/", "", $id);
                $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);

                foreach ($this->resultSmartMonth['result'] as $resMonthSmartItem) {
                
                    if((int)$userIdNumber === (int)$resMonthSmartItem['ufCrm' . $this->resultSmartMonth['idNumber'] . 'IdUserCalendarSmb']) {
                        
                        $arrDataNewDay[$userIdNumber] = $this->resultUsersTimeman[$id];
                        $arrDataNewDay[$userIdNumber]['monthSmartId'] = $resMonthSmartItem['id'];
                    }
                }
            }
        }

        $arrDataNewMonth = [];

        //Если удалили элемент-месяц в смарт-процессе Месяц и у пользователя нет ни одного элемента-месяца
        if(!empty($idUserNewMonth)) {

            foreach ($idUserNewMonth as $id) {

                $idUser = preg_replace("/[^0-9]/", "", $id);
                $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);

                foreach ($this->resultSmartUsers['result'] as $resUserSmartItem) {
                
                    if((int)$userIdNumber === (int)$resUserSmartItem['ufCrm' . $this->resultSmartUsers['idNumber'] . 'IdUserCalendarSmb']) {
                        
                        $arrDataNewMonth[$userIdNumber] = $this->resultUsersTimeman[$id];
                        $arrDataNewMonth[$userIdNumber]['parentIdUser'] = $resUserSmartItem['id'];
                    }
                }

                // return($arrDataNewMonth);
            }

        }

        return [$this->addDataAddUsersDayMonthSmartMonth($addDataMonthDay), $this->addDataAddUsersDayMonthSmartMonth($addDataMonthDay), $this->addDataAddUsersOnlyDaySmart($arrDataNewDay), $this->addDataAddUsersDayMonthSmartMonth($arrDataNewMonth)];
    } 
    
    //Добавление элементов в смарт-процесс День (месяц одинаковый)
    public function addDataAddUsersOnlyDaySmart($arrData) {

        if(!empty($arrData)) {
            $userId = array_keys($arrData);

            $batchDaySmart = $this->sendBatchSmartDay($arrData);
    
            if(!empty($batchDaySmart )) { 
    
                $batchKey = array_keys($batchDaySmart);
                
                foreach($batchKey as $item) {
    
                    $idUser = preg_replace("/[^0-9]/", "", $item);
                    $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);     
    
                    foreach ($userId as $id) {
                        
                        if((int)$userIdNumber === $id) {
                            
                            $arrData[$id]['daySmartId'] = $batchDaySmart[$item]['item']['id'];
                        }
                    }  
                }
                
                return $this->addDataAddUsersOnlyDaySmartMonth($arrData);
            }
    
            return ['error -> not updater new Day and Month Smarts'];
        }

        return ['not data to updater smart']; 
    }

    //Обновление данных (месяц одинаковый) в смарт-процесс Месяц
    public function addDataAddUsersOnlyDaySmartMonth($arrData) {

        if(!empty($arrData)) {

            foreach ($this->resultSmartMonth['result'] as $itemsMonthSmart) {

                $userId = array_keys($arrData);
            
                foreach ($userId as $id) {

                    if($arrData[$id]['monthSmartId'] === $itemsMonthSmart['id']) {
                    
                        $itemsMonthSmartDuration = $itemsMonthSmart['ufCrm' . $this->resultSmartMonth['idNumber'] . 'TimeMonthCalendarSmb'];
                        
                        $duration = $arrData[$id]['DURATION'];
                        $itemsMonthSmartDuration_seconds = strtotime($itemsMonthSmartDuration);
                        $duration_seconds = strtotime($duration);
                        $total_seconds = $itemsMonthSmartDuration_seconds + $duration_seconds;
                        $total_time = date("H:i:s", $total_seconds);
        
                        $itemsMonthSmartDay = $itemsMonthSmart['ufCrm' . $this->resultSmartMonth['idNumber'] . 'DayMonthCalendarSmb'];
                        $itemsMonthDay = $itemsMonthSmartDay + 1;
                        
                        $itemDay = $arrData[$id]['daySmartId'];

                        $arDataMonth =  array(
                            'method' => 'crm.item.update',
                            'params' => array(
                                'entityTypeId' => $this->resultSmartMonth['entityIdNumber'],
                                'id' => $itemsMonthSmart['id'],
                                'fields' => array(
                                    'ufCrm' . $this->resultSmartMonth['idNumber'] . 'TimeMonthCalendarSmb' => $total_time,
                                    'ufCrm' . $this->resultSmartMonth['idNumber'] . 'DayMonthCalendarSmb' => $itemsMonthDay,
                                    'parentId' . $this->resultSmartDays['entityIdNumber'] => $itemDay,
                                )
                            )
                        );       
        
                        $batchCallQueryMonthAdd['userMonth'] = $arDataMonth; 
                    }
                }
            }

            $resulbatchAddUsersMonth = $this->smartConnect->call($this->portal , $batchCallQueryMonthAdd);

            if(!empty($resulbatchAddUsersMonth)) {
                
                return $resulbatchAddUsersMonth;
            }
            
            return ['error-> not updater Month Smart'];
        }

        return ['not data to updater smart']; 
    }
    
    //Добавление данных в смарт-процесс Месяц
    public function addDataAddUsersDayMonthSmartMonth($arrData) {
        
        if(!empty($arrData)) {

            $userId = array_keys($arrData);

            foreach ($userId as $id) {

                $arData = $this->getBatchMonth($arrData[$id], $id, $arrData[$id]['parentIdUser']);

                if(!empty($arData)) {
                    $batchCallQueryMonthsAdd[$id] = $arData;
                }
            }

            $resulbatchAddUsersMonth = $this->smartConnect->call($this->portal , $batchCallQueryMonthsAdd);

            $batch = $resulbatchAddUsersMonth['result']['result'];

            if(!empty($batch)) {

                $batchKey = array_keys($batch);
                
                foreach($batchKey as $item) {

                    $idUser = preg_replace("/[^0-9]/", "", $item);
                    $userIdNumber = filter_var($idUser, FILTER_SANITIZE_NUMBER_INT);     

                    foreach ($userId as $id) {
                        
                        if((int)$userIdNumber === $id) {
                            
                            $arrData[$id]['monthSmartId'] = $batch[$item]['item']['id'];
                        }
                    }  
                }
                
                return $this->sendBatchSmartDay($arrData);
            }

            return ['error -> not updater add Day and Month Smarts'];
        }

        return ['not data to updater smart']; 
    }

    //Получение батч-запроса для смарт-процесса Месяц
    public function getBatchMonth($arr, $idUser, $idParentSmart) {

        $dataFinish = $arr['TIME_FINISH'];
        $duration = $arr['DURATION'];      
        $dateString = strtotime($dataFinish);
        $month = $this->month_list_month[date('n', $dateString) - 1] . ' ' . date('Y', $dateString);
        $monthNumber = date('n', $dateString);
        
        $arDataMonth =  array(
            'method' => 'crm.item.add',
            'params' => array(
                'entityTypeId' => $this->resultSmartMonth['entityIdNumber'],
                'fields' => array(
                    'title' => $month,
                    'ufCrm' . $this->resultSmartMonth['idNumber'] . 'TimeMonthCalendarSmb' => $duration,
                    'ufCrm' . $this->resultSmartMonth['idNumber'] . 'DayMonthCalendarSmb' => '1',
                    'ufCrm' . $this->resultSmartMonth['idNumber'] . 'IdUserCalendarSmb' => $idUser,
                    'ufCrm' . $this->resultSmartMonth['idNumber'] . 'MonthCalendarSmb' => $monthNumber,
                    'parentId' . $this->resultSmartUsers['entityIdNumber'] => $idParentSmart,
                )
            )
        );

        return $arDataMonth; 
    }

    //Получение батч-запроса для смарт-процесса День
    public function getBatchDay($arr, $idUser, $idParentSmart) {

        $dataFinish = $arr['TIME_FINISH'];
        $duration = $arr['DURATION'];
        $leaks = $arr['TIME_LEAKS'];          
        $dateString = strtotime($dataFinish);
        $day = date('d', $dateString) . ' ' . $this->month_list_day[date('n', $dateString) - 1] . ' ' . date('Y', $dateString) . ' г.';
        
        $arDataDay =  array(
            'method' => 'crm.item.add',
            'params' => array(
                'entityTypeId' => $this->resultSmartDays['entityIdNumber'],
                'fields' => array(
                    'title' => $day,
                    'ufCrm' . $this->resultSmartDays['idNumber'] . 'DayCalendarSmb' => $dataFinish,
                    'ufCrm' . $this->resultSmartDays['idNumber'] . 'DayDurationCalendarSmb' => $duration,
                    'ufCrm' . $this->resultSmartDays['idNumber'] . 'DayLeaksCalendarSmb' => $leaks,
                    'ufCrm' . $this->resultSmartDays['idNumber'] . 'IdUserCalendarSmb' => $idUser,
                    'parentId' . $this->resultSmartMonth['entityIdNumber'] => $idParentSmart,
                )
            )
        );

        return $arDataDay; 
    }

    //Добавление данных в смарт-процесс День
    public function sendBatchSmartDay($arr) {

        $userId = array_keys($arr);

        foreach ($userId as $id) {
         
            $batchDay = $this->getBatchDay($arr[$id], $id, $arr[$id]['monthSmartId']);

            if(!empty($batchDay)) {
                $batchCallQuery[$id] = $batchDay; 
            }
            
        }

        $resulbatch = $this->smartConnect->call($this->portal , $batchCallQuery);

        $batch = $resulbatch['result']['result'];

        return $batch;
    }

    //Получение батч-запроса для смарт-процесса Пользователи
    public function getBatchUsers($arr) {

        $secondName = !empty($arr['SECOND_NAME']) ? $arr['SECOND_NAME'] : 'не задано';
                        
        $arDataUsers =  array(
            'method' => 'crm.item.add',
            'params' => array(
                'entityTypeId' => $this->resultSmartUsers['entityIdNumber'],
                'fields' => array(
                    'title' => $arr['LAST_NAME'] . ' ' . $arr['NAME'] . ' ' . $secondName,
                    'ufCrm' . $this->resultSmartUsers['idNumber'] . 'IdUserCalendarSmb' => $arr['ID'],
                    'ufCrm' . $this->resultSmartUsers['idNumber'] . 'LastNameCalendarSmb' => $arr['LAST_NAME'],
                    'ufCrm' . $this->resultSmartUsers['idNumber'] . 'NameCalendarSmb' => $arr['NAME'],
                    'ufCrm' . $this->resultSmartUsers['idNumber'] . 'SecondNameCalendarSmb' => $secondName,
                )
            )
        );

        return $arDataUsers; 
    }
}