const copyBtnReq1 = document.getElementById("copyBtnReq1");
const copyBtnReq2 = document.getElementById("copyBtnReq2");
const copyBtnReq3 = document.getElementById("copyBtnReq3");

copyBtnReq1.addEventListener("click", function() {
    copyText("copyTextReq1");
    hiddenBtn("copiedDivReq1", copyBtnReq1);
});

copyBtnReq2.addEventListener("click", function() {
    copyText("copyTextReq2");
    hiddenBtn("copiedDivReq2", copyBtnReq2);
});

copyBtnReq3.addEventListener("click", function() {
    copyText("copyTextReq3");
    hiddenBtn("copiedDivReq3", copyBtnReq3);
});

const btnCurl1 = document.getElementById("btnCurl1");
const btnBsl1 = document.getElementById("btnBsl1");
const btnQuery1 = document.getElementById("btnQuery1");

const contentCurl1 = document.getElementById("contentCurl1");
const contentBsl1 = document.getElementById("contentBsl1");
const contentQuery1 = document.getElementById("contentQuery1");

btnCurl1.addEventListener("click", function() {
    clickTab(contentCurl1, contentBsl1, contentQuery1, btnCurl1, btnBsl1, btnQuery1);
});

btnBsl1.addEventListener("click", function() {
    clickTab(contentBsl1, contentCurl1, contentQuery1, btnBsl1, btnCurl1, btnQuery1);
});

btnQuery1.addEventListener("click", function() {
    clickTab(contentQuery1, contentBsl1, contentCurl1, btnQuery1, btnBsl1, btnCurl1);
});

const copyBtnResponse1 = document.getElementById("copyBtnResponse1");

copyBtnResponse1.addEventListener("click", function() {
    copyText("copyTextResponse1");
    hiddenBtn("copiedDivResponse1", copyBtnResponse1);
});

function clickTab(content1, content2, content3, btn1, btn2, btn3) {
    content1.classList.remove("hidden");
    content2.classList.add("hidden");
    content3.classList.add("hidden");
    
    btn1.classList.add("checked-tab");
    btn2.classList.remove("checked-tab");
    btn3.classList.remove("checked-tab");
}

function hiddenBtn(divId, btnId) {
    const copiedDiv1 = document.getElementById(divId);
    
    btnId.classList.add("hidden");
    copiedDiv1.classList.remove("hidden");

    setTimeout(function() {
        btnId.classList.remove("hidden");
        copiedDiv1.classList.add("hidden");
    }, 1000);  
}

function copyText(elementId) {
    const text = document.getElementById(elementId).textContent;
    
    // Создаем временный элемент textarea для копирования текста
    const tempInput = document.createElement("textarea");
    tempInput.style.position = "absolute";
    tempInput.style.left = "-1000px";
    tempInput.value = text;
    
    // Добавляем временный элемент в DOM
    document.body.appendChild(tempInput);
    
    // Выделяем текст временного элемента
    tempInput.select();
    
    // Копируем выделенный текст в буфер обмена
    document.execCommand("copy");
    
    // Удаляем временный элемент
    document.body.removeChild(tempInput);
    
    // Выводим сообщение об успешном копировании
    console.log("Текст скопирован в буфер обмена: " + text);
}