<?



?>



<!-- 
   синий #7dd3fc
   зеленый   #6ee7b7
   фиолетовый  #c4b5fd

<h1>1 - Список пользователей </h1>
<h1>2 - Запрос данных пользователя по рабочим месяцам</h1>
<h1>3 - Запрос данных пользователя по рабочим дням месяца</h1>
<h1 >4 - Запрос данных пользователя по рабочим месяцу и рабочему дню</h1> 
<p class='mb-6'>!!! максимальное кол-во запрососв в 1 секунду 50 !!! нужно ставить таймаут 3 сек !! 127 сек таймаут если привысить !</p> -->
<style>
    .checked-tab {
        color: rgb(52 211 153 / 1);
        border-color: rgb(16 185 129 / 1);
    }
    .checked-tab:hover {
        color: rgb(52 211 153 / 1);
    }
</style>

<div class='flex gap-2 pb-4 mt-4 border-b border-solid border-[rgb(24_24_27/0.05)]'>
    <p class='text-3xl mt-1'>❗</p>
    <div>
        <p class='mb-2'>Для работы с приложением необходимо создать входящий веб-хук</p>
        <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
            <dt class="sr-only">Name</dt>
            <dd class='bg-[#f4f4f5] border-2 border-solid border-[#ececee] rounded-lg px-1 text-xs'><code >{veb-hook}</code></dd>
            <dt class="sr-only">Type</dt>
            <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">URL</dd>
        </dl>
    </div>
</div>

<h1 class='font-bold mb-3 mt-4 text-xl'>Получение списка пользователей</h1>
<p>В результате запроса вы получите ФИО и ID всех пользователей</p>
<p class='text-sm mt-2'><span class='bg-[#f4f4f5] border-2 border-solid border-[#ececee] rounded-lg px-1 text-xs'>{ID смарт-процесса}</span> - после установки приложения автоматически подставится</p>
                    
<div class="xl:top-24">
    <div class="my-6 overflow-hidden rounded-2xl bg-zinc-900 shadow-md dark:ring-1 dark:ring-white/10">
        <div class="not-prose">
            <div class="flex min-h-[40px] flex-wrap items-start gap-x-4 border-b border-zinc-700 bg-zinc-800 px-4 dark:border-zinc-800 dark:bg-transparent">
                <h3 class="mr-auto pt-3 text-xs font-semibold text-white">Запрос</h3>
                <div class="-mb-px flex gap-4 text-xs font-medium" role="tablist" aria-orientation="horizontal">
                    <button id='btnCurl1' class="border-b py-3 transition ui-not-focus-visible:outline-none border-transparent text-zinc-400 hover:text-zinc-300 checked-tab" id="headlessui-tabs-tab-:R36chdtsqla:" role="tab" type="button" aria-selected="true" tabindex="0" data-headlessui-state="selected" aria-controls="headlessui-tabs-panel-:Rqchdtsqla:">cURL</button>
                    <button id='btnBsl1' class="border-b py-3 transition ui-not-focus-visible:outline-none border-transparent text-zinc-400 hover:text-zinc-300" id="headlessui-tabs-tab-:R56chdtsqla:" role="tab" type="button" aria-selected="false" tabindex="-1" data-headlessui-state="" aria-controls="headlessui-tabs-panel-:R1achdtsqla:">1C (BSL)</button>
                    <button id='btnQuery1' class="border-b py-3 transition ui-not-focus-visible:outline-none border-transparent text-zinc-400 hover:text-zinc-300" id="headlessui-tabs-tab-:R76chdtsqla:" role="tab" type="button" aria-selected="false" tabindex="-1" data-headlessui-state="" aria-controls="headlessui-tabs-panel-:R1qchdtsqla:">1C (Query)</button>
                </div>
            </div>
            <div>
                <div id="headlessui-tabs-panel-:Rqchdtsqla:" role="tabpanel" aria-labelledby="headlessui-tabs-tab-:R36chdtsqla:" tabindex="0" data-headlessui-state="selected">
                    <div class="group dark:bg-white/2.5">
                    <div class="flex py-2 items-center gap-2 border-y border-b-[hsla(0,0%,100%,.075)] border-t-transparent bg-white/2.5 bg-zinc-900 px-4 dark:border-b-white/5 dark:bg-white/1">
                        <div class="dark flex">
                            <span class="font-mono text-[0.625rem] font-semibold leading-6 text-emerald-500 dark:text-emerald-400">GET</span>
                        </div>
                    <span class="h-0.5 w-0.5 rounded-full bg-zinc-500"></span>
                    <span class="font-mono text-xs text-zinc-400">https://<?=$domen?>/{veb-hook}/crm.item.list.json?entityTypeId={ID смарт-процесса}</span>
                </div>
                <div id='contentCurl1' class="relative"><pre id='copyTextReq1' class="overflow-x-auto p-4 text-xs text-white"><code class="language-bash"><span><span style="color: #c4b5fd;">curl</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7"> -L</span><span style="color: #6ee7b7"> -X</span><span style="color: #6ee7b7"> -GET  </span><span style="color: #6ee7b7" class='text-wrap'> </span><span class='text-wrap' style="color: #6ee7b7; word-wrap:break-word;">https://<?=$domen?>/{veb-hook}/batch.json?halt=0&cmd[user]=crm.item.list%3FentityTypeId%3D139%26filter[ufCrm184IdUserCalendarSmb]%3D4&cmd[month_user]=crm.item.list%3FentityTypeId%3D149%26filter[ufCrm186IdUserCalendarSmb]%3D4%26filter[ufCrm186MonthCalendarSmb]%3D12</span></span></code></pre>
                    <button id='copyBtnReq1' type="button" class="group/button absolute right-4 top-3.5 overflow-hidden rounded-full py-1 pl-2 pr-3 text-2xs font-medium opacity-0 backdrop-blur transition focus:opacity-100 group-hover:opacity-100 bg-white/5 hover:bg-white/7.5 dark:bg-white/2.5 dark:hover:bg-white/5">
                        <span class="text-xs pointer-events-none flex items-center gap-0.5 text-zinc-400 transition duration-300 ">
                            <svg viewBox="0 0 20 20" aria-hidden="true" class="h-5 w-5 fill-zinc-500/20 stroke-zinc-500 transition-colors group-hover/button:stroke-zinc-400">
                                <path stroke-width="0" d="M5.5 13.5v-5a2 2 0 0 1 2-2l.447-.894A2 2 0 0 1 9.737 4.5h.527a2 2 0 0 1 1.789 1.106l.447.894a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2Z"></path>
                                <path fill="none" stroke-linejoin="round" d="M12.5 6.5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2m5 0-.447-.894a2 2 0 0 0-1.79-1.106h-.527a2 2 0 0 0-1.789 1.106L7.5 6.5m5 0-1 1h-3l-1-1"></path>
                            </svg>
                            Copy
                        </span>
                    </button>
                    <div id='copiedDivReq1' class="hidden group/button absolute right-4 top-3.5 overflow-hidden rounded-full py-1 pl-2 pr-3 text-2xs font-medium opacity-0 backdrop-blur transition focus:opacity-100 group-hover:opacity-100 bg-emerald-400/10">
                        <span class="pointer-events-none flex items-center transition duration-300 text-[#6ee7b7] text-xs">
                            Copied!
                        </span>
                    </div>
                </div>
                <div id='contentBsl1' class="relative hidden"><pre id='copyTextReq2' class="overflow-x-auto p-4 text-xs text-white"><code class="language-bash"><span><span style="color: #7dd3fc">Запрос</span><span style="color: #ffffff"> = </span><span style="color: #c4b5fd;">Новый </span><span style="color: #7dd3fc">HTTPЗапрос</span><span style="color: #ffffff">;</span>
