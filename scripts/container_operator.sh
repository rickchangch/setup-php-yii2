#!/bin/bash
set -e -u

SCRIPT_DIR="$( cd "$( dirname "$0" )" && pwd )"
TASK=""
ARGS=""

while getopts "t:a:" option
do
  case $option in
    t)  TASK="$OPTARG"
        ;;
    a)  ARGS="$OPTARG"
        ;;
  esac
done

case "$TASK" in
  composer-install)
    docker compose exec app composer install --no-cache --ignore-platform-reqs
    ;;
  composer-require)
    docker compose exec app composer require --prefer-dist $ARGS --no-cache --ignore-platform-reqs
    ;;
  migrate)
    docker compose exec app php yii migrate$ARGS
    ;;
  tty)
    docker exec -it $ARGS /bin/bash
esac
