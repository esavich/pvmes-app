# pvmes-app
Блог на php, vue.js, mongodb.

## Запуск
`docker-compose up` запустит все необходимые сервисы, приложение будет доступно по адресу `http://localhost:8080/`.

### Первый запуск
- используйте `docker-compose run --rm php composer install` для установки зависимостей composer.

- используйте `docker-compose run --rm node yarn` для установки JS  зависимостей.

- используйте `docker-compose run --rm php php dummydata.php` для установки заполнения базы тестовыми данными.

- используйте `docker-compose run --rm node yarn build` для создания готовой для production сборки.

## Разработка

- используйте `docker-compose run --rm php composer <команда>` для взаимодействия с composer.

- используйте `docker-compose run --rm -p 8081:8081 node yarn serve` для запуска dev-сервера vue с функцией горячей замены модулей и тд.

 

---
# In English
# pvmes-app
blog built with php, vue.js, mongo and elasticsearch.

## Running
use `docker-compose up` to run all services, app will be available at `http://localhost:8080/`.

### First launch
- use `docker-compose run --rm php composer install` to install composer dependencies.

- use `docker-compose run --rm node yarn` to install JS dependencies.

- use `docker-compose run --rm php php dummydata.php` to fill database with test data.

- use `docker-compose run --rm node yarn build` to produce a production-ready bundle. 



## Development

- use `docker-compose run --rm php composer <command>` to interact with composer.

- use `docker-compose run --rm -p 8081:8081 node yarn serve` to start vue dev server with HMR, live reload, etc. 

