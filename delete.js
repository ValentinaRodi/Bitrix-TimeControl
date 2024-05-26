let entityIdUsers = null;
let idUsers = null;
let entityIdMonth = null;
let idMonth = null;
let entityIdDays = null;
let idDays = null;
let totalData = 0;

function deleteSmart() {
    BX24.callMethod("entity.item.get", { ENTITY: 'working_hours', },
        function (result) {
            if (result.error()) {
                //console.error(result.error());
                console.log('Хранилище уже удалено'); 
            } else {
                //console.info(result.data());
                const resultItemsEntity = result.data();
                
                resultItemsEntity.forEach(item => { 
                    if (item.NAME === 'UsersSmart') {
                        entityIdUsers = item.PROPERTY_VALUES.entityIdSmart;
                        idUsers = item.PROPERTY_VALUES.idSmart;
                    };
                    if (item.NAME === 'MonthSmart') {
                        entityIdMonth = item.PROPERTY_VALUES.entityIdSmart;
                        idMonth = item.PROPERTY_VALUES.idSmart;
                    };
                    if (item.NAME === 'DaysSmart') {
                        entityIdDays = item.PROPERTY_VALUES.entityIdSmart;
                        idDays = item.PROPERTY_VALUES.idSmart;
                    };
                });

                getElSmart(entityIdUsers, idUsers);
            }
        }
    );
};

//Получение элементов смарт-поцессов
function getElSmart(entitySmart, idSmart) {
    BX24.callMethod('crm.item.list', { entityTypeId: entitySmart }, function (result) {
        if (result.error()) {
            console.error(result.error());
            deleteIdSmart(idSmart);
        } else {
            //console.log(result.data().items);

            const resultItems = result.data().items;
            let batchAddElements = new Array();

            resultItems.forEach(item => {
                //console.log(item.id);

                let batchTitle = 'delete_el' + item.id;

                let batchElement = {
                    [batchTitle]: ['crm.item.delete', {
                        entityTypeId: entitySmart,
                        id: item.id
                    }]
                };
                batchAddElements.push(batchElement);
            });

            const chunkedBatchElements = arrayChunkDel(batchAddElements, 50);
            
            // Отправляем каждый батч запросов
            chunkedBatchElements.forEach(item => {
                const batchObject = Object.assign({}, ...item);
                const data = sendBatchProm(batchObject, idSmart);
            });
        }
    })
};

function sendBatchProm(batch, idSmart) {
    return new Promise((resolve, reject) => {
        BX24.callBatch(batch, function (result) {
            resolve(result);
            deleteIdSmart(idSmart);
        });
    });
}

//Удаление смарт-процесса
function deleteIdSmart(idSmart) {
    BX24.callMethod('crm.type.delete', { 'id': idSmart },
        function(result) {
            if (result.error()) {
                console.error(result.error());
            } else {
                if(idSmart === idUsers) getElSmart(entityIdMonth, idMonth);
                if(idSmart === idMonth) getElSmart(entityIdDays, idDays);
                if(idSmart === idDays) deleteEntity();
            }
        }
    );
    console.log('Удален смарт-процесс №', idSmart, 'успешно');
}

//Удаление хранилища
function deleteEntity() {
   
    BX24.callMethod('entity.delete', { 'ENTITY': 'working_hours' },
    function (result) {
        if (result.error()) {
            //console.error(result.error());
        } else {
            //console.log(result.data());

            ajaxPostProm("https://education.smartbiznes-bitrix.ru/timecontrol/changeData.php", postObj)
            .then(function(responseData) {
                //console.log('responseData->', responseData)
            })
            .catch(function(error) {
                console.error(error);
            });

            alert('Приложение удалено успешно');
            location.reload();
        }
    });  
}

//Для разбиения массива и передачи в callBatch
function arrayChunkDel(array, size) {
    const chunks = [];
    for (let i = 0; i < array.length; i += size) {
        chunks.push(array.slice(i, i + size));
    }
    return chunks;
}

