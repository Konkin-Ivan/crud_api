# Тестовое задание для НОВЭКС
## Реализация API для CRUD, сущности User, на Symfony

### Развертывание и установка

Склонировать репозиторий и выполнить команды:
- make up (установка контейнеров)
- docker ps (проверить что все контейнеры запустились, если не все, то повторить make up)
- make install (установка зависимостей composer.json)

### Структура проекта

- рабочая директория: /web/
- публичная директория: /web/public/
- /web/src/Entity/User.php (Сущность User c полями и ограничениями)
- /web/src/Controller/UserController.php (контроллер для выполнения CRUD операций над пользователями)
- /web/config/packages/doctrine.yaml (настройка файловой системы)

### Тестирование
#### Postman
В корне репозитория прилагается файл CRUD API.postman_collection.json для Postman. В нем сделаны запросы к API:
- user_get (GET)
- user_create (POST)
- user_update (PUT)
- user_delete (DELETE)
#### Unit Tests
- make test