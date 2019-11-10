#!/usr/bin/env sh

cd symfony
composer install
yarn install

php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load

yarn encore dev
