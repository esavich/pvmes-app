# pvmes-app
Блог на php, vue.js, mongodb и elasticsearch.

## Запуск
`docker-compose up` запустит все необходимые сервисы, приложение будет доступно по адресу `http://localhost:8080/`.

### Первый запуск
- используйте `docker-compose run --rm php composer install` для установки зависимостей composer.

- используйте `docker-compose run --rm node yarn` для установки JS  зависимостей.

## Разработка

- используйте `docker-compose run --rm php composer <команда>` для взаимодействия с composer.

- используйте `docker-compose run --rm -p 8081:8081 node yarn serve` для запуска dev-сервера vue с функцией горячей замены модулей и тд.

- используйте `docker-compose run --rm -p 8081:8081 node yarn build` для создания готовой для production сборки.
 

---
# In English
# pvmes-app
blog built with php, vue.js, mongo and elasticsearch.

## Running
use `docker-compose up` to run all services, app will be available at `http://localhost:8080/`.

### First launch
- use `docker-compose run --rm php composer install` to install composer dependencies.

- use `docker-compose run --rm node yarn` to install JS dependencies.


## Development

- use `docker-compose run --rm php composer <command>` to interact with composer.

- use `docker-compose run --rm -p 8081:8081 node yarn serve` to start vue dev server with HMR, live reload, etc. 

- use `docker-compose run --rm -p 8081:8081 node yarn build` to produce a production-ready bundle. 
 
