﻿# LazyRolls

Automatic motorized roller blinds project.

Моторизированный привод для рулонных штор. Управление по Wi-Fi. Питание внешнее. Возможна интеграция в системы умного дома.

### Ссылки
Описание проекта: [https://mysku.club/blog/diy/62110.html](https://mysku.club/blog/diy/62110.html)\
Файлы для печати: [https://www.thingiverse.com/thing:2857899](https://www.thingiverse.com/thing:2857899)\
Видео работы: [https://www.youtube.com/watch?v=lvBh_m7pOAI](https://www.youtube.com/watch?v=lvBh_m7pOAI)

### Плагины для систем умного дома
[Domoticz](https://github.com/ACE1046/LazyRollsDomoticz)\
[Hubitat Elevation](https://github.com/yix/Hubitat/blob/master/drivers/LazyRolls.groovy) (Автор [yix](https://github.com/yix))\
Home Assistant (встроенная поддержка через MQTT Discovery с версии 0.09)\
[Homebridge](https://github.com/vitva/Lazyroll-settings-for-homebridge) (Автор Vitva)\
[Управление с пульта ИК / RF433](https://mysku.club/blog/diy/87912.html) (Автор SamoS)
[Карточка управления шторами для HA](https://github.com/samoswall/pic-shutter-card) (Автор SamoS)
[Android приложение для управления шторами](https://github.com/samoswall/LazyRoll-Android-App) (Автор SamoS)

### Структура директорий

Firmware - готовые прошивки\
Source - исходный код\
Source\data - файлы для SPIFFS. Иконка, css-стили, java scripts\
Board - файлы схемы и платы для DipTrace\
Board\Gerbers - gerber files для заказа плат на фабрике\
3D_parts - OpenSCAD и stl для печати

### Changelog

05.04.2018 v0.01 beta
* Более-менее рабочая версия с настройками. Не всё доделано, многого не хватает.

07.04.2018 v0.02 beta
* Автосоздание файлов CSS и favicon в SPIFFS при их отсутствии/обновлении.

28.04.2018 v0.03 beta
* Исправлен баг с закрытием шторы после перезагрузки.
* Добавлена работа по расписанию.

22.02.2019 v0.05 beta
* Управление двигателями идёт в прерывании, увеличилась плавность работы двигателя и отзывчивость интерфейса.
* Номера пинов 4 и 5 исправлены, теперь типичное подключение ABCD. Настройки менять не надо.
* Концевик можно инвертировать (нормальнозамкнутый - нормальноразомкнутый). Актуально для датчика Холла вместо концевика.
* Добавлен http-запрос /set?pos=X (X = 0 - 100, в процентах).
* Состояние можно получить в виде XML по адресу /xml.
* Прошивка откомпилирована с поддержкой модулей с флеш памятью PUYA.
* Отображается размер SPIFFS, ссылка на форматирование появляется при ошибке файловой системы.

16.03.2019 v0.06
* Добавлен протокол MQTT. Описание настроек http://imlazy.ru/rolls/mqtt.html

10.04.2019 v0.07
* Добавлена встроенная в esp8266 подтяжка пина концевика. На платах NodeMCU и тому подобных, отпадает необходимость во внешнем резисторе, R8 по схеме.
* Добавлена настройка безопасного порога, количество шагов, при которых штора игнорирует концевик, пока не выползет из зоны его действия. Для герконов и датчиков Холла можно установить значение больше стандартных 100.

02.06.2020 v0.08
* Сделан плавный пуск двигателя. Это чуть повысило мощность мотора и максимальную скорость, но незначительно. Пока в черновой реализации и без какой-либо настройки.
* Прошивка проверена и скомпилирована с Arduino core for ESP8266 v2.7.1. Исправило отваливание wi-fi сети в некоторых случаях.
* Исправлен баг в JavaScript, из-за которого иногда лагал веб интерфейс, при загрузке страниц и сразу после.
* Во время движения по MQTT в формате JSON сообщается не только текущее положение, но и точка назначения (destination, в процентах).
* Синий светодиод теперь используется. Он кратко моргает при подаче питания. После каждой неудачной попытки подключиться к основной
сети зажигается на 1 секунду. Если к сети подключиться с трёх попыток не вышло, светодиод горит непрерывно, значит создана собственная WiFi сеть.
(Оранжевый светодиод программно не управляется, подключен напрямую к питанию. Его можно только отпаять/откусить/заклеить.)
В нормальной работе функцию диода можно указать в настройках, а также менять по http/mqtt. Более подробно [imlazy.ru/rolls/led.html](http://imlazy.ru/rolls/led.html).
* Отображается напряжение питания для новых плат. На старых, при желании, можно допаять два резистора. Цепочка Vin - 150K - esp_adc - 10K - GND.
* Исправлен баг с максимальным количеством шагов игнорирования концевика при опускании шторы. Теперь работают значения более 255. До 65000. Актуально для герконов и датчиков Холла. Спасибо acu73.
* Исправлен баг с невозможностью указать порт MQTT сервера более 9999. Спасибо George Tkachenko.

29.01.2021 v0.09
* Исправлен баг со сбивающимся временем.
* Пресеты для точного позиционирования шторы. Актуально для штор день/ночь. Положения задаются в настройках. Могут использоваться в расписании.
* Добавлены команды для MQTT. "=NNNNN" (без кавычек) - позиционирование шторы в шагах. "@N" - переход к пресету N.
* Добавлен http-запрос /set?steps=NNNNN (NNNNN = 0 - 65000, в шагах мотора).
* Добавлен http-запрос /set?preset=N (N = 1 - 5). Переход в заданное положение.
* Добавлено автоматическое перенаправление на страницу настроек при подключении к шторе в режиме точки доступа (первоначальная настройка).
* Добавлены MQTT-комманды open и close. Равнозначны on и off. Для удобства интеграции с HA.
* Добавлен MQTT Discovery для Home Assistant. Включается в настройках, автоматически добавляет штору в HA.
* Библиотека для работы с MQTT изменена с AdaFruit на PubSubClient (by Nicholas O'Leary).
* Концевик может быть установлен на полностью закрытое положение, вместо открытого. Например, для жалюзи.
* Проценты в MQTT командах и статусах можно поменять на обратные, т.е. 0% значит закрыто, 100% - открыто. Так по умолчанию считает Cover в Home Assistant.

30.03.2021 v0.10
* Исправлен баг с количеством шагов игнорирования концевика. Фактическое было в 8 раз меньше указанного в настройках.
* Повышена точность измерения напряжения, на платах с резисторами на ADC.
* Добавлена поддержка драйверов Step/Dir моторов (например, NEMA17). Можно подключать двигатели и драйвера от 3D принтеров. Распиновка пока фиксированная, En 4, Step 13, Dir 12.
* Минимальное время шага уменьшено до 50 мкс (было 100). Этого должно хватить, чтобы крутить обычный NEMA17 на практически максимальной скорости при 1/16 шага.
* В MQTT добавлен топик присутствия (alive/живой). В него отправляется "online" при подключении к MQTT и "offline" при отключении, в т.ч. аварийном, по "завещанию" (LWT). В Home Assistant используется как availability topic, для определения состояния привода.
* В настройках можно изменить количество шагов, которое привод прокручивает вверх в поисках концевика после предполагаемого нуля. Если поставить 0, запаса не будет. Если поставить большое число, будет дольше крутить вверх, пока не сработает концевик. Но в случае проблем с концевиком, может привести к перегреву мотора или поломке шторы. Менять не рекомендуется.
* Добавлена возможность подключения кнопки для управления. Подключается на Gnd и один из пинов GPIO 0(DTR)/2/3(RX), который выбирается в настройках. При движении нажатие кнопки останавливает штору, двойное нажатие - останавливает и перезапускает в противоположном направлении. Долгое нажатие (1 секунда) - отправляет в первый пресет или во второй, если штора уже в первом.
* Синий диод можно настроить на мигание при нажатии на кнопку.
* Легкий редизайн внешнего вида, в первую очередь мобильной версии. JS-код вынесен в отдельный файл в spiffs.
* Статичные файлы сжаты gzip'ом.
* Обновлена страница /update, добавлены подсказки по перепрошивке.

05.08.2021 v0.11
* Экспериментальная фича: режим мастер/ведомый по проводу. Подробнее [imlazy.ru/rolls/master.html](http://imlazy.ru/rolls/master.html).
* Помимо кнопки, можно задействовать ещё один дополнительный вход. Например, для геркона, определяющего открытие окна. Статус передаётся по MQTT в выбранный топик.
* Новый топик MQTT, сообщает в формате JSON состояние (ip, rssi, uptime, voltage, aux_input). При включенном HA MQTT Discovery, автоматически добавляет эти сенсоры в Home Assistant.
* (v0.11.2) Исправлен баг с получением времени по NTP при старте.

09.11.2021 v0.11.3
* Исправлен баг с отображением hostname в сети. В XML статус добавлен hostname. Разрешена отдача XML сторонним страницам (CORS). Спасибо Samos.

27.01.2022 v0.12
* В MQTT Discovery добавлены фичи Home Assistant 2021.11: ссылка на страницу конфигурации (visit device), доп. статусы попадают в раздел "Diagnostic".
* Добавлены команды click, longclick для MQTT и /set?click, /set?longclick для HTTP. Делают то же самое, что и кнопка управления (открыть/закрыть/стоп; пресет1/2). Для работы этих команд, включать аппаратную кнопку не требуется.
* Можно изменить название шторы в настройках, для удобства. Отображается в заголовке окна и в поле name в XML.
* Настройка статического IP.
* При прошивке на чистый модуль поле SSID остаётся пустым и привод сразу стартует в режиме точки доступа, а не пытается приконнектиться к несуществующей сети lazyrolls.
* Исправлена (надеюсь) верстка страницы расписания.
* Проект модифицирован для компиляции в PlatformIO, но можно откомпилировать и в ArduinoIDE. Часть кода переписана для экономии памяти. Arduino core for ESP8266 обновлено до v3.0.2.
* Добавлен лог событий. Открывается в веб-интерфейсе по ссылке из блока информации. Лог на английском, но думаю там и так понятно. Отображаются основные события, причина перезагрузки, отвалы от сети и mqtt-сервера, срабатывание концевика в движении, синхронизация времени. Для отладки возможных проблем.

10.12.2022 v0.13
* Поддержка приемника 433МГц.
* Восход и закат в расписании.
* Поддержка двух физических кнопок с возможностью выбирать действие по нажатию и, в режиме мастера, кем управлять. Можно сделать раздельные кнопки Открыть и Закрыть, а можно разделить кнопки для управления только этой шторой и всей группой.
* На главную страницу добавлены кнопки пресетов. В режиме мастера добавлен выбор, кем управлять, всеми, этой шторой или ведомыми.
* В режиме мастера можно в расписании раздельно управлять ведущим и ведомыми.
* Можно задать пароль для режима точки доступа, создаваемой после включения привода при отсутствии Wi-Fi.

26.01.2023 v0.13.1
* Добавлена единица измерения для напряжения в Home Assistant.

20.04.2023 v0.14
* Добавлена поддержка моторов постоянного тока, в том числе с энкодером. Подробнее [imlazy.ru/rolls/motor.html](http://imlazy.ru/rolls/motor.html).
* Добавлен второй концевик, на противоположной стороне.
* Добавлены команды MQTT. По команде "report" сообщает по MQTT свой статус. Командой "endstop" можно эмулировать нажатие концевика, например, zigbee датчиком открытия двери.
* По MQTT отправляются статусы open / opening / close / closing / stopped для Home Assistant.
* Добавлен gratuitous ARP. Привод постоянно сообщает свой IP в сети. Включается автоматически, если не используется MQTT. Может предотвратить некоторые случаи недоступности привода в сети.
* Сенсор Uptime в Home Assistant заменен на сенсор Last Restart Time. В mqtt топик info отправляются и аптайм, как раньше, и время рестарта.

16.01.2024 v0.15
* Плавный старт шагового мотора стал более плавным.
* Arduino core for ESP8266 обновлено до v3.1.2.
* Откомпилированные прошивки теперь универсальны, подходят для любого размера флэш-памяти.
* Изменения в MQTT: Обновлена интеграция с Home Assistant для совместимости с последней версией. Для наименования устройства используется не сетевое имя (hostname), а название (name), если оно заполнено в настройках. Недопустимые символы заменяются на подчеркивание, hostname теперь может содержать точку, без ошибки в логах HA.
* Retained команды удаляются и игнорируются при подключении к MQTT.
* В xml статус добавлены вход aux (если настроен), поле 'master' (значение 'yes' для мастера, 'no' - все остальные) и список пресетов и их значений.
* В настройках можно выбрать две скорости мотора. Их можно использовать, к примеру, для ручного (быстро) и автоматического (тихо) управления или для разных скоростей вверх и вниз. Вторую скорость можно использовать при управлении по расписанию, http, mqtt, rf и кнопками.
* Все настройки можно скачать/загрузить в виде файла на странице обновления прошивки.
* Команды для сброса положения и поиска нуля заново: 'zero' по mqtt, /set?zero по http. Команда 'reboot' по mqtt для перезагрузки.
* Сторожевой пингер. Включается в настройках. Раз в минуту пингует заданный IP (например, wifi-роутер). После неудачи, пинги повторяются каждые 10 секунд. 4 пропущенных подряд пинга записываются в Log. После 7 пропущенных пингов выполняется указанное в настройках действие (логирование / переподключение / перезагрузка). Интервал пинга и количество пропущенных пингов можно изменить константами PINGER_INTERVAL_S / PINGER_REPEAT_INTERVAL_S / PINGER_WARN / PINGER_ACTION в прошивке, при необходимости.
* Режим мастер/ведомый по WiFi. Теперь в дополнение к ведомым по проводу можно добавить ведомых по IP. На них распространяются все возможности управления, как и у проводных. Поддерживается до 10 ведомых в 5 группах (те же, что у проводных. В одной группе могут быть как проводные, так и беспроводные ведомые). Подробнее [imlazy.ru/rolls/master.html](http://imlazy.ru/rolls/master.html).
* В настройках добавлены кнопки включения WiFi у проводных ведомых, с отображением их IP после подключения к сети, для удобства настройки ведомых.
* В расписании можно установить самое раннее время срабатывания по солнцу, например "на рассвете, но не ранее 07:00".
* Положение шторы можно сохранять во flash-памяти, оно не теряется при перезагрузке. Включается в настройках. Не рекомендуется использовать без необходимости, ресурс памяти на запись ограничен, это может сократить срок службы. Если перезагрузка произойдет во время движения, положение не восстановится и потребуется поиск нуля.

17.01.2024 v0.15.2
* Исправлен баг, не появлялись кнопка Scan и пункт добавления IP в настройках wifi ведомых.
* Исправлен баг в wifi мастер/слейв режиме.

18.01.2024 v0.15.3
* Исправлен баг работы wifi мастер/слейв от аппаратных кнопок.
* При смене направления движения штора останавливает и плавно начинает двигаться в обратную сторону.
* Включена поддержка mDNS.

### Authors

* **ACE** - [e-mail](mailto:ace@imlazy.ru)
