<?php
header('Access-Control-Allow-Origin: *');
require_once ('template/header.php');
################################################################################################################################
#                                                                                                                              #
#           1. дать папке local права на чтение и запись                                                                       #
#                                                                                                                              #
#           2. если выходит ошибка в консоли "The resource from                                                                #
#              “https://exemple.ru/local/application/activity_bp/app.php?DOMAIN=bitrix.pprol                                   #
#              .ru&PROTOCOL=1&LANG=ru&APP_SID=3aa47a268890f0ecb4eab989f7f3fdc8/local/application/activity_bp/                  #
#              js/functions.js” was blocked due to MIME type (“text/html”) mismatch (X-Content-Type-Options: nosniff)"         #
#                                                                                                                              #
#     Нужно закоментировать в файле etc/nginx/bx/conf/http-add_header.conf строку #add_header X-Frame-Options SAMEORIGIN;      #
#                                                                                                                              #
################################################################################################################################

?>

<div class="container">
    <div class="alert alert-success" role="alert">
        <h4 class="alert-heading">Устанавливаем приложение</h4>
        <p>Пожалуста подождите...</p>
        <hr>
        <p class="mb-0">
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="25" aria-valuemin="0"
                aria-valuemax="100">30%</div>
        </div>
        </p>
    </div>
</div>



<script>
BX24.init(function() {
    BX24.callMethod(
        'app.info', {},
        function(result) {
            if (result.answer.result.INSTALLED == false) {
                //console.dir(result.answer.result.INSTALLED);
                BX24.installFinish();
                if(result.answer.result.INSTALLED){
                    console.dir('Приложение установлено. Ок.');
                }
            }
        }
    );
	
});
</script>

<style>
   .container {
        /* т.к css может не подгрузиться */
        height: 100vh;
        padding-top: 40vh;
    }
</style>
<script>
function counter(ms, className) {
    let counter = 50;
    let interval = setInterval(() => {
        document.querySelector(className).innerHTML = ++counter + '%';
        document.querySelector(className).style.width = counter + "%";
        counter === 100 ? clearInterval(interval) : false;
    }, ms)
}
counter(30, '.progress-bar');
</script>