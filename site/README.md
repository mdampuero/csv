# Admin Panel
## Creator
Mauricio Ampuero <mdampuero@gmail.com>
## Install
### Clone
```
git clone https://gitlab.com/mdampuero/admin.git
```
### Install dependencies
```
php composer.phar install
```
### Configure parameters
```
parameters.yml
```
### Create database
```
php bin/console doctrine:database:create
```
### Update schema
```
php bin/console doctrine:schema:update --force
```
### Install assets
```
php bin/console assets:install
```
### Clear cache
```
sudo sh clear.sh
```
### Load initial data
```
php bin/console doctrine:fixtures:load
```
_This script created a user admin@email.com with password: 123456, enter from your browser to the url http://domain.com/admin/web_
### Clear cache
```
sudo sh clear.sh
```
# nortcuyo
