## Тестовое задание.
### Запуск
1. Настроить веб-сервер на папку www
1. Импортировать дамп таблиц dump/test-api-dump.sql
1. Настроить config.php подключение PDO к БД.


------------

## Примеры использования
Формат тела запроса/ответа  - json.

### Получение прав доступа для пользователя (id=1).

**Запрос:** GET /user/1/accessRights

**Ответ:**
`[
{
"send_messages": false
},
{
"service_api": true
},
{
"debug": false
}
]`

### Получение списка пользователей группы (id=1).

**Запрос:** GET /group/1/listUsers

**Ответ:**
`[
{
"id": 1
},
{
"id": 2
}
]`

### Добавить пользователя (id=3) в группу (id=1):

**Запрос:** POST /group/1/addUser

**Тело запроса:**
`{
"user_id": 3
}`

**Ответ:**
`{
"success": "1"
}`

### Удалить пользователя (id=3) из группы (id=1):

**Запрос:** DELETE /group/1/deleteUser

**Тело запроса**:
`{
"user_id": 3
}`

**Ответ**
`{
"success": "1"
}`



