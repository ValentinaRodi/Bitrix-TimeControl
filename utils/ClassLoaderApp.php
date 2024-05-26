<?php
class ClassLoaderApp
{
    protected array $autoloadClassesInfo = [];
    protected array $classFolder = [];
    protected string $dirRootClasses = "/var/www/smb_smartbiz_usr46/data/www/education.smartbiznes-bitrix.ru/timecontrol/classes/";

    /**
     * Загружает и регистрирует классы из указанных директорий.
     */
    public function loadClasses(): void
    {
        $classesDirInfo = [];

        // Сканируем корневую директорию на наличие директорий классов
        foreach (scandir($this->dirRootClasses) as $classDirInfo) {
            if (!empty($classDirInfo) && $classDirInfo !== '.' && $classDirInfo !== '..' && !str_contains($classDirInfo, 'php')) {
                $classesDirInfo[$classDirInfo] = $this->dirRootClasses . $classDirInfo . "/";
                $this->classFolder[] = $classDirInfo;
            }
        }

        // Перебираем директории и регистрируем автозагрузку классов
        foreach ($classesDirInfo as $classesDir) {
            // Регистрируем функцию автозагрузки для классов в текущей директории
            spl_autoload_register(function ($className) use ($classesDir) {
                if (strpos($className, '\\') === false) {
                    $filePath = $classesDir . $className . '.php';
                    if (file_exists($filePath)) {
                        require_once($filePath);
                    }
                }
            });

            // Подключаем все файлы в директории (на случай, если они не были автоматически загружены)
            foreach (scandir($classesDir) as $file) {
                if ($file !== '.' && $file !== '..') {
                    require_once($classesDir . $file);
                }
            }
        }

        // Собираем информацию о загруженных классах из каждой директории
        foreach (get_declared_classes() as $class) {
            foreach ($this->classFolder as $dirKey) {
                if (str_contains($class, $dirKey)) {
                    $this->autoloadClassesInfo[$dirKey][] = $class;
                }
            }
        }
    }

    /**
     * Получает информацию о загруженных классах.
     *
     * @return array Информация о загруженных классах.
     */
    public function getLoadedClasses(): array
    {
        return $this->autoloadClassesInfo;
    }
}
?>