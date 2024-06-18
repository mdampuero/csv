#!/bin/bash
sudo docker-compose -f docker/docker-compose.yaml up -d
echo "################################################"
echo "##          Installing dependencies           ##"
echo "################################################"
sudo docker exec -ti csv-php composer install
echo "################################################"
echo "##                Crear database              ##"
echo "################################################"
sudo docker exec -it csv-php php bin/console doctrine:database:drop --force
sudo docker exec -it csv-php php bin/console doctrine:database:create
sudo docker exec -it csv-php php bin/console doctrine:schema:update --force
sudo docker exec -it csv-php php bin/console doctrine:fixture:load
sudo docker exec -ti csv-php php bin/console assets:install
echo "################################################"
echo "##                Clear cache                 ##"
echo "################################################"
sudo docker exec -ti csv-php php bin/console cache:clear --env prod
echo "################################################"
echo "##     Running on http://localhost:8088/      ##"
echo "################################################"
# sudo chmod -R 777 site/var/
# sudo chmod -R 777 site/storage/
sudo mkdir -p site/web/uploads/xs/
sudo mkdir -p site/web/uploads/sm/
sudo mkdir -p site/web/uploads/md/
sudo mkdir -p site/web/uploads/lg/
sudo mkdir -p site/web/uploads/xl/
sudo mkdir -p site/web/uploads/or/

sudo chmod -R 777 site/web/
sudo chmod -R 777 site/web/uploads
