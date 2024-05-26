/* function ajaxPostProm(url, data) {
  return new Promise(function(resolve, reject) {
    if (url && data) {
      const xhr = new XMLHttpRequest();
      xhr.open("POST", url, true);
      xhr.setRequestHeader("Content-Type", "application/json");
      xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
          const responseData = JSON.parse(xhr.responseText);
          resolve(responseData); // обещание выполнилось успешно с данными ответа
        }
      };
      const jsonData = JSON.stringify(data);
      xhr.send(jsonData);
    } else {
      reject("Missing URL or data"); // обещание не выполнилось из-за отсутствия URL или данных
    }
  });
} */



let resultArr = new Array();

let entityIdUsersSmart = null;
let idUsersSmart = null;

let entityIdMonthSmart = null;
let idMonthSmart = null;

let entityIdDaysSmart = null;
let idDaysSmart = null;

let newUsers = new Array();
let updateUsers = new Array();

//Проверка наличие хранилища
//Если нет создаем смарт-процессы
function installApp() {
  BX24.callMethod("entity.item.get", { ENTITY: 'working_hours', },
    function (result) {
      if (result.error()) {
        //console.error(result.error());
        getUsers();
      } else {
        //console.log(result.data());
      }
    }
  );
}

//Получение всех пользователей и добавление элементов по количеству пользователей
//и вызов функции getTimeStatus()
function getUsers() {
  BX24.callMethod('user.get', {}, function (result) {
    if (result.error()) {
      console.error(result.error());
    } else {
      // console.log(result.data());
      const resultUsers = result.data();

      resultUsers.forEach(item => {
        let element = new Object();

        element.userId = item.ID;
        element.userLastName = item.LAST_NAME;
        element.userName = item.NAME;
        element.userSecondName = item.SECOND_NAME; //undefinded

        resultArr.push(element);
      });
      getTimeStatus();
    }
  })
};

// Получение данных о рабочем времени каждого пользователя (за текущий день или последний рабочий день)
//Вызов функции addUsersSmartProcess()
function getTimeStatus() {

  let batchGetUserTime = new Object();

  resultArr.forEach(item => {
    let batchElement = ['timeman.status', { user_id: item.userId }];
    let batchTitle = 'get_userTime_' + item.userId;

    batchGetUserTime[batchTitle] = batchElement;
  });

  BX24.callBatch(batchGetUserTime, function (result) {
    //console.log(result)
    Object.entries(result).forEach(
      ([key, value]) => {
        const number = parseInt(key.match(/\d+/));

        Object.entries(value).forEach(([key, value]) => {
          resultArr.forEach(item => {
            if (Number(item.userId) === number && value.result) {
              item.status = value.result.STATUS;
              item.day = 0;
              item.sumTimeDuration = '00:00:00';

              if (value.result.TIME_FINISH) {
                item.timeFinish = value.result.TIME_FINISH;
                item.duration = value.result.DURATION;
                item.timeLeaks = value.result.TIME_LEAKS;
              }

              if (!value.result.TIME_FINISH) {
                item.timeFinish = '0';
                item.duration = '0';
                item.timeLeaks = '0';
              }
            };
          })
        })
      }
    );
    addUsersSmartProcess();
  });
};

//Для разбиения массива и передачи в callBatch
function arrayChunk(array, size) {
  const chunks = [];
  for (let i = 0; i < array.length; i += size) {
    chunks.push(array.slice(i, i + size));
  }
  return chunks;
}

//Создание смарт-процесса Пользователи и добавление полей
function addUsersSmartProcess() {
  BX24.callMethod("crm.type.add",
    {
      fields: {
        title: "Пользователи",
        XML_ID: "NEW1",
        SORT: 10,
        isAutomationEnabled: "N",
        isBeginCloseDatesEnabled: "N",
        isBizProcEnabled: "N",
        isCategoriesEnabled: "Y",
        isClientEnabled: "N",
        isCountersEnabled: "N",
        isDocumentsEnabled: "N",
        isLinkWithProductsEnabled: "N",
        isMycompanyEnabled: "N",
        isObserversEnabled: "N",
        isPaymentsEnabled: "N",
        isRecyclebinEnabled: "Y",
        isSetOpenPermissions: "Y",
        isSourceEnabled: "N",
        isStagesEnabled: "N",
        isUseInUserfieldEnabled: "Y",
      },
    },

    function (result) {
      if (result.error()) {
        console.log(result.error());
      } else {
        entityIdUsersSmart = result.data().type.entityTypeId;
        idUsersSmart = result.data().type.id;

        addFieldUsersSmart();
      }
    })
}

