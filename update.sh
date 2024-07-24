#!/bin/bash
echo "################################################"
echo "##                Actualizar database         ##"
echo "################################################"
docker exec -it csv-php php bin/console doctrine:schema:update --force
echo "################################################"
echo "##                Install assets              ##"
echo "################################################"
docker exec -ti csv-php php bin/console assets:install
echo "################################################"
echo "##                Clear cache                 ##"
echo "################################################"
docker exec -ti csv-php php bin/console cache:clear --env prod
docker exec -ti csv-php php bin/console cache:clear 
# sudo chmod -R 777 site/var/
# sudo chmod -R 777 site/storage/
sudo chmod -R 777 site/web/
# sudo chmod 777 site/storage/sqlite.db