<span style="color: #7dd3fc">АдресЗапроса</span><span style="color: #ffffff"> = </span><span  class='text-wrap' style="color: #6ee7b7;  word-wrap:break-word;" >"https://<?=$domen?>/{veb-hook}/batch.json?halt=0&cmd[user]=crm.item.list%3FentityTypeId%3D139%26filter[ufCrm184IdUserCalendarSmb]%3D4&cmd[month_user]=crm.item.list%3FentityTypeId%3D149%26filter[ufCrm186IdUserCalendarSmb]%3D4%26filter[ufCrm186MonthCalendarSmb]%3D12"</span><span style="color: #ffffff">;</span>
<span style="color: #7dd3fc">Запрос</span><span style="color: #ffffff">.</span><span style="color: #7dd3fc">УстановитьАдрес</span><span style="color: #c4b5fd">(</span><span style="color: #7dd3fc">АдресЗапроса</span><span style="color: #c4b5fd">)</span><span style="color: #ffffff">,</span>
<span style="color: #7dd3fc">Ответ</span><span style="color: #ffffff"> = </span><span style="color: #7dd3fc">ЗавершитьЗапросHTTP</span><span style="color: #c4b5fd">(</span><span style="color: #7dd3fc">Запрос</span><span style="color: #ffffff">, </span><span style="color: #6ee7b7">"GET"</span><span style="color: #c4b5fd">)</span><span style="color: #ffffff">;</span></span></code></pre>
                    <button id='copyBtnReq2' type="button" class="group/button absolute right-4 top-3.5 overflow-hidden rounded-full py-1 pl-2 pr-3 text-2xs font-medium opacity-0 backdrop-blur transition focus:opacity-100 group-hover:opacity-100 bg-white/5 hover:bg-white/7.5 dark:bg-white/2.5 dark:hover:bg-white/5">
                        <span class="text-xs pointer-events-none flex items-center gap-0.5 text-zinc-400 transition duration-300 ">
                            <svg viewBox="0 0 20 20" aria-hidden="true" class="h-5 w-5 fill-zinc-500/20 stroke-zinc-500 transition-colors group-hover/button:stroke-zinc-400">
                                <path stroke-width="0" d="M5.5 13.5v-5a2 2 0 0 1 2-2l.447-.894A2 2 0 0 1 9.737 4.5h.527a2 2 0 0 1 1.789 1.106l.447.894a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2Z"></path>
                                <path fill="none" stroke-linejoin="round" d="M12.5 6.5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2m5 0-.447-.894a2 2 0 0 0-1.79-1.106h-.527a2 2 0 0 0-1.789 1.106L7.5 6.5m5 0-1 1h-3l-1-1"></path>
                            </svg>
                            Copy
                        </span>
                    </button>
                    <div id='copiedDivReq2' class="hidden group/button absolute right-4 top-3.5 overflow-hidden rounded-full py-1 pl-2 pr-3 text-2xs font-medium opacity-0 backdrop-blur transition focus:opacity-100 group-hover:opacity-100 bg-emerald-400/10">
                        <span class="pointer-events-none flex items-center transition duration-300 text-[#6ee7b7] text-xs">
                            Copied!
                        </span>
                    </div>
                </div>
                <div id='contentQuery1' class="relative hidden"><pre id='copyTextReq3' class="overflow-x-auto p-4 text-xs text-white"><code class="language-bash"><span><span style="color: #7dd3fc">Запрос</span><span style="color: #ffffff"> = </span><span style="color: #c4b5fd;">Новый </span><span style="color: #7dd3fc">Запрос</span><span style="color: #ffffff">;</span>
