DOCKER_COMPOSE=docker compose

.ONESHELL:
.PHONY: help

H1=echo === ${1} ===
BR=echo
TAB=echo "\t"

help:
	@$(call H1,Application)
	$(TAB) make install - Собрать и запустить образы, composer install, создание тестовой БД
	$(TAB) make update - Пересобрать и перезапустить образы, composer install
	$(TAB) make test-php - Выполнить PHP проверки

install:
	${DOCKER_COMPOSE} build
	${DOCKER_COMPOSE} up -d
	cp .env.example .env
	cp .env.example .env.testing
	${DOCKER_COMPOSE} exec laravel.test composer install
	${DOCKER_COMPOSE} exec laravel.test artisan key:generate

update:
	${DOCKER_COMPOSE} down
	git pull
	${DOCKER_COMPOSE} build
	${DOCKER_COMPOSE} up -d
	${DOCKER_COMPOSE} exec laravel.test composer install

test-php:
	${DOCKER_COMPOSE} exec laravel.test composer fix
	${DOCKER_COMPOSE} exec laravel.test composer test

dinit:
	vendor/bin/deptrac init

danalyse:
	vendor/bin/deptrac analyse --config-file=deptrac.yaml --fail-on-uncovered --report-uncovered

test:
	vendor/bin/sail artisan test
