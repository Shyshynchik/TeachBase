1. Необходимо создать `.env`. Для этого необходимо выполнить следующие команды в терминале:
````shell
cd app
cp env.example .env
cd -
````
2. Далее необходимо заполнить `.env` файл. Для токенов необходимо ключ (любое слово) слово и алгоритм шифрования, например `HS256`. Если docker-compose не будет меняться, необходимо прописать следующее:
````dotenv
DB_DRIVER = pgsql
DB_HOST = postgres
DB_NAME = accounts
DB_USER = root
DB_PASSWORD = root
DB_PORT = 5432
````
3. Далее необходимо выполнить сборку и запуск `docker-compose` файла с помощью следующих команд:
````shell
docker-compose build
docker-compose up -d
````
4. Подключиться к контейнеру php. Для этого применить следующую команду:
````shell
docker ps
````
5. Найти контейнер php. Он будет иметь название `"название корневой папки"_php_1` и применить следующую команду:
````shell
docker exec -it "название контейнера" bash
````
6. Необходимо скачать зависимости через composer и инициализировать автозагрузку классов. Для этого выполнить следующие команды:
````shell
composer install
composer dump-autoload
````
7. Необходимо применить миграции к базе данных с помощью следующей команды:
````shell
php vendor/bin/phinx migrate
````
Endpoint'ы указаны в файле [swagger](swagger.yaml)