<span style="color: #7dd3fc">Запрос</span><span style="color: #ffffff">.</span><span style="color: #7dd3fc">Адрес</span><span style="color: #ffffff"> = </span><span class='text-wrap' style="color: #6ee7b7;  word-wrap:break-word;">"https://<?=$domen?>/{veb-hook}/batch.json"</span><span style="color: #ffffff">;</span>
<span style="color: #7dd3fc">Запрос</span><span style="color: #ffffff">.</span><span style="color: #7dd3fc">Метод</span><span style="color: #ffffff"> = </span><span style="color: #6ee7b7">"GET"</span><span style="color: #ffffff">;</span>
<span style="color: #7dd3fc">Запрос</span><span style="color: #ffffff">.</span><span style="color: #7dd3fc">Параметры</span><span style="color: #ffffff"> = </span><span style="color: #6ee7b7">"halt=0"</span><span style="color: #ffffff"> + </span><span style="color: #6ee7b7">"&"</span><span style="color: #ffffff"> + </span>
<span class='text-wrap' style="color: #6ee7b7; word-wrap:break-word">"cmd[user]=crm.item.list%3FentityTypeId%3D139%26filter[ufCrm184IdUserCalendarSmb]%3D4"</span><span style="color: #ffffff"> + </span><span style="color: #6ee7b7">"&"</span><span style="color: #ffffff"> + </span><span style="color: #ffffff">   </span><span class='text-wrap indent-2' style="color: #6ee7b7; word-wrap:break-word">   "cmd[month_user]=crm.item.list%3FentityTypeId%3D149%26filter[ufCrm186IdUserCalendarSmb]%3D4%26filter[ufCrm186MonthCalendarSmb]%3D12"</span><span style="color: #ffffff">;</span>
<span style="color: #7dd3fc">Результат</span><span style="color: #ffffff"> = </span><span style="color: #7dd3fc">Запрос</span><span style="color: #ffffff">.</span><span style="color: #7dd3fc">Выполнить</span><span style="color: #c4b5fd">(</span><span style="color: #c4b5fd">)</span><span style="color: #ffffff">;</span></span></code></pre>
                    <button id='copyBtnReq3' type="button" class="group/button absolute right-4 top-3.5 overflow-hidden rounded-full py-1 pl-2 pr-3 text-2xs font-medium opacity-0 backdrop-blur transition focus:opacity-100 group-hover:opacity-100 bg-white/5 hover:bg-white/7.5 dark:bg-white/2.5 dark:hover:bg-white/5">
                        <span class="text-xs pointer-events-none flex items-center gap-0.5 text-zinc-400 transition duration-300 ">
                            <svg viewBox="0 0 20 20" aria-hidden="true" class="h-5 w-5 fill-zinc-500/20 stroke-zinc-500 transition-colors group-hover/button:stroke-zinc-400">
                                <path stroke-width="0" d="M5.5 13.5v-5a2 2 0 0 1 2-2l.447-.894A2 2 0 0 1 9.737 4.5h.527a2 2 0 0 1 1.789 1.106l.447.894a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2Z"></path>
                                <path fill="none" stroke-linejoin="round" d="M12.5 6.5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2m5 0-.447-.894a2 2 0 0 0-1.79-1.106h-.527a2 2 0 0 0-1.789 1.106L7.5 6.5m5 0-1 1h-3l-1-1"></path>
                            </svg>
                            Copy
                        </span>
                    </button>
                    <div id='copiedDivReq3' class="hidden group/button absolute right-4 top-3.5 overflow-hidden rounded-full py-1 pl-2 pr-3 text-2xs font-medium opacity-0 backdrop-blur transition focus:opacity-100 group-hover:opacity-100 bg-emerald-400/10">
                        <span class="pointer-events-none flex items-center transition duration-300 text-[#6ee7b7] text-xs">
                            Copied!
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

<div class="grid grid-cols-1 items-start gap-x-16 gap-y-10 xl:max-w-none xl:grid-cols-2 mt-4 mb-2">
    <div class="[&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
        <h3 class='font-bold'>Ответ</h3>
        <div class="my-3">
            <ul role="list"
                class="m-0 list-none divide-y divide-zinc-900/5 p-0 dark:divide-white/5">
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd class='bg-[#f4f4f5] border-2 border-solid border-[#ececee] rounded-lg px-1 text-xs'><code >title</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">string</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none [&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
                            <p class='text-sm'>ФИО пользователя</p>
                        </dd>
                    </dl>
                </li>
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd class='bg-[#f4f4f5] border-2 border-solid border-[#ececee] rounded-lg px-1 text-xs'><code >ufCrm{ID смарт-процесса}IdUserCalendarSmb</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">integer</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none [&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
                            <p class='text-sm'>ID пользователя</p>
                        </dd>
                    </dl>
                </li>
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd class='bg-[#f4f4f5] border-2 border-solid border-[#ececee] rounded-lg px-1 text-xs'><code >ufCrm{ID смарт-процесса}NameCalendarSmb</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">string</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none [&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
                            <p class='text-sm'>Имя пользователя</p>
                        </dd>
                    </dl>
                </li>
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd class='bg-[#f4f4f5] border-2 border-solid border-[#ececee] rounded-lg px-1 text-xs'><code >ufCrm{ID смарт-процесса}SecondNameCalendarSmb</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">string</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none [&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
                            <p class='text-sm'>Отчество пользователя</p>
                        </dd>
                    </dl>
                </li>
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd class='bg-[#f4f4f5] border-2 border-solid border-[#ececee] rounded-lg px-1 text-xs'><code >ufCrm{ID смарт-процесса}LastNameCalendarSmb</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">string</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none [&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
                            <p class='text-sm'>Фамилия пользователя</p>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="my-6 overflow-hidden rounded-2xl bg-zinc-900 shadow-md dark:ring-1 dark:ring-white/10"><div class="not-prose"><div class="flex min-h-[calc(theme(spacing.12)+1px)] flex-wrap items-start gap-x-4 border-b border-zinc-700 bg-zinc-800 px-4 dark:border-zinc-800 dark:bg-transparent">
    <h3 class="mr-auto pt-3 text-xs font-semibold text-white">Ответ</h3>
    </div><div class="group dark:bg-white/2.5">
        <div class="relative">