//Добавление полей в смарт-процесс Пользователи 
//Вызов функции addElementsUsersSmart()
function addFieldUsersSmart() {

  const fieldIdUser = ['userfieldconfig.add', {
    moduleId: "crm",
    field: {
      entityId: "CRM_" + idUsersSmart,
      fieldName: "UF_CRM_" + idUsersSmart + "_ID_USER_CALENDAR_SMB",
      userTypeId: "double",
      editFormLabel: {
        "ru": "ID пользователя",
      },
      mandatory: "Y"
    }
  }];

  const fieldLastNameUser = ['userfieldconfig.add', {
    moduleId: "crm",
    field: {
      entityId: "CRM_" + idUsersSmart,
      fieldName: "UF_CRM_" + idUsersSmart + "_LAST_NAME_CALENDAR_SMB",
      userTypeId: "string",
      editFormLabel: {
        "ru": "Фамилия пользователя",
      },
      mandatory: "Y"
    }
  }];

  const fieldNameUser = ['userfieldconfig.add', {
    moduleId: "crm",
    field: {
      entityId: "CRM_" + idUsersSmart,
      fieldName: "UF_CRM_" + idUsersSmart + "_NAME_CALENDAR_SMB",
      userTypeId: "string",
      editFormLabel: {
        "ru": "Имя пользователя",
      },
      mandatory: "Y"
    }
  }];

  const fieldSecondNameUser = ['userfieldconfig.add', {
    moduleId: "crm",
    field: {
      entityId: "CRM_" + idUsersSmart,
      fieldName: "UF_CRM_" + idUsersSmart + "_SECOND_NAME_CALENDAR_SMB",
      userTypeId: "string",
      editFormLabel: {
        "ru": "Отчество пользователя",
      },
      mandatory: "Y"
    }
  }];

  BX24.callBatch({
    add_field_idUser: fieldIdUser,
    add_field_nameUser: fieldNameUser,
    add_field_secondNameUser: fieldSecondNameUser,
    add_field_lastNameUser: fieldLastNameUser,
  }, function (result) {
    // console.log(result);

    addElementsUsersSmart(resultArr);
  });
}

//Добавление элементов в смарт-процесс Пользователи
//Вызов функции добавления смарт-процесса Месяц
function addElementsUsersSmart(arr) {
  let batchAddElements = new Array();
 
    arr.forEach(item => {
      let batchTitle = 'add_user' + item.userId;
  
      let batchElement = {
        [batchTitle]: ['crm.item.add', {
          entityTypeId: entityIdUsersSmart,
          fields: {
            title: item.userLastName + ' ' + item.userName + ' ' + item.userSecondName,
            ['ufCrm' + idUsersSmart + "IdUserCalendarSmb"]: item.userId,
            ['ufCrm' + idUsersSmart + "LastNameCalendarSmb"]: item.userLastName,
            ['ufCrm' + idUsersSmart + "NameCalendarSmb"]: item.userName,
            ['ufCrm' + idUsersSmart + "SecondNameCalendarSmb"]: item.userSecondName,
          }
        }]
      };
      batchAddElements.push(batchElement);
    });
  
  const chunkedBatchElements = arrayChunk(batchAddElements, 50);

  // Отправляем каждый батч запросов
  chunkedBatchElements.forEach(item => {
    const batchObject = Object.assign({}, ...item);
    const data = sendBatchPromIndex(batchObject, 'idElementUsersSmart');
  });
}

function sendBatchPromIndex(batch, idElement) {
  return new Promise((resolve, reject) => {
      BX24.callBatch(batch, function (result) {
          resolve(result);

          Object.entries(result).forEach(
            ([key, value]) => {
              const number = parseInt(key.match(/\d+/));
      
              Object.entries(value).forEach(([key, value]) => {
                if (value.result && value.result.item) {
                  const resultItem = resultArr.number;
                  resultArr.forEach(item => {
                    if (Number(item.userId) === number) {
                      item[idElement] = value.result.item.id; //id элемента в смарт-процессе 
                    }
                  })
                }
              })
            }
          );

          if(idElement === 'idElementUsersSmart') addMonthSmartProcess();
          if(idElement === 'idElementMonthSmart') addDaysSmartProcess();
      });
  });
}

