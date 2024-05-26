<?php
  
  require_once("/var/www/smb_smartbiz_usr46/data/www/education.smartbiznes-bitrix.ru/timecontrol/utils/ClassLoaderApp.php");
  
  $standartLoaderClassesFromFolder = new ClassLoaderApp();
  $standartLoaderClassesFromFolder->loadClasses();

  call_user_func(function () {
    new \lib\SecEnv();
  });

?>