<pre id='copyTextResponse1'  class="overflow-x-auto p-4 text-xs text-white"><code class="language-json"><span><span style="color: #fff">{</span></span>
<span><span style="color: #6ee7b7">  </span><span style="color: #7dd3fc">"result"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span></span>
<span><span style="color: #ffffff">    {</span></span>
<span><span style="color: #6ee7b7">  </span><span style="color: #7dd3fc">    "user"</span><span style="#ffffff">:</span></span>
<span><span style="color: #ffffff">        {</span></span>
<span><span style="color: #6ee7b7">  </span><span style="color: #7dd3fc">        "items"</span><span style="#ffffff">:</span><span style="#ffffff">   [</span></span>
<span><span style="color: #ffffff">           {</span></span>
<span><span style="color: #6ee7b7">             </span><span style="color: #7dd3fc">"title"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">Иванов Иван Ивавнович</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">             </span><span style="color: #7dd3fc">"ufCrm{ID смарт-процесса}IdUserCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">1</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">             </span><span style="color: #7dd3fc">"ufCrm{ID смарт-процесса}NameCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">Иван</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">             </span><span style="color: #7dd3fc">"ufCrm{ID смарт-процесса}SecondNameCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">Иванович</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">             </span><span style="color: #7dd3fc">"ufCrm{ID смарт-процесса}LastNameCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">Иванов</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">              </span><span style="color: #71717a">// ..</span></span>
<span><span style="color: #ffffff">            }</span><span style="#ffffff">,</span></span>
<span><span style="color: #ffffff">           {</span></span>
<span><span style="color: #6ee7b7">             </span><span style="color: #7dd3fc">"title"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">Иванов Иван Ивавнович</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">             </span><span style="color: #7dd3fc">"ufCrm{ID смарт-процесса}IdUserCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">1</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">             </span><span style="color: #7dd3fc">"ufCrm{ID смарт-процесса}NameCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">Иван</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">             </span><span style="color: #7dd3fc">"ufCrm{ID смарт-процесса}SecondNameCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">Иванович</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">             </span><span style="color: #7dd3fc">"ufCrm{ID смарт-процесса}LastNameCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">Иванов</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">              </span><span style="color: #71717a">// ..</span></span>
<span><span style="color: #ffffff">            }</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">           </span><span style="color: #71717a">// ..</span></span>
<span><span style="color: #ffffff">           ]</span></span>
<span><span style="color: #ffffff">         }</span><span style="#ffffff">,</span></span>
<span><span style="color: #ffffff">     }</span><span style="#ffffff">,</span></span>
<span><span style="color: #ffffff">}</span></span>
</code>
</pre>
            <button id='copyBtnResponse1' type="button" class="group/button absolute right-4 top-3.5 overflow-hidden rounded-full py-1 pl-2 pr-3 text-2xs font-medium opacity-0 backdrop-blur transition focus:opacity-100 group-hover:opacity-100 bg-white/5 hover:bg-white/7.5 dark:bg-white/2.5 dark:hover:bg-white/5">
                <span class="text-xs pointer-events-none flex items-center gap-0.5 text-zinc-400 transition duration-300 ">
                    <svg viewBox="0 0 20 20" aria-hidden="true" class="h-5 w-5 fill-zinc-500/20 stroke-zinc-500 transition-colors group-hover/button:stroke-zinc-400">
                        <path stroke-width="0" d="M5.5 13.5v-5a2 2 0 0 1 2-2l.447-.894A2 2 0 0 1 9.737 4.5h.527a2 2 0 0 1 1.789 1.106l.447.894a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2Z"></path>
                        <path fill="none" stroke-linejoin="round" d="M12.5 6.5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2m5 0-.447-.894a2 2 0 0 0-1.79-1.106h-.527a2 2 0 0 0-1.789 1.106L7.5 6.5m5 0-1 1h-3l-1-1"></path>
                    </svg>
                    Copy
                </span>
            </button>
            <div id='copiedDivResponse1' class="hidden group/button absolute right-4 top-3.5 overflow-hidden rounded-full py-1 pl-2 pr-3 text-2xs font-medium opacity-0 backdrop-blur transition focus:opacity-100 group-hover:opacity-100 bg-emerald-400/10">
                <span class="pointer-events-none flex items-center transition duration-300 text-[#6ee7b7] text-xs">
                    Copied!
                </span>
            </div>
        </div>
    </div></div></div>
</div>





<h1 class='font-bold mb-4 mt-4 text-base'>1. Получение пользователя</h1>
<div class="grid grid-cols-1 items-start gap-x-16 gap-y-10 xl:max-w-none xl:grid-cols-2 mt-4 mb-2">
    <div class="[&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
        <h3>Optional attributes</h3>
        <div class="my-6">
            <ul role="list"
                class="m-0 list-none divide-y divide-zinc-900/5 p-0 dark:divide-white/5">
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd><code>entityTypeId</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">integer</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none [&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
                        <p>ID смарт-процесса "Пользователи", его можно найти в url строке смарт-процесса <code>https://<?=$domen?>/crm/type/139/list/category/0/</code></p>
                        </dd>
                    </dl>
                </li>
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd><code>filter[ufCrm{ID смарт-процесса}IdUserCalendarSmb]</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">integer</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none [&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
                            <p>ID смарт-процесса "Пользователи"</p>
                        </dd>
                    </dl>
                </li>
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd><code>filter[id]</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">integer</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none [&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
                            <p>ID пользователя, его можно найти в url строке профиля пользователя <code>https://<?=$domen?>/company/personal/user/1/</code></p>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
</div>


<h1 class='font-bold mb-3 mt-4 text-xl'>Получение списка пользователей</h1>
<p>В результате запроса вы получите ФИО и ID всех пользователей</p>
<div class="grid grid-cols-1 items-start gap-x-16 gap-y-10 xl:max-w-none xl:grid-cols-2 mt-4 mb-2">
    <div class="[&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
        <h3 class='font-bold'>Атрибуты</h3>
        <div class="my-3">
            <ul role="list"
                class="m-0 list-none divide-y divide-zinc-900/5 p-0 dark:divide-white/5">
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd class='bg-[#f4f4f5] border-2 border-solid border-[#ececee] rounded-lg px-1 text-xs'><code >entityTypeId</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">integer</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none [&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
                            <p class='text-sm'>{ID смарт-процесса}, после установки приложения автоматически подставится</p>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="xl:top-24"><div class="my-6 overflow-hidden rounded-2xl bg-zinc-900 shadow-md dark:ring-1 dark:ring-white/10"><div class="not-prose"><div class="flex min-h-[calc(theme(spacing.12)+1px)] flex-wrap items-start gap-x-4 border-b border-zinc-700 bg-zinc-800 px-4 dark:border-zinc-800 dark:bg-transparent"><h3 class="mr-auto pt-3 text-xs font-semibold text-white">Запрос</h3><div class="-mb-px flex gap-4 text-xs font-medium" role="tablist" aria-orientation="horizontal"><button class="border-b py-3 transition ui-not-focus-visible:outline-none border-emerald-500 text-emerald-400" id="headlessui-tabs-tab-:R36chdtsqla:" role="tab" type="button" aria-selected="true" tabindex="0" data-headlessui-state="selected" aria-controls="headlessui-tabs-panel-:Rqchdtsqla:">cURL</button><button class="border-b py-3 transition ui-not-focus-visible:outline-none border-transparent text-zinc-400 hover:text-zinc-300" id="headlessui-tabs-tab-:R56chdtsqla:" role="tab" type="button" aria-selected="false" tabindex="-1" data-headlessui-state="" aria-controls="headlessui-tabs-panel-:R1achdtsqla:">1C (BSL)</button><button class="border-b py-3 transition ui-not-focus-visible:outline-none border-transparent text-zinc-400 hover:text-zinc-300" id="headlessui-tabs-tab-:R76chdtsqla:" role="tab" type="button" aria-selected="false" tabindex="-1" data-headlessui-state="" aria-controls="headlessui-tabs-panel-:R1qchdtsqla:">1C (Query)</button></div></div><div><div id="headlessui-tabs-panel-:Rqchdtsqla:" role="tabpanel" aria-labelledby="headlessui-tabs-tab-:R36chdtsqla:" tabindex="0" data-headlessui-state="selected"><div class="group dark:bg-white/2.5"><div class="flex py-2 items-center gap-2 border-y border-b-[hsla(0,0%,100%,.075)] border-t-transparent bg-white/2.5 bg-zinc-900 px-4 dark:border-b-white/5 dark:bg-white/1"><div class="dark flex"><span class="font-mono text-[0.625rem] font-semibold leading-6 text-emerald-500 dark:text-emerald-400">GET</span></div><span class="h-0.5 w-0.5 rounded-full bg-zinc-500"></span>
    <span class="font-mono text-xs text-zinc-400 text-wrap">https://<?=$domen?>/{veb-hook}/crm.item.list.json?entityTypeId={ID смарт-процесса}&filter[ufCrm{ID смарт-процесса}IdUserCalendarSmb]={ID пользователя}</span></div><div class="relative"><pre class="overflow-x-auto p-4 text-xs text-white"><code class="language-bash"><span><span style="color: var(--shiki-token-function)">curl</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">-L</span><span style="color: #6ee7b7">-g</span><span style="color: #6ee7b7">-X</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">https://<?=$domen?>/rest/7/07icb6l8ojacxqft/batch.json?halt=0&cmd[user]=crm.item.list%3FentityTypeId%3D139%26filter[ufCrm184IdUserCalendarSmb]%3D4&cmd[month_user]=crm.item.list%3FentityTypeId%3D149%26filter[ufCrm186IdUserCalendarSmb]%3D4%26filter[ufCrm186MonthCalendarSmb]%3D12</span></span>
    <span></span></code></pre><button type="button" class="group/button absolute right-4 top-3.5 overflow-hidden rounded-full py-1 pl-2 pr-3 text-2xs font-medium opacity-0 backdrop-blur transition focus:opacity-100 group-hover:opacity-100 bg-white/5 hover:bg-white/7.5 dark:bg-white/2.5 dark:hover:bg-white/5"><span aria-hidden="false" class="pointer-events-none flex items-center gap-0.5 text-zinc-400 transition duration-300"><svg viewBox="0 0 20 20" aria-hidden="true" class="h-5 w-5 fill-zinc-500/20 stroke-zinc-500 transition-colors group-hover/button:stroke-zinc-400"><path stroke-width="0" d="M5.5 13.5v-5a2 2 0 0 1 2-2l.447-.894A2 2 0 0 1 9.737 4.5h.527a2 2 0 0 1 1.789 1.106l.447.894a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2Z"></path><path fill="none" stroke-linejoin="round" d="M12.5 6.5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2m5 0-.447-.894a2 2 0 0 0-1.79-1.106h-.527a2 2 0 0 0-1.789 1.106L7.5 6.5m5 0-1 1h-3l-1-1"></path></svg>Copy</span><span aria-hidden="true" class="pointer-events-none absolute inset-0 flex items-center justify-center text-emerald-400 transition duration-300 translate-y-1.5 opacity-0">Copied!</span></button></div></div></div><span aria-hidden="true" id="headlessui-tabs-panel-:R1achdtsqla:" role="tabpanel" aria-labelledby="headlessui-tabs-tab-:R56chdtsqla:" tabindex="-1" style="position: fixed; top: 1px; left: 1px; width: 1px; height: 0px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; border-width: 0px;"></span><span aria-hidden="true" id="headlessui-tabs-panel-:R1qchdtsqla:" role="tabpanel" aria-labelledby="headlessui-tabs-tab-:R76chdtsqla:" tabindex="-1" style="position: fixed; top: 1px; left: 1px; width: 1px; height: 0px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; border-width: 0px;"></span><span aria-hidden="true" id="headlessui-tabs-panel-:R2achdtsqla:" role="tabpanel" aria-labelledby="headlessui-tabs-tab-:R96chdtsqla:" tabindex="-1" style="position: fixed; top: 1px; left: 1px; width: 1px; height: 0px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; border-width: 0px;"></span></div></div></div><div class="my-6 overflow-hidden rounded-2xl bg-zinc-900 shadow-md dark:ring-1 dark:ring-white/10"><div class="not-prose"><div class="flex min-h-[calc(theme(spacing.12)+1px)] flex-wrap items-start gap-x-4 border-b border-zinc-700 bg-zinc-800 px-4 dark:border-zinc-800 dark:bg-transparent"><h3 class="mr-auto pt-3 text-xs font-semibold text-white">Ответ</h3></div><div class="group dark:bg-white/2.5"><div class="relative"><pre class="overflow-x-auto p-4 text-xs text-white"><code class="language-json"><span><span style="color: #6ee7b7">{</span></span>
    <span><span style="color: #6ee7b7">  </span><span style="#6ee7b7">"result"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span></span>
    <span><span style="color: #6ee7b7">    {</span></span>
    <span><span style="color: #6ee7b7">  </span><span style="#6ee7b7">    "user"</span><span style="#ffffff">:</span></span>
    <span><span style="color: #6ee7b7">        {</span></span>
    <span><span style="color: #6ee7b7">  </span><span style="#6ee7b7">        "items"</span><span style="#ffffff">:</span><span style="#ffffff">   [</span></span>
    <span><span style="color: #6ee7b7">           {</span></span>
    <span><span style="color: #6ee7b7">             </span><span style="#6ee7b7">"title"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">Иванов Иван Ивавнович</span><span style="#ffffff">,</span><span style="#ffffff">  // Фамилия имя отчество пользователя</span></span>
    <span><span style="color: #6ee7b7">             </span><span style="#6ee7b7">"ufCrm{ID смарт-процесса}IdUserCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">1</span><span style="#ffffff">,</span><span style="#ffffff">  // {ID пользователя}</span></span>
    <span><span style="color: #6ee7b7">             </span><span style="#6ee7b7">"ufCrm111NameCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">Иван</span><span style="#ffffff">,</span><span style="#ffffff">  // Имя пользователя</span></span>
    <span><span style="color: #6ee7b7">             </span><span style="#6ee7b7">"ufCrm111SecondNameCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">Иванович</span><span style="#ffffff">,</span><span style="#ffffff">  // Отчество пользователя</span></span>
    <span><span style="color: #6ee7b7">             </span><span style="#6ee7b7">"ufCrm111LastNameCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">Иванов</span><span style="#ffffff">,</span><span style="#ffffff">  // Фамилия пользователя</span></span>
    <span><span style="color: #6ee7b7">             </span><span style="color: var(--shiki-token-comment)">// ..</span></span>
    <span><span style="color: #6ee7b7">            }</span></span>
    <span><span style="color: #6ee7b7">           ]</span></span>
    <span><span style="color: #6ee7b7">         }</span><span style="#ffffff">,</span></span>
    <span><span style="color: #6ee7b7">     }</span><span style="#ffffff">,</span></span>
    <span><span style="color: #6ee7b7">}</span></span>
    <span></span></code></pre>
    <button type="button" class="group/button absolute right-4 top-3.5 overflow-hidden rounded-full py-1 pl-2 pr-3 text-2xs font-medium opacity-0 backdrop-blur transition focus:opacity-100 group-hover:opacity-100 bg-white/5 hover:bg-white/7.5 dark:bg-white/2.5 dark:hover:bg-white/5"><span aria-hidden="false" class="pointer-events-none flex items-center gap-0.5 text-zinc-400 transition duration-300"><svg viewBox="0 0 20 20" aria-hidden="true" class="h-5 w-5 fill-zinc-500/20 stroke-zinc-500 transition-colors group-hover/button:stroke-zinc-400"><path stroke-width="0" d="M5.5 13.5v-5a2 2 0 0 1 2-2l.447-.894A2 2 0 0 1 9.737 4.5h.527a2 2 0 0 1 1.789 1.106l.447.894a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2Z"></path><path fill="none" stroke-linejoin="round" d="M12.5 6.5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2m5 0-.447-.894a2 2 0 0 0-1.79-1.106h-.527a2 2 0 0 0-1.789 1.106L7.5 6.5m5 0-1 1h-3l-1-1"></path></svg>Copy</span><span aria-hidden="true" class="pointer-events-none absolute inset-0 flex items-center justify-center text-emerald-400 transition duration-300 translate-y-1.5 opacity-0">Copied!</span></button></div></div></div></div>