//Создание смарт-процесса Месяц 2024 и добавление полей
function addMonthSmartProcess() {
  const parentLink = {
    parent: [
      {
        entityTypeId: entityIdUsersSmart,
        isChildrenListEnabled: true,
      }
    ],
    child: [
      {
        entityTypeId: entityIdDaysSmart,
        isChildrenListEnabled: true,
      }
    ]
  };

  BX24.callMethod("crm.type.add",
    {
      fields: {
        title: 'Месяц 2024',
        XML_ID: "NEW",
        SORT: 10,
        isAutomationEnabled: "N",
        isBeginCloseDatesEnabled: "N",
        isBizProcEnabled: "N",
        isCategoriesEnabled: "Y",
        isClientEnabled: "N",
        isCountersEnabled: "N",
        isDocumentsEnabled: "N",
        isLinkWithProductsEnabled: "N",
        isMycompanyEnabled: "N",
        isObserversEnabled: "N",
        isPaymentsEnabled: "N",
        isRecyclebinEnabled: "Y",
        isSetOpenPermissions: "Y",
        isSourceEnabled: "N",
        isStagesEnabled: "N",
        isUseInUserfieldEnabled: "Y",
        "relations": parentLink,
      },
    },
    function (result) {
      if (result.error()) {
        console.log(result.error());
      } else {
        entityIdMonthSmart = result.data().type.entityTypeId;
        idMonthSmart = result.data().type.id;

        addFieldMonthSmart();
      }
    })
}

//Добавление полей в смарт-процесс Месяц
//Вызов функции addElementsMonthSmart()
function addFieldMonthSmart() {

  const fieldTimeMonth = ['userfieldconfig.add', {
    moduleId: "crm",
    field: {
      entityId: "CRM_" + idMonthSmart,
      fieldName: "UF_CRM_" + idMonthSmart + "_TIME_MONTH_CALENDAR_SMB",
      userTypeId: "string",
      editFormLabel: {
        "ru": "Отработанное время за месяц",
      },
      mandatory: "Y"
    }
  }];

  const fieldDayMonth = ['userfieldconfig.add', {
    moduleId: "crm",
    field: {
      entityId: "CRM_" + idMonthSmart,
      fieldName: "UF_CRM_" + idMonthSmart + "_DAY_MONTH_CALENDAR_SMB",
      userTypeId: "string",
      editFormLabel: {
        "ru": "Отработано дней",
      },
      mandatory: "Y"
    }
  }];

  const fieldIdUser = ['userfieldconfig.add', {
    moduleId: "crm",
    field: {
      entityId: "CRM_" + idMonthSmart,
      fieldName: "UF_CRM_" + idMonthSmart + "_ID_USER_CALENDAR_SMB",
      userTypeId: "double",
      editFormLabel: {
        "ru": "ID пользователя",
      },
      mandatory: "Y"
    }
  }];

  const fieldMonth = ['userfieldconfig.add', {
    moduleId: "crm",
    field: {
      entityId: "CRM_" + idMonthSmart,
      fieldName: "UF_CRM_" + idMonthSmart + "_MONTH_CALENDAR_SMB",
      userTypeId: "double",
      editFormLabel: {
        "ru": "Месяц",
      },
      mandatory: "Y"
    }
  }];

  BX24.callBatch({
    add_field_timeMonth: fieldTimeMonth,
    add_field_dayMonth: fieldDayMonth,
    add_field_idUser: fieldIdUser,
    add_field_month: fieldMonth,
  }, function (result) {
    // console.log(result);

    addElementsMonthSmart(resultArr);
  });
}

