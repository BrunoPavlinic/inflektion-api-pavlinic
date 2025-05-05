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
## Create a new database, and execute the following SQL to create the successful_emails table
```
CREATE TABLE `successful_emails` (
  `id` int NOT NULL AUTO_INCREMENT,
  `affiliate_id` mediumint NOT NULL, //the list's affiliate ID, ignore
  `envelope` text NOT NULL, //field from the Sendgrid webook, ignore
  `from` varchar(255) NOT NULL, //field from the Sendgrid webook, ignore
  `subject` text NOT NULL, //field from the Sendgrid webook, ignore
  `dkim` varchar(255) DEFAULT NULL, //field from the Sendgrid webook, ignore
  `SPF` varchar(255) DEFAULT NULL, //field from the Sendgrid webook, ignore
  `spam_score` float DEFAULT NULL, //field from the Sendgrid webook, ignore
  `email` longtext NOT NULL, //the raw email payload, including headers.  parse this
  `raw_text` longtext NOT NULL, //save the plain text content in this column
  `sender_ip` varchar(50) DEFAULT NULL, //field from the Sendgrid webook, ignore
  `to` text NOT NULL, //field from the Sendgrid webook, ignore
  `timestamp` int NOT NULL, //incoming timestamp of the email, ignore
  PRIMARY KEY (`id`),
  KEY `affiliate_index` (`affiliate_id`)
);

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
VALUES ('name', 'root@email.com', 'password', NOW(), NOW());
```
Note - you need to change the name, email, and password fields with proper values. Since the password is hashed, you need to generate a hash based on the password string. This can be done on the following site - https://fbutube.com/laravel-password-generator

Note - 'password' hash is '$2y$10$Um79vFWrpyEcsLJ022SveOmdkCzyId8bC9xzf7uOKbrKbECWi/Ni'.

## Start the server
```
php artisan serve
```

## Create application key
You will need to generate the application key. You can achieve this by going on the http://localhost:8000/ and clicking on the key generation button.

## Test the API using the inflektion-api-pavlinic.postman_collection.json POSTMAN collection
This collection is located in the root folder of the project.
Login request has an email and password field. Use the email and password from the user you created in the previous step.