</div>

<h1 class='font-bold mb-4 mt-8'>2. Получение месяца пользователя</h1>
<div class="xl:top-24"><div class="my-6 overflow-hidden rounded-2xl bg-zinc-900 shadow-md dark:ring-1 dark:ring-white/10"><div class="not-prose"><div class="flex min-h-[calc(theme(spacing.12)+1px)] flex-wrap items-start gap-x-4 border-b border-zinc-700 bg-zinc-800 px-4 dark:border-zinc-800 dark:bg-transparent"><h3 class="mr-auto pt-3 text-xs font-semibold text-white">Запрос</h3><div class="-mb-px flex gap-4 text-xs font-medium" role="tablist" aria-orientation="horizontal"><button class="border-b py-3 transition ui-not-focus-visible:outline-none border-emerald-500 text-emerald-400" id="headlessui-tabs-tab-:R36chdtsqla:" role="tab" type="button" aria-selected="true" tabindex="0" data-headlessui-state="selected" aria-controls="headlessui-tabs-panel-:Rqchdtsqla:">cURL</button><button class="border-b py-3 transition ui-not-focus-visible:outline-none border-transparent text-zinc-400 hover:text-zinc-300" id="headlessui-tabs-tab-:R56chdtsqla:" role="tab" type="button" aria-selected="false" tabindex="-1" data-headlessui-state="" aria-controls="headlessui-tabs-panel-:R1achdtsqla:">JavaScript</button><button class="border-b py-3 transition ui-not-focus-visible:outline-none border-transparent text-zinc-400 hover:text-zinc-300" id="headlessui-tabs-tab-:R76chdtsqla:" role="tab" type="button" aria-selected="false" tabindex="-1" data-headlessui-state="" aria-controls="headlessui-tabs-panel-:R1qchdtsqla:">Python</button><button class="border-b py-3 transition ui-not-focus-visible:outline-none border-transparent text-zinc-400 hover:text-zinc-300" id="headlessui-tabs-tab-:R96chdtsqla:" role="tab" type="button" aria-selected="false" tabindex="-1" data-headlessui-state="" aria-controls="headlessui-tabs-panel-:R2achdtsqla:">PHP</button></div></div><div><div id="headlessui-tabs-panel-:Rqchdtsqla:" role="tabpanel" aria-labelledby="headlessui-tabs-tab-:R36chdtsqla:" tabindex="0" data-headlessui-state="selected"><div class="group dark:bg-white/2.5"><div class="flex py-2 items-center gap-2 border-y border-b-[hsla(0,0%,100%,.075)] border-t-transparent bg-white/2.5 bg-zinc-900 px-4 dark:border-b-white/5 dark:bg-white/1"><div class="dark flex"><span class="font-mono text-[0.625rem] font-semibold leading-6 text-emerald-500 dark:text-emerald-400">GET</span></div><span class="h-0.5 w-0.5 rounded-full bg-zinc-500"></span>
<span class="font-mono text-xs text-zinc-400">https://<?=$domen?>/{veb-hook}/batch.json?halt=0&cmd[user]=crm.item.list?entityTypeId={ID смарт-процесса "Пользователи"}%26filter[ufCrm{ID смарт-процесса "Пользователи"}IdUserCalendarSmb]={ID пользователя}&cmd[month_user]=crm.item.list?entityTypeId={ID смарт-процесса "Месяц"}%26filter[ufCrm{ID смарт-процесса "Месяц"}IdUserCalendarSmb]={ID пользователя}%26filter[ufCrm{ID смарт-процесса "Месяц"}MonthCalendarSmb]={номер месяца}</span></div><div class="relative"><pre class="overflow-x-auto p-4 text-xs text-white"><code class="language-bash"><span><span style="color: var(--shiki-token-function)">curl</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">-G</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">https://api.protocol.chat/v1/messages</span><span style="color: #6ee7b7"> \</span></span>
<span><span style="color: #6ee7b7">  </span><span style="color: #6ee7b7">-H</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">"Authorization: Bearer {token}"</span><span style="color: #6ee7b7"> \</span></span>
<span><span style="color: #6ee7b7">  </span><span style="color: #6ee7b7">-d</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">conversation_id=xgQQXg3hrtjh7AvZ</span><span style="color: #6ee7b7"> \</span></span>
<span><span style="color: #6ee7b7">  </span><span style="color: #6ee7b7">-d</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">limit=</span><span style="color: var(--shiki-token-constant)">10</span></span>
<span></span></code></pre><button type="button" class="group/button absolute right-4 top-3.5 overflow-hidden rounded-full py-1 pl-2 pr-3 text-2xs font-medium opacity-0 backdrop-blur transition focus:opacity-100 group-hover:opacity-100 bg-white/5 hover:bg-white/7.5 dark:bg-white/2.5 dark:hover:bg-white/5"><span aria-hidden="false" class="pointer-events-none flex items-center gap-0.5 text-zinc-400 transition duration-300"><svg viewBox="0 0 20 20" aria-hidden="true" class="h-5 w-5 fill-zinc-500/20 stroke-zinc-500 transition-colors group-hover/button:stroke-zinc-400"><path stroke-width="0" d="M5.5 13.5v-5a2 2 0 0 1 2-2l.447-.894A2 2 0 0 1 9.737 4.5h.527a2 2 0 0 1 1.789 1.106l.447.894a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2Z"></path><path fill="none" stroke-linejoin="round" d="M12.5 6.5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2m5 0-.447-.894a2 2 0 0 0-1.79-1.106h-.527a2 2 0 0 0-1.789 1.106L7.5 6.5m5 0-1 1h-3l-1-1"></path></svg>Copy</span><span aria-hidden="true" class="pointer-events-none absolute inset-0 flex items-center justify-center text-emerald-400 transition duration-300 translate-y-1.5 opacity-0">Copied!</span></button></div></div></div><span aria-hidden="true" id="headlessui-tabs-panel-:R1achdtsqla:" role="tabpanel" aria-labelledby="headlessui-tabs-tab-:R56chdtsqla:" tabindex="-1" style="position: fixed; top: 1px; left: 1px; width: 1px; height: 0px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; border-width: 0px;"></span><span aria-hidden="true" id="headlessui-tabs-panel-:R1qchdtsqla:" role="tabpanel" aria-labelledby="headlessui-tabs-tab-:R76chdtsqla:" tabindex="-1" style="position: fixed; top: 1px; left: 1px; width: 1px; height: 0px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; border-width: 0px;"></span><span aria-hidden="true" id="headlessui-tabs-panel-:R2achdtsqla:" role="tabpanel" aria-labelledby="headlessui-tabs-tab-:R96chdtsqla:" tabindex="-1" style="position: fixed; top: 1px; left: 1px; width: 1px; height: 0px; padding: 0px; margin: -1px; overflow: hidden; clip: rect(0px, 0px, 0px, 0px); white-space: nowrap; border-width: 0px;"></span></div></div></div><div class="my-6 overflow-hidden rounded-2xl bg-zinc-900 shadow-md dark:ring-1 dark:ring-white/10"><div class="not-prose"><div class="flex min-h-[calc(theme(spacing.12)+1px)] flex-wrap items-start gap-x-4 border-b border-zinc-700 bg-zinc-800 px-4 dark:border-zinc-800 dark:bg-transparent"><h3 class="mr-auto pt-3 text-xs font-semibold text-white">Ответ</h3></div><div class="group dark:bg-white/2.5"><div class="relative"><pre class="overflow-x-auto p-4 text-xs text-white"><code class="language-json"><span><span style="color: #6ee7b7">{</span></span>
<span><span style="color: #6ee7b7">  </span><span style="#6ee7b7">"result"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span></span>
<span><span style="color: #6ee7b7">    {</span></span>
<span><span style="color: #6ee7b7">  </span><span style="#6ee7b7">    "month_user"</span><span style="#ffffff">:</span></span>
<span><span style="color: #6ee7b7">        {</span></span>
<span><span style="color: #6ee7b7">  </span><span style="#6ee7b7">        "items"</span><span style="#ffffff">:</span><span style="#ffffff">   [</span></span>
<span><span style="color: #6ee7b7">           {</span></span>
<span><span style="color: #6ee7b7">             </span><span style="#6ee7b7">"title"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">"Декабрь 2023"</span><span style="#ffffff">,</span><span style="#ffffff">  // Месяц</span></span>
<span><span style="color: #6ee7b7">             </span><span style="#6ee7b7">"ufCrm186TimeMonthCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">"00:25:23"</span><span style="#ffffff">,</span><span style="#ffffff">  // Суммарная продолжительность отработанного времени за месяц</span></span>
<span><span style="color: #6ee7b7">             </span><span style="#6ee7b7">"ufCrm186DayMonthCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">1</span><span style="#ffffff">,</span><span style="#ffffff">  // {ID пользователя}</span></span>
<span><span style="color: #6ee7b7">             </span><span style="#6ee7b7">"ufCrm186IdUserCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">10</span><span style="#ffffff">,</span><span style="#ffffff">  // Суммарное количество отработанных дней за месяц</span></span>
<span><span style="color: #6ee7b7">             </span><span style="#6ee7b7">"ufCrm186MonthCalendarSmb"</span><span style="#ffffff">:</span><span style="color: #6ee7b7"> </span><span style="color: #6ee7b7">1</span><span style="#ffffff">,</span><span style="#ffffff">  // {номер месяца}</span></span>
<span><span style="color: #6ee7b7">             </span><span style="color: var(--shiki-token-comment)">// ..</span></span>
<span><span style="color: #6ee7b7">            }</span></span>
<span><span style="color: #6ee7b7">           ]</span></span>
<span><span style="color: #6ee7b7">         }</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">     }</span><span style="#ffffff">,</span></span>
<span><span style="color: #6ee7b7">}</span></span>
<span></span></code></pre><button type="button" class="group/button absolute right-4 top-3.5 overflow-hidden rounded-full py-1 pl-2 pr-3 text-2xs font-medium opacity-0 backdrop-blur transition focus:opacity-100 group-hover:opacity-100 bg-white/5 hover:bg-white/7.5 dark:bg-white/2.5 dark:hover:bg-white/5"><span aria-hidden="false" class="pointer-events-none flex items-center gap-0.5 text-zinc-400 transition duration-300"><svg viewBox="0 0 20 20" aria-hidden="true" class="h-5 w-5 fill-zinc-500/20 stroke-zinc-500 transition-colors group-hover/button:stroke-zinc-400"><path stroke-width="0" d="M5.5 13.5v-5a2 2 0 0 1 2-2l.447-.894A2 2 0 0 1 9.737 4.5h.527a2 2 0 0 1 1.789 1.106l.447.894a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2Z"></path><path fill="none" stroke-linejoin="round" d="M12.5 6.5a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-5a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2m5 0-.447-.894a2 2 0 0 0-1.79-1.106h-.527a2 2 0 0 0-1.789 1.106L7.5 6.5m5 0-1 1h-3l-1-1"></path></svg>Copy</span><span aria-hidden="true" class="pointer-events-none absolute inset-0 flex items-center justify-center text-emerald-400 transition duration-300 translate-y-1.5 opacity-0">Copied!</span></button></div></div></div></div></div>

<div class="grid grid-cols-1 items-start gap-x-16 gap-y-10 xl:max-w-none xl:grid-cols-2 mt-4 mb-2">
    <div class="">
        <h3>Optional attributes</h3>
        <div class="my-6">
            <ul role="list"
                class="m-0 list-none divide-y divide-zinc-900/5 p-0 dark:divide-white/5">
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd><code>entityTypeId</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">integer</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none ">
                        <p>ID смарт-процесса "Пользователи", его можно найти в url строке смарт-процесса <code>https://<?=$domen?>/crm/type/139/list/category/0/</code></p>
                        </dd>
                    </dl>
                </li>
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd><code>filter[ufCrm{ID смарт-процесса}IdUserCalendarSmb]</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">integer</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none [&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
                            <p>ID смарт-процесса "Пользователи"</p>
                        </dd>
                    </dl>
                </li>
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd><code>filter[id]</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">integer</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none [&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
                            <p>ID пользователя, его можно найти в url строке профиля пользователя <code>https://<?=$domen?>/company/personal/user/1/</code></p>
                        </dd>
                    </dl>
                </li>
                <li class="m-0 px-0 py-4 first:pt-0 last:pb-0">
                    <dl class="m-0 flex flex-wrap items-center gap-x-3 gap-y-2">
                        <dt class="sr-only">Name</dt>
                        <dd><code>filter[ufCrm{ID смарт-процесса "Месяц"}MonthCalendarSmb]</code></dd>
                        <dt class="sr-only">Type</dt>
                        <dd class="font-mono text-xs text-zinc-400 dark:text-zinc-500">integer</dd>
                        <dt class="sr-only">Description</dt>
                        <dd class="w-full flex-none [&amp;>:first-child]:mt-0 [&amp;>:last-child]:mb-0">
                            <p>Номер месяца (1,2,3 ...)</p>
                        </dd>
                    </dl>
                </li>
            </ul>
        </div>
    </div>


    
</div>

<script src="js/manual.js"></script>