//Добавление элементов в смарт-процесс Месяц
//Вызов функции добавления смарт-процесса День
function addElementsMonthSmart(arr) {
  let batchAddElements = new Array();

  arr.forEach(item => {
    if (item.status === 'CLOSED' && item.timeFinish !== '0') {
      const date = new Date(item.timeFinish);

      const monthNumber = date.getMonth() + 1;

      const monthString = date.toLocaleString('default', { month: 'long' });
      const monthUpper = monthString[0].toUpperCase() + monthString.substring(1);
      const monthTitle = monthUpper + ' ' + date.getFullYear();

      const dayDuration = 1;
      item.day = 1;

      item.sumTimeDuration = item.duration;
      
      const batchTitle = 'add_month' + item.userId;
      const batchElement = {
        [batchTitle]: ['crm.item.add', {
          entityTypeId: entityIdMonthSmart,
          fields: {
            title: monthTitle,
            ['ufCrm' + idMonthSmart + "TimeMonthCalendarSmb"]: item.duration,
            ['ufCrm' + idMonthSmart + "DayMonthCalendarSmb"]: dayDuration,
            ['ufCrm' + idMonthSmart + "IdUserCalendarSmb"]: item.userId,
            ['ufCrm' + idMonthSmart + "MonthCalendarSmb"]: monthNumber,
            ["parentId" + entityIdUsersSmart]: item.idElementUsersSmart,
          }
        }]
      };
      batchAddElements.push(batchElement);
    } else {
      item.idElementMonthSmart = 0;
    }
  });

  console.log('batchAddElements', batchAddElements)
  const chunkedBatchElements = arrayChunk(batchAddElements, 50);

  // Отправляем каждый батч запросов
  chunkedBatchElements.forEach(item => {
    const batchObject = Object.assign({}, ...item);
    const data = sendBatchPromIndex(batchObject, 'idElementMonthSmart');
  });
}

//Создание смарт-процесса День и добавление полей
function addDaysSmartProcess() {
  const parentLink = {
    parent: [
      {
        entityTypeId: entityIdMonthSmart,
        isChildrenListEnabled: true,
      }
    ]
  };

  BX24.callMethod("crm.type.add",
    {
      fields: {
        title: 'День',
        XML_ID: "NEW2",
        SORT: 10,
        isAutomationEnabled: "N",
        isBeginCloseDatesEnabled: "N",
        isBizProcEnabled: "N",
        isCategoriesEnabled: "Y",
        isClientEnabled: "N",
        isCountersEnabled: "N",
        isDocumentsEnabled: "N",
        isLinkWithProductsEnabled: "N",
        isMycompanyEnabled: "N",
        isObserversEnabled: "N",
        isPaymentsEnabled: "N",
        isRecyclebinEnabled: "Y",
        isSetOpenPermissions: "Y",
        isSourceEnabled: "N",
        isStagesEnabled: "N",
        isUseInUserfieldEnabled: "Y",
        "relations": parentLink,
      },
    },
    function (result) {
      if (result.error()) {
        console.log(result.error());
      } else {
        entityIdDaysSmart = result.data().type.entityTypeId;
        idDaysSmart = result.data().type.id;

        addFieldDaysSmart();
      }
    }
  )
}

//Добавление полей в смарт-процесс День
//Вызов функции addElementsDaySmart()
function addFieldDaysSmart() {

  const fieldData = ['userfieldconfig.add', {
    moduleId: "crm",
    field: {
      entityId: "CRM_" + idDaysSmart,
      fieldName: "UF_CRM_" + idDaysSmart + "_DAY_CALENDAR_SMB",
      userTypeId: "string",
      editFormLabel: {
        "ru": "Дата",
      },
      mandatory: "Y"
    }
  }];

  const fieldDayDuration = ['userfieldconfig.add', {
    moduleId: "crm",
    field: {
      entityId: "CRM_" + idDaysSmart,
      fieldName: "UF_CRM_" + idDaysSmart + "_DAY_DURATION_CALENDAR_SMB",
      userTypeId: "string",
      editFormLabel: {
        "ru": "Отработано времени",
      },
      mandatory: "Y"
    }
  }];

  const fieldDayLeaks = ['userfieldconfig.add', {
    moduleId: "crm",
    field: {
      entityId: "CRM_" + idDaysSmart,
      fieldName: "UF_CRM_" + idDaysSmart + "_DAY_LEAKS_CALENDAR_SMB",
      userTypeId: "string",
      editFormLabel: {
        "ru": "Продолжительность перерыва",
      },
      mandatory: "Y"
    }
  }];

  const fieldIdUser = ['userfieldconfig.add', {
    moduleId: "crm",
    field: {
      entityId: "CRM_" + idDaysSmart,
      fieldName: "UF_CRM_" + idDaysSmart + "_ID_USER_CALENDAR_SMB",
      userTypeId: "double",
      editFormLabel: {
        "ru": "ID пользователя",
      },
      mandatory: "Y"
    }
  }];

  BX24.callBatch({
    add_field_data: fieldData,
    add_field_dayDuration: fieldDayDuration,
    add_field_dayLeaks: fieldDayLeaks,
    add_field_idUser: fieldIdUser,
  }, function (result) {
    // console.log(result);
    addElementsDaysSmart(resultArr);
  });
}

//Добавление элементов в смарт-процесс День
//Создание хранилища
function addElementsDaysSmart(arr) {
  let batchAddElements = new Array();

  arr.forEach(item => {
    if (item.status === 'CLOSED' && item.timeFinish !== '0') {
      const date = new Date(item.timeFinish);

      let dayTitle = date.toLocaleString('ru', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      });;

      let batchTitle = 'add_day' + item.userId;

      let batchElement = {
        [batchTitle]: ['crm.item.add', {
          entityTypeId: entityIdDaysSmart,
          fields: {
            title: dayTitle,
            ['ufCrm' + idDaysSmart + "DayCalendarSmb"]: date,
            ['ufCrm' + idDaysSmart + "DayDurationCalendarSmb"]: item.duration,
            ['ufCrm' + idDaysSmart + "DayLeaksCalendarSmb"]: item.leaks,
            ['ufCrm' + idDaysSmart + "IdUserCalendarSmb"]: item.userId,
            ["parentId" + entityIdMonthSmart]: item.idElementMonthSmart,
          }
        }]
      };
      batchAddElements.push(batchElement);
    } else {
      item.idElementDaysSmart = 0;
    }
  });
  console.log('batchAddElementsDay', batchAddElements)
  const chunkedBatchElements = arrayChunk(batchAddElements, 50);

  // Отправляем каждый батч запросов
  chunkedBatchElements.forEach(item => {
    const batchObject = Object.assign({}, ...item);
    const data = sendBatchPromIndex(batchObject, 'idElementDaysSmart');
  });
}



//Добавление связей в элементы смарт-процесса День
//Создание хранилища
function updateItemDaysSmart(arr) {
  let batchAddElements = new Array();

  arr.forEach(item => {
    if (item.idElementDaysSmart !== 0) {
      const batchTitle = 'update_month' + item.userId;
      const batchElement = {
        [batchTitle]: ['crm.item.update', {
          entityTypeId: entityIdDaysSmart,
          id: item.idElementDaysSmart,
          fields: {
            ["parentId" + entityIdMonthSmart]: item.idElementMonthSmart,
          }
        }]
      };
      batchAddElements.push(batchElement);
    }
  });

  const chunkedBatchElements = arrayChunk(batchAddElements, 50);

  // Отправляем каждый батч запросов
  chunkedBatchElements.forEach(item => {
    const batchObject = Object.assign({}, ...item);
    BX24.callBatch(batchObject, function (result) {
      //console.log(result)
    })
  });
  addEntity();
};

//Создание хранилища
//Добавление элементов в хранилище
function addEntity() {
  BX24.callMethod(
    "entity.add",
    { 'ENTITY': 'working_hours', 'NAME': 'working_hours', 'ACCESS': { AU: 'R' } },
    function (result) {
      if (result.error())
        console.error(result.error());
      else {
        console.info(result.data());
        addItemEntity(entityIdUsersSmart, idUsersSmart, entityIdMonthSmart, idMonthSmart, entityIdDaysSmart, idDaysSmart)
      }
    }
  );
};

//Добавление элементов в хранилище
function addItemEntity(entityUser, idUser, entityMonth, idMonth, entityDay, idDay) {
  BX24.callMethod('entity.item.add', {
    ENTITY: 'working_hours',
    DATE_ACTIVE_FROM: new Date(),
    DETAIL_PICTURE: '',
    NAME: `entityIdUsersSmart:${entityUser}`,
    SECTION: 219
  });

  BX24.callMethod('entity.item.add', {
    ENTITY: 'working_hours',
    DATE_ACTIVE_FROM: new Date(),
    DETAIL_PICTURE: '',
    NAME: `idUsersSmart:${idUser}`,
    SECTION: 219
  });

  BX24.callMethod('entity.item.add', {
    ENTITY: 'working_hours',
    DATE_ACTIVE_FROM: new Date(),
    DETAIL_PICTURE: '',
    NAME: `entityIdMonthSmart:${entityMonth}`,
    SECTION: 219
  });

  BX24.callMethod('entity.item.add', {
    ENTITY: 'working_hours',
    DATE_ACTIVE_FROM: new Date(),
    DETAIL_PICTURE: '',
    NAME: `idMonthSmart:${idMonth}`,
    SECTION: 219
  });

  BX24.callMethod('entity.item.add', {
    ENTITY: 'working_hours',
    DATE_ACTIVE_FROM: new Date(),
    DETAIL_PICTURE: '',
    NAME: `entityIdDaysSmart:${entityDay}`,
    SECTION: 219
  });

  BX24.callMethod('entity.item.add', {
    ENTITY: 'working_hours',
    DATE_ACTIVE_FROM: new Date(),
    DETAIL_PICTURE: '',
    NAME: `idDaysSmart:${idDay}`,
    SECTION: 219
  });
};

//Обновление элементов смарт-процесса Месяц
function updateElementsDaysSmart(idSmart) {
  BX24.callMethod('crm.item.list', { entityTypeId: idSmart }, function (result) {
    if (result.error()) {
      console.error(result.error());
    } else {
      // console.log(updateUsers)
      // console.log(result.data().items);
      const updateElementsMonth = result.data().items;

      const entitySmartId = 'ufCrm' + idMonthSmart + 'IdUserCalendarSmb';

      let batchAddElements = new Array();

      updateUsers.forEach(item => {
        if (item.status === 'CLOSED' && item.timeFinish !== '0') {
          updateElementsMonth.forEach(i => {
            console.log(i)
            console.log(item)
          })
          /* const date = new Date(item.timeFinish);

          const monthNumber = date.getMonth() + 1;

          const monthString = date.toLocaleString('default', { month: 'long' });
          const monthUpper = monthString[0].toUpperCase() + monthString.substring(1);
          const monthTitle = monthUpper + ' ' + date.getFullYear();

          const dayDuration = 1;
          item.day = 1;

          item.sumTimeDuration = item.duration;
        
          const batchTitle = 'add_month' + item.userId;
          const batchElement = {
            [batchTitle]: ['crm.item.add', {
              entityTypeId: entityIdMonthSmart,
              fields: {
                title: monthTitle,
                ['ufCrm' + idMonthSmart + "TimeMonthCalendarSmb"]: item.duration,
                ['ufCrm' + idMonthSmart + "DayMonthCalendarSmb"]: dayDuration,
                ['ufCrm' + idMonthSmart + "IdUserCalendarSmb"]: item.userId,
                ['ufCrm' + idMonthSmart + "MonthCalendarSmb"]: monthNumber,
                ["parentId" + entityIdUsersSmart]: item.idElementUsersSmart,
              }
            }]
          };
          batchAddElements.push(batchElement); */
        } else {
          item.idElementMonthSmart = 0;
        }
      });

      const chunkedBatchElements = arrayChunk(batchAddElements, 50);

      // Отправляем каждый батч запросов
      chunkedBatchElements.forEach(item => {
        const batchObject = Object.assign({}, ...item);

        BX24.callBatch(batchObject, function (result) {
          //console.log(result);

          Object.entries(result).forEach(
            ([key, value]) => {
              const number = parseInt(key.match(/\d+/));

              Object.entries(value).forEach(([key, value]) => {
                if (value.result && value.result.item) {
                  const resultItem = resultArr.number;
                  resultArr.forEach(item => {
                    if (Number(item.userId) === number) {
                      item.idElementMonthSmart = value.result.item.id; //id элемента в смарт-процессе 
                    }
                  })
                }
              })
            }
          );

          const updateResult = update;
          updateItemDaysSmart(resultArr, updateResult);
        });
      });

      const arr = arrGet.items;
      newUsers = arrResult.filter(a => false === arr.some(b => +a.userId === +b[idSmart]));
      updateUsers = arrResult.filter(a => true === arr.some(b => +a.userId === +b[idSmart]));
    }
  })
};