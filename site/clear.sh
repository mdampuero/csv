#!/bin/bash
chmod -R 777 var/logs/
chmod -R 777 var/cache/
chmod -R 777 var/sessions/
php bin/console doctrine:schema:update --force
rm -r var/logs/*
rm -r var/cache/*
rm -r var/sessions/*
chmod -R 777 var/logs/
chmod -R 777 var/cache/
chmod -R 777 var/sessions/
