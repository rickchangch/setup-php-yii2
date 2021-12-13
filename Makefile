DC_FILENAME = docker-compose.yml
USER := $(shell id -u)
GROUP := $(shell id -g)
WHOAMI = $(USER):$(GROUP)

.PHONE: build kill clean exec composer

build:
	WHOAMI=$(WHOAMI) docker compose -f $(DC_FILENAME) up -d

kill:
	docker compose -f $(DC_FILENAME) down

clean:
	docker volume rm -f $(docker volume ls -q)

exec:
	docker exec -it yii2-login-project-app-1 /bin/sh

composer:
	docker compose exec app composer install --no-cache --ignore-platform-reqs
