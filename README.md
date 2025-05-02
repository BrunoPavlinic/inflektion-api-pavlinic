# api

## .env file setup
Set your .env file. You can create one by copying the .env.example file, renaming it to .env and pasting it into the root folder.

## Database setup
Set your database credentials in the .env file. Here is the list of the credentials:
- DB_CONNECTION
- DB_HOST
- DB_PORT
- DB_DATABASE
- DB_USERNAME
- DB_PASSWORD

## Install the dependencies
Run the composer install command to install the dependencies.
```
composer install
```
## Run database migrations
Run the database migrations command so that you have a fresh database available:
```
php artisan migrate
```

If you already have a database but you need to refresh it, run the following command:
```
php artisan migrate:refresh
```
This command will delete the database data, and then you can run the ```php artisan migrate``` again to create the database.

## Insert a new user
You can insert a new user using the following SQL command:
```
INSERT INTO users (name, email, password, created_at, updated_at) 
VALUES ('name', 'email@email.com', '{PASSWORD}', NOW(), NOW());
```
Note - you need to change the name, email, and password fields with proper values. Since the password is hashed, you need to generate a hash based on the password string. This can be done on the following site - https://fbutube.com/laravel-password-generator

## Start the server
```
php artisan serve
```

## Create application key
You will need to generate the application key. You can achieve this by going on the http://localhost:8000/ and clicking on the key generation button.