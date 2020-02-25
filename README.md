# P7


# Pré-requis

- Composer doit être installé sur votre ordinateur

- PHP 7.1.9 minimum

- Symfony 4.4.3 minimum




# Installation

## Etape 1

- Téléchargez ou clonez le projet dans le répertoire de votre choix. Pour le cloner utilisez la commande suivante :
> git clone https://github.com/morantg/P7.git

## Etape 2

- Configurez vos variables d'environnement dans le fichier .env (variable DATABASE_URL)

## Etape 3

- Installez les dépendances avec la commande suivante :
> composer install

## Etape 4

- Créez la base de donné :
> php bin/console doctrine:database:create

## Etape 5 

- Réalisez la migration de votre base de donnée avec la commande suivante :
> php bin/console doctrine:migrations:migrate

## Etape 6    

- Créez les clés SSH avec les commandes suivantes : 
> mkdir -p config/jwt

> openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096

> openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout

- Assignez la passphrase que vous avez choisi à la variable "JWT_PASSPHRASE=" dans le fichier .env

## Etape 7 (optionnel)    

- Vous pouvez tester l'application avec un jeu de données fictives.
Pour cela charger les fixtures avec la commande suivante : 
> php bin/console doctrine:fixtures:load

Vous pouvez maintenant tester l'application. 2 utilisateur et 1 admin on été créées.

- User 1 => mail : user@user.com, mot de passe : testtest

- User 2 => mail : user2@user.com, mot de passe : testtest

- Admin => mail : admin@admin.com, mot de passe : testtest


# Documentation

- Après l'installation du projet vous avez accès à la documentation ici :
> http://localhost:8000/swagger/index.html 
