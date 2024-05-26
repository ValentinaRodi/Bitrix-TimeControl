<?
require_once('template/header.php');
$domen = $_REQUEST['DOMAIN'];



?>

<!-- <p><?=$result?></p> -->

<script src="https://cdn.tailwindcss.com"></script>

<style>
  body {
    height: 100%;
  }
  .checked {
    color: #fa8181;
    background-color: #fff;
    border-color: #9ca3af #9ca3af #fff;
    cursor: default;
  }

  .close {
    background:
      linear-gradient(45deg, transparent calc(50% - 5px), #fa8181 calc(50% - 5px), #fa8181 calc(50% + 5px), transparent calc(50% + 5px)),
      linear-gradient(-45deg, transparent calc(50% - 5px), #fa8181 calc(50% - 5px), #fa8181 calc(50% + 5px), transparent calc(50% + 5px));
  }
</style>

<div id='app' class='pt-2 w-full h-full flex'>
  <div class='left w-[30%] border-r-8 border-solid border-gray-400'>
    <div id='instMenu'>
      <div class='w-32 h-32 rounded-full border-[10px] border-solid border-[#fa8181] mt-10 mx-auto mb-28'></div>
      <h2 class='text-[#fa8181] text-center text-2xl font-bold'>Установка</h2>
    </div>
    <div id='manualMenu' class='hidden '>
      <div class='w-32 h-32 border-[10px] border-solid border-[#fa8181] mt-10 mx-auto mb-28'></div>
      <h2 class='text-[#fa8181] text-center text-2xl font-bold'>Инструкция</h2>
    </div>
  </div>
  <div class='right w-[70%] relative overflow-hidden'>
    <div class="container">
      <div class="flex flex-col ml-4">
        <div class="tab-nav flex border-b-2 border-solid border-[#9ca3af] mb-4 order-[-1]">
          <button onclick='showInst()' id='instTab'
            class='checked block text-black py-2 px-4 no-underline border-solid border-2 border-transparent no-underline mb-[-3px] rounded-t-md'>Установка</button>
          <button onclick='showManual()' id='manualTab'
            class='block text-black py-2 px-4 no-underline border-solid border-2 border-transparent no-underline mb-[-3px] rounded-t-md'>Инструкция</button>
        </div>
          
          <div id="instContent" style=''  class='pr-4 overflow-y-auto'>
            <p class='text-base mb-2 indent-6 text-justify'>Приложение "Учет рабочего времени" представляет собой удобный инструмент для
              отслеживания рабочего времени сотрудников. Оно позволяет вести учет времени работы. Приложение создает три
              смарт-процесса: "Пользователи", "Месяц", "День", с взаимными связями между собой. Приложение "Учет рабочего
              времени" предоставляет надежный и удобный способ управления и отслеживания рабочего времени сотрудников, что
              позволяет повысить эффективность работы и оптимизировать распределение ресурсов в организации</p>
            <p class='text-base mb-2 text-justify'>1. Смарт-процесс "Пользователи": здесь создаются профили сотрудников с указанием их
              фамилии, имени, отчества. Каждый профиль имеет уникальный идентификатор, который позволяет легко отслеживать и
              управлять рабочим временем конкретного сотрудника.</p>
            <p class='text-base mb-2 text-justify'>2. Смарт-процесс "Месяц": здесь автоматически рассчитывается и сохраняется суммарная
              продолжительность рабочего времени, суммарная продолжительность перерывов для каждого сотрудника на
              определенный месяц.</p>
            <p class='text-base mb-2 text-justify'>3. Смарт-процесс "День": здесь сохраняется рабочее время и продолжительность перерыва
              для каждого сотрудника на определенный день.</p>
            <p class='text-base mb-6 indent-6 text-justify'>Информация о рабочем времени может быть сохранена и выгружена в сторонние приложения или
              форматах. Приложение "Учет рабочего времени" предоставляет надежный и удобный способ отслеживания рабочего
              времени сотрудников, что позволяет повысить эффективность работы и оптимизировать распределение ресурсов в
              организации.</p>
            <div class='w-full'>
              <p class='text-base text-red-600 mb-2'>Выберите часовой пояс вашего портала. Это необходимо для корректной работы приложения</p>
              <div class='flex gap-8 items-end'>
                <p class='text-xl'>Ваше время: <span id='time' class='font-bold text-2xl'></span></p>
                <div>
                  <label class='text-xl' for="gmt">Часовой пояс портала: </label>
                  <select onChange="selectGmt(this)" name="gmt"
                    class='w-36 border border-solid border-black font-bold text-2xl'>
                    <option value={gmtUser} id='gmt' class='font-bold'></option>
                    <option value="-12">-12:00</option>
                    <option value="-11">-11:00</option>
                    <option value="-10">-10:00</option>
                    <option value="-09">-09:00</option>
                    <option value="-08">-08:00</option>
                    <option value="-07">-07:00</option>
                    <option value="-06">-06:00</option>
                    <option value="-05">-05:00</option>
                    <option value="-04">-04:00</option>
                    <option value="-03">-03:00</option>
                    <option value="-02">-02:00</option>
                    <option value="-01">-01:00</option>
                    <option value="00"> 00:00</option>
                    <option value="+01">+01:00</option>
                    <option value="+02">+02:00</option>
                    <option value="+03">+03:00</option>
                    <option value="+04">+04:00</option>
                    <option value="+05">+05:00</option>
                    <option value="+06">+06:00</option>
                    <option value="+07">+07:00</option>
                    <option value="+08">+08:00</option>
                    <option value="+09">+09:00</option>
                    <option value="+10">+10:00</option>
                    <option value="+11">+11:00</option>
                    <option value="+12">+12:00</option>
                    <option value="+13">+13:00</option>
                    <option value="+14">+14:00</option>
                  </select>
                </div>
                <button onclick='changeGmtPortal()' id='changeBtn' class='hidden block w-48 text-white h-12 rounded-lg bg-[#fa8181] border-solid border-2 border-[#fa8181] hover:border-black text-[#535c69] text-xl'>Обновить</button>
              </div>
              <div id='instBtn' class='mt-10 w-full'>
                <button onclick='installApp()' 
                  class='w-52 mx-auto block text-white h-16 rounded-lg shadow-[0px_5px_10px_2px_rgba(34,60,80,0.2)] bg-[#fa8181] border-solid border-2 border-[#fa8181] hover:border-black text-[#535c69] text-xl'>Установить</button> 
              </div>
              <div id='delBtn' class='mt-10 w-full'>
                <div class='w-full flex justify-center'>
                  <p class='text-xl font-bold mb-2'>Удалить приложение?</p>
                </div>
                <button onclick='showDelPopup()'
                    class='w-52 mb-4 mx-auto block text-white h-16 rounded-lg shadow-[0px_5px_10px_2px_rgba(34,60,80,0.2)] bg-[#fa8181] border-solid border-2 border-[#fa8181] hover:border-black text-[#535c69] text-xl'>Удалить</button>
                </div>
            </div>
            <div id='infoInst' class='mt-2 hidden w-full flex justify-center'>
              <p class='text-red-600'>Дождитесь окна с уведомлением об успешном выполнении!</p>
            </div>
          </div>
          <div id="manualContent" style='' class="pr-4 hidden overflow-y-auto" >
            <div class='mr-2'>
              <?php
                require_once('template/user.get.docs.php');
              ?>
            </div>
          </div>
          
      </div>
    </div>
    <div id='popupDel' class='hidden absolute inset-x-1/3 p-4 inset-y-1/2 shadow-[0px_5px_10px_2px_rgba(34,60,80,0.2)] w-[550px] h-[250px] bg-white border-gray-400 border-solid border-2 rounded-lg'>
      <div class='w-full flex justify-end mb-4'>
        <button onclick='closePopupDel()' class='flex items-center leading-7 justify-center text-gray-400 text-3xl'>🇽</button>
      </div>  
        <div class='w-full flex justify-center'>
          <p class='text-xl font-bold mb-4'>Удалить все данные, связанные с приложением?</p>
        </div>
        <div class='flex mb-2'>
          <button onclick='noDelData()'
            class='w-40 mx-auto text-white h-16 rounded-lg shadow-[0px_5px_10px_2px_rgba(34,60,80,0.2)] bg-[#fa8181] border-solid border-2 border-[#fa8181] hover:border-black text-[#535c69] text-xl'>Нет</button>
          <button onclick='delData()'
            class='w-40 mx-auto text-white h-16 rounded-lg shadow-[0px_5px_10px_2px_rgba(34,60,80,0.2)] bg-[#fa8181] border-solid border-2 border-[#fa8181] hover:border-black text-[#535c69] text-xl'>Да</button>  
        </div>
        <div id='infoDel' class='hidden w-full flex justify-center'>
          <p class='text-base text-red-600'>Дождитесь уведомления об успешном удалении!</p>
        </div>
      </div>
    </div>
  <div>
</div>

<script src="index.js"></script>
<script src="delete.js"></script>

<script>

  let gmtPortal = 0;

  BX24.callMethod("server.time", {},

    function (result) {

      if (result.error()) {
        console.error(result.error());
      } else {
        //console.log(result.data());
        const timeSpan = document.getElementById('time');
  
        function time() {
          var d = new Date();
          var s = d.getSeconds();
          var m = d.getMinutes();
          var h = d.getHours();
          timeSpan.textContent = 
            ("0" + h).substr(-2) + ":" + ("0" + m).substr(-2) + ":" + ("0" + s).substr(-2);
        };

        setInterval(time, 1000);

        const data = new Date(result.data());
        gmt = data.getTimezoneOffset();

        const hoursGMT = Math.floor(Math.abs(gmt / 60)); // получение часов
        const minGMT = Math.abs(gmt % 60); // получение минут
        const gmtUser = (gmt <= 0 ? "+" : "-") + hoursGMT.toString().padStart(2, '0') + ":" + minGMT.toString().padStart(2, '0');

        const gmtOptionUser = document.getElementById('gmt');
        gmtOptionUser.textContent = gmtUser;
        gmtOptionUser.value = String(gmtUser);

        gmtPortal = gmt * -1;
      }
    }
  );

  const instContent = document.getElementById('instContent');
  const manualContent = document.getElementById('manualContent');

  const instMenu = document.getElementById('instMenu');
  const manualMenu = document.getElementById('manualMenu');

  const instTab = document.getElementById('instTab');
  const manualTab = document.getElementById('manualTab');

  const instBtn = document.getElementById('instBtn');
  const changeBtn = document.getElementById('changeBtn');
  const delBtn = document.getElementById('delBtn');

  const popupDel = document.getElementById('popupDel');
  const infoDel  = document.getElementById('infoDel');
  const infoInst  = document.getElementById('infoInst');
  const size = BX24.getScrollSize();
  const sizeHeight = size.scrollHeight - 70;
  
  instContent.style.setProperty('max-height', `${sizeHeight}px`);
  manualContent.style.setProperty('max-height', `${sizeHeight}px`);

  const showInst = () => {

    instContent.classList.remove("hidden");
    manualContent.classList.add("hidden");

    instMenu.classList.remove("hidden");
    manualMenu.classList.add("hidden");

    instTab.classList.add("checked");
    manualTab.classList.remove("checked");
  }

  const showManual = () => {
    instContent.classList.add("hidden");
    manualContent.classList.remove("hidden");

    instMenu.classList.add("hidden");
    manualMenu.classList.remove("hidden");

    instTab.classList.remove("checked");
    manualTab.classList.add("checked");
  }

  const showDelPopup = () => {
    popupDel.classList.remove("hidden");
  }

  const delData = () => {
    infoDel.classList.remove("hidden");
    deleteSmart();
  }

  const noDelData = () => {
    infoDel.classList.remove("hidden");
    deleteEntity();
  }

  const closePopupDel = () => {
    popupDel.classList.add("hidden");
  }

  let postObj = {};

  BX24.init(function () {
    console.log('Инициализация завершена!', BX24.isAdmin());

    postObj = BX24.getAuth();
    
    ajaxPostProm("https://education.smartbiznes-bitrix.ru/timecontrol/getStatus.php", postObj)
      .then(function (responseData) {
        //console.log('responseData->', responseData);

        let statusPortal = 'false';

        if (responseData.length > 0) {
          statusPortal = responseData[0]['STATUS'];
        }

        if (statusPortal === 'true') {
          instBtn.classList.add("hidden");
          changeBtn.classList.remove("hidden");
          delBtn.classList.remove("hidden");
        };

        if (statusPortal === 'false') {
          instBtn.classList.remove("hidden");
          changeBtn.classList.add("hidden");
          delBtn.classList.add("hidden");
        };

      })
      .catch(function (error) {
        console.error(error);
      });
  });

  function ajaxPostProm(url, data) {

    return new Promise(function (resolve, reject) {

      if (url && data) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", url, true);
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.onreadystatechange = function () {

          if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            //console.log(xhr.response)
            const responseData = JSON.parse(xhr.response);
            resolve(responseData); // обещание выполнилось успешно с данными ответа
          }
        };
        const jsonData = JSON.stringify(data);
        xhr.send(jsonData);

      } else {
        reject("Missing URL or data"); // обещание не выполнилось из-за отсутствия URL или данных
      }
    })
  };

  const selectGmt = (sel) => {
    const gmt = sel.options[sel.selectedIndex].text;
    const timeZoneParts = gmt.split(' ');
    const hoursMinutes = timeZoneParts[1].split(':');
    const hours = parseInt(hoursMinutes[0]);
    gmtPortal = hours * 60;
  }

  const changeGmtPortal = () => {

    infoInst.classList.remove("hidden");
    postObj.gmt = gmtPortal;

    ajaxPostProm("https://education.smartbiznes-bitrix.ru/timecontrol/changeData.php", postObj)
      .then(function (responseData) {
        console.log('responseData->', responseData);
      })
      .catch(function (error) {
        console.error(error);
      });
  }

  /* function getScrollSizeUpdate() {
    if ((size.scrollHeight / (window.screen.height / 100)) < 90) {
        size.scrollHeight = window.screen.height * 0.75;
    }
    BX24.resizeWindow(size.scrollWidth, size.scrollHeight);
  } */

</script>