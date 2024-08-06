# Présentation de l'application Symphony
Le projet Symphony est un réseau social musical. Il vise à créer une plateforme unique pour les utilisateurs afin de partager, découvrir et commenter de la musique. Contrairement aux réseaux sociaux existants, Symphony exige que tout le contenu publié contienne un fichier audio. Cela permet de créer un espace dédié à la musique, où les utilisateurs peuvent se connecter autour de leurs passions musicales communes.

# Tutoriel d'installation Symphony

## Téléchargement des dépendances et langages utilisés

### PHP

1. Téléchargez PHP version 8.2 : [Lien de téléchargement PHP](https://windows.php.net/download)
2. Extrayez le contenu du fichier ZIP téléchargé dans un dossier, par exemple `C:\php8.2`.
3. Ajoutez le chemin dans le `PATH` des variables systèmes des variables d'environnement.

### NodeJS

1. Téléchargez NodeJS : [Lien de téléchargement NodeJS](https://nodejs.org/)

### Composer

1. Téléchargez Composer : [Lien de téléchargement Composer](https://getcomposer.org/download/)

### PHPStorm

1. Téléchargez PHPStorm : [Lien de téléchargement PHPStorm](https://www.jetbrains.com/phpstorm/download/?source=google&medium=cpc&campaign=EMEA_en_FR_PhpStorm_Branded&term=phpstorm&content=604081944637&gad_source=1&gclid=CjwKCAjwr7ayBhAPEiwA6EIGxFczUDawEsii4YE_G1gwumvMV4zFrYlPdWTYHy2xhyis75dRnrw13xoCWmIQAvD_BwE#section=windows)
2. Cochez la case 'Add "bin" folder to the PATH'.
3. Redémarrez votre machine.


## Création du Projet

1. Ouvrez PHPStorm.
2. Allez sur `Get from VCS`.
3. Copiez l'URL du GitHub : [https://github.com/Ayolos/SymphonyApp.git](https://github.com/Ayolos/SymphonyApp.git)
4. Cliquez sur `Clone`.


## Ajout des extensions

Il est fort possible que l'extension OpenSSL nécessaire à Composer ne soit pas activée. Pour régler cela :

1. Allez dans votre dossier PHP, trouvez le fichier `php.ini-development` et renommez-le en `php.ini`.
2. Ouvrez le fichier `php.ini` et trouvez la ligne `;extension=openssl`.
3. Retirez le point-virgule pour obtenir la ligne `extension=openssl`.

Faites de même avec les lignes :
- `;extension=curl`
- `;extension=fileinfo`
- `;extension=mysqli`

Pour obtenir :
- `extension=curl`
- `extension=fileinfo`
- `extension=mysqli`

4. Sauvegardez le fichier.

### Résolution de l'erreur `Warning: PHP Startup: Unable to load dynamic library 'openssl'`

Si lorsque vous lancez php -v vous obtenez l'erreur `Warning: PHP Startup: Unable to load dynamic library ...`

1. Retournez dans votre `php.ini`.
2. Trouvez la ligne `;extension_dir =`.
3. Remplacez par `extension_dir = 'CheminVersPhp\ext'` en prenant soin d'enlever le `;`.

### Vérification de l'installation

Ouvrez à nouveau PHPStorm et lancez les commandes suivantes dans le terminal pour vérifier que votre installation est correcte :

```sh
php -v
node -v
npm -v
composer -V
```
Si une ou plusieurs de ces commandes ne fonctionnent pas, redémarrez votre machine.


## Setup du Projet

### Installation des dépendances

Pour lancer le setup du projet, exécutez les commandes suivantes dans le terminal :

```sh
npm install
npm update
composer install
composer update
```
Cela installera toutes les librairies requises.

### Configuration du fichier .env

1. Renommez le fichier `.env.example` en `.env`.
2. Copiez et collez ce qui suit dans votre fichier .env :
```sh
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:1LQm0jfSH7M+boelDrRtVoUXa0bpYTn+aftToiVkhPw=
APP_DEBUG=true
APP_URL=http://localhost:8000/

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=database
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_APP_NAME="${APP_NAME}"
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### Compilation des assets

1. Pour compiler le CSS et JS, exécutez :
npm run dev

2. Dans un autre terminal, lancez le serveur PHP :
php artisan serve

3. Cliquez ensuite sur le lien localhost proposé dans le terminal


## Connection à la base de données

Lorsque vous lancez le projet, vous pourriez rencontrer une erreur de connexion à la base de données. Pour résoudre ce problème, suivez ces étapes :

1. **Créer un fichier SQLite :**
   - Créez un fichier nommé `database.sqlite` dans le dossier `database`.

2. **Configurer la base de données dans PHPStorm :**
   - Allez dans l'onglet **Database** à droite de PHPStorm.
   - Cliquez sur le **+** à gauche de la fenêtre.
   - Sélectionnez **Data Source**, puis **SQLite**.
   - Une fenêtre s'ouvre. Dans le champ **File**, cliquez sur les trois points pour parcourir jusqu'à votre nouveau fichier `database.sqlite`.
   - Cliquez sur **Test Connection**.
   - Mettez à jour les drivers comme proposé.
   - Cliquez sur **OK**.

3. **Exécuter les migrations :**
   - Dans un terminal sur PHPStorm, lancez la commande :

```sh
php artisan migrate:fresh
```


Vous pouvez désormais acceder à l'application.
