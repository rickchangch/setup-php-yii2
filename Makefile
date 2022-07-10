USER_NAME := $(USER)

run:
	USER=$(USER_NAME) docker-compose up -d
kill:
	USER=$(USER_NAME) docker-compose down -v
refresh:
	USER=$(USER_NAME) docker-compose down -v && \
	USER=$(USER_NAME) docker-compose pull --ignore-pull-failures && \
	USER=$(USER_NAME) docker-compose up -d

############

DC_FILENAME = docker-compose.yml
DC_FILENAME_MAC = docker-compose-for-mac.yml
USER := $(shell id -u)
GROUP := $(shell id -g)
WHOAMI = $(USER):$(GROUP)

.PHONE: build kill clean exec composer

build:
	WHOAMI=$(WHOAMI) docker compose -f $(DC_FILENAME) up -d

kill:
	docker compose -f $(DC_FILENAME) down

build-mac:
	WHOAMI=$(WHOAMI) docker compose -f $(DC_FILENAME_MAC) up -d

kill-mac:
	docker compose -f $(DC_FILENAME_MAC) down

kill-mac-vol:
	docker compose -f $(DC_FILENAME_MAC) down -v

clean-vol:
	docker volume rm -f $(docker volume ls -q)

terminal:
	docker exec -it fpm-app /bin/sh

composer-install:
	docker compose exec app composer install \
	--no-cache --ignore-platform-reqs
