#!/bin/sh

set -e

if [ "${1#-}" != "$1" ]; then
  set -- php-fpm "$@"
fi

FILE=composer.json
if [ -f "$FILE" ]; then
    echo "Installing required libraries..."
    composer install --prefer-dist --no-progress --no-interaction
else
    echo "$FILE not found."
fi

FILE=diceroll
if [ -f "$FILE" ]; then
    echo "Setting command..."
    dos2unix $FILE
    chmod +x $FILE
else
    echo "$FILE not found."
fi

exec docker-php-entrypoint "$@"