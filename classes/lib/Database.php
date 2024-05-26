<?
namespace lib;

class Database 
{
    private $result;
    private $DBO;
    private static $data;
    private static $instance;
    
	public function __construct()
    {
        $dbConfig = [
            'mysql:host' => [
                'ip' => 'localhost',
                'port' => '3306'
            ],
            'dbname' => 'education_sm',
            'charset' => 'utf8mb4',
            'login' => 'education_sm',
            'pwd' => 'scnSIPIDw1yCWLCG'
        ];

        $this->result=[];
        $this->DBO = new \PDO(
            "mysql:host={$dbConfig['mysql:host']['ip']}:{$dbConfig['mysql:host']['port']};dbname={$dbConfig['dbname']};charset={$dbConfig['charset']}",
            $dbConfig['login'],
            $dbConfig['pwd']
        );
    }

    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function logError($message, $query, $data = [])
    {
        // Добавляем информацию о текущем времени
        $logMessage = "--------------------------------------------\n";
        $logMessage .= "[" . date('Y-m-d H:i:s') . "]\n";
        $logMessage .= "Error: $message.\n Query: $query.\n Data: " . print_r($data, true) . "\n";
        $logMessage .= "--------------------------------------------\n";

        // Записываем лог в файл
        $logFile = $_SERVER["DOCUMENT_ROOT"] . '"/timecontrol/log/logDB.txt';
        file_put_contents($logFile, $logMessage . "\n", FILE_APPEND);
    }

    public function speedLoading($start, $end)
    {
        //$start = microtime(true);
        //$end = microtime(true);
        //echo $database->speedLoading($start,$end);
        $executionTime = $end - $start;
        // Форматирование времени выполнения в секундах и миллисекундах
        $executionTimeInSeconds = floor($executionTime);
        $executionTimeInMilliseconds = round(($executionTime - $executionTimeInSeconds) * 1000);
        $time = $executionTimeInSeconds . "." . $executionTimeInMilliseconds . " сек";
        return $time;
    }

    public function insertLastID(string $query, array $data = [])
    {
        $checkWords = $this->checkWords('INSERT', $query, $data);
        if (!empty($checkWords['error'])) {
            return $checkWords;
        }
        if (count($data)) {
            try {
                $statement = $this->DBO->prepare($query);
                $statement->execute($data);
                //$this->logError("Error:\n Query: $query.\n Data: " . print_r($data, true) . "\n", $query, $data);
                return $this->DBO->lastInsertId();
            } catch (\PDOException $e) {
                // Обработка ошибки
                $this->logError($e->getMessage(), $query, $data);
                return ['error' => "Ошибка при выполнении запроса", "description" => $e->getMessage()];
            }
        } else {
            try {
                $statement = $this->DBO->prepare($query);
                $statement->execute();
                return $this->DBO->lastInsertId();
            } catch (\PDOException $e) {
                // Обработка ошибки
                $this->logError($e->getMessage(), $query);
                return ['error' => "Ошибка при выполнении запроса", "description" => $e->getMessage()];
            }
        }

    }

    public function insert(string $query, array $data = [])
    {
        $checkWords = $this->checkWords('INSERT', $query, $data);
        if (!empty($checkWords['error'])) {
            return $checkWords;
        }
        if (count($data)) {
            try {
                $statement = $this->DBO->prepare($query);
                $statement->execute($data);
                //$this->logError("Error:\n Query: $query.\n Data: " . print_r($data, true) . "\n", $query, $data);
                return ['result' => true];
            } catch (\PDOException $e) {
                // Обработка ошибки
                $this->logError($e->getMessage(), $query, $data);
                return ['error' => "Ошибка при выполнении запроса", "description" => $e->getMessage()];
            }
        } else {
            try {
                $statement = $this->DBO->prepare($query);
                $statement->execute();
                return ['result' => true];
            } catch (\PDOException $e) {
                // Обработка ошибки
                $this->logError($e->getMessage(), $query);
                return ['error' => "Ошибка при выполнении запроса", "description" => $e->getMessage()];
            }
        }

    }

    public function update(string $query, array $data = [])
    {
        $checkWords = $this->checkWords('UPDATE', $query, $data);
        if (!empty($checkWords['error'])) {
            return $checkWords;
        }
        if (count($data)) {
            try {
                $statement = $this->DBO->prepare($query);
                $statement->execute($data);
                //$this->logError("Error:\n Query: $query.\n Data: " . print_r($data, true) . "\n", $query, $data);
                return ['result' => true];
            } catch (\PDOException $e) {
                // Обработка ошибки
                $this->logError($e->getMessage(), $query, $data);
                return ['error' => "Ошибка при выполнении запроса", "description" => $e->getMessage()];
            }
        } else {
            try {
                $statement = $this->DBO->prepare($query);
                $statement->execute();
                return ['result' => true];
            } catch (\PDOException $e) {
                // Обработка ошибки
                $this->logError($e->getMessage(), $query);
                return ['error' => "Ошибка при выполнении запроса", "description" => $e->getMessage()];
            }
        }

    }

