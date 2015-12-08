#!/usr/bin/env bash

DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
cd $DIR

# ensure composer is installed
if [ ! -f composer.phar ]; then
    curl -sS https://getcomposer.org/installer | php
fi

php composer.phar install --no-dev -o --prefer-dist
