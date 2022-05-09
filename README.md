# HOOLY - TEST

```
git clone https://github.com/vaka440/hooly_test.git
cd invivox_test

docker compose up -d
```

## allez sur l'invité de commande de l'instance: ```back_symfony``` de Docker
## saisir les commandes suivantes :

```
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
php bin/console doctrine:fixtures:load
```

## accès au front: 

http://localhost:4201/