    public function delete(string $query, array $data = [])
    {
        $checkWords = $this->checkWords('DELETE', $query, $data);
        if (!empty($checkWords['error'])) {
            return $checkWords;
        }
        if (count($data)) {
            try {
                $statement = $this->DBO->prepare($query);
                $statement->execute($data);
                //$this->logError("Error:\n Query: $query.\n Data: " . print_r($data, true) . "\n", $query, $data);
                return ['result' => true];
            } catch (\PDOException $e) {
                // Обработка ошибки
                $this->logError($e->getMessage(), $query, $data);
                return ['error' => "Ошибка при выполнении запроса", "description" => $e->getMessage()];
            }
        } else {
            try {
                $statement = $this->DBO->prepare($query);
                $statement->execute();
                return ['result' => true];
            } catch (\PDOException $e) {
                // Обработка ошибки
                $this->logError($e->getMessage(), $query);
                return ['error' => "Ошибка при выполнении запроса", "description" => $e->getMessage()];
            }
        }

    }

    /**
     * Функция для запроса в БД  SELECT
     * @param string $query  запрос к БД
     * @param array $data  параметры запроса
     * @return array Возвращает данные для ответа на запрос
     */

    public function select(string $query, array $data = [])
    {
        $checkWords = $this->checkWords('SELECT', $query, $data);
        if (!empty($checkWords['error'])) {
            return $checkWords;
        }
        if (count($data)) {
            try {
                $statement = $this->DBO->prepare($query);
                $statement->execute($data);
                //$this->logError("Error:\n Query: $query.\n Data: " . print_r($data, true) . "\n", $query, $data);
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                // Обработка ошибки
                $this->logError($e->getMessage(), $query, $data);
                return ['error' => "Ошибка при выполнении запроса", "description" => $e->getMessage()];
            }
        } else {
            try {
                $statement = $this->DBO->prepare($query);
                $statement->execute();
                return $statement->fetchAll(\PDO::FETCH_ASSOC);
            } catch (\PDOException $e) {
                // Обработка ошибки
                $this->logError($e->getMessage(), $query);
                return ['error' => "Ошибка при выполнении запроса", "description" => $e->getMessage()];
            }
        }

    }
    
    private function checkWords(string $typeQvery, string $query, array $data = [])
    {
        // Массив запрещенных слов
        $forbiddenWords = $this->getForbiddenWords($typeQvery);

        // Проверяем наличие запрещенных слов в запросе
        foreach ($forbiddenWords as $word) {
            if (stripos($query, $word) !== false) {
                // Обнаружено запрещенное слово в данных
                return ['error' => "Обнаружено запрещенное слово в запросе: $word"];
            }
        }
        if (count($data)) {
            foreach ($forbiddenWords as $word) {
                foreach ($data as $value) {
                    if (!empty($value) && stripos($value, $word) !== false) {
                        // Обнаружено запрещенное слово в данных
                        return ['error' => "Обнаружено запрещенное слово в данных: $word"];
                    }
                }
            }
        }

        return ['result' => true];

    }

    private function getForbiddenWords($queryType)
    {
        $forbiddenWords = [];

        // Проверяем тип запроса и возвращаем соответствующий список запрещенных слов
        switch ($queryType) {
            case 'SELECT':
                $forbiddenWords = ['DROP', 'TRUNCATE', 'DELETE', 'UPDATE', 'INSERT'];
                break;
            case 'UPDATE':
                $forbiddenWords = ['DROP', 'TRUNCATE', 'DELETE', 'INSERT', 'SELECT'];
                break;
            case 'INSERT':
                $forbiddenWords = ['DROP', 'TRUNCATE', 'DELETE', 'SELECT'];
                break;
            case 'DELETE':
                $forbiddenWords = ['DROP', 'TRUNCATE', 'UPDATE', 'INSERT', 'SELECT'];
                break;
            default:
                $forbiddenWords = ['DROP', 'TRUNCATE', 'DELETE', 'UPDATE', 'INSERT', 'SELECT'];
                break;
        }

        return $forbiddenWords;
    }
}
