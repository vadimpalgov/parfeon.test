###Модуль parfeon.test
 
Устанавливается из /bitrix/admin/partner_modules.php
Для работы нужно получить разрешение входящих webhook _parfeon:test_
 
Запросы будут в стиле:
https://example.local/rest/логин_пользователя/хеш_webhook/parfeon.test.list
 
#### Методы
 
 * parfeon.test.list - список записей (без сортировки)
 * parfeon.test.view - просмотр записи (параметр id)
 * parfeon.test.add - добавление записи (параметры бд кроме id)
 * parfeon.test.update - изменение записи (параметры бд)
 * parfeon.test.remove - удаление записи (параметр id)
 
 Проверки на POST нет.
 
#### Структура БД
 
 * id - int
 * name - varchar(255)
 * address - varchar(255)
 * created_at - varchar(255)
 * updated_at - varchar(255)