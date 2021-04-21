# README #

A todo web app with symfony backend and react frontend running on docker

To setup:

* `git clone https://github.com/martynas-developer/TODO-list todo`
* create .env from .env.template (`cp .env.template .env`)
* run `docker-compose up --build`

To run tests:
* `docker-compose exec php-service ./vendor/bin/phpunit --group integration`

