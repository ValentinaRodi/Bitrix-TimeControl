<?php
/**
 * Class SecEnv
 * 
 * Класс SecEnv предназначен для загрузки значений из файла конфигурации в переменные окружения и их доступа через массив $_ENV.
 */
namespace lib;

class SecEnv {
    /**
     * Конструктор класса SecEnv.
     * Загружает значения из файла конфигурации в переменные окружения.
     */
    public function __construct() {
        $configFilePath = '/var/www/smb_smartbiz_usr46/data/www/education.smartbiznes-bitrix.ru/timecontrol/utils/config.php';
        $config = include($configFilePath);
        
        $this->loadToEnvironment($config);
        
    }

    /**
     * Загружает значения из конфигурации в переменные окружения.
     * 
     * @param array $config Массив конфигурационных значений.
     * @param string $prefix Префикс для переменных окружения.
     */
    private function loadToEnvironment($config, $prefix = '') {
        foreach ($config as $key => $value) {
            if (is_array($value)) {
                $this->loadToEnvironment($value, $prefix . $key . '_');
                continue;
            }
            //putenv($prefix . $key . '=' . $value);  // Установка значения переменной окружения
            $_ENV["$prefix$key"] =$value;  // Установка значения переменной окружения
        }
        
    }

    /**
     * Получает значение переменной окружения из массива $_ENV.
     * 
     * @param string $key Ключ переменной окружения (включая префикс, если есть).
     * @return mixed Значение переменной окружения.
     */
    public static function getEnvironmentValue($key) {
        $keys = explode(':', $key);
        $value = $_ENV;
        foreach ($keys as $key) {
            if (isset($value[$key])) {
                $value = $value[$key];
            } else {
                $value = null;
                break;
            }
        }
        return $value;
    }
}