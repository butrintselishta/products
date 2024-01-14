
# App

## Getting Started
The instuctions below will get you a copy of the project up and running on your local machine for development and testing purposes.

### Requirements
Before setting up the project, ensure that your machine meets the following mandatory requirements:
```bash
- Git
- PHP Version 8.1
- Composer
- MySQL
```

## Application Setup
To set up the project on your **local machine**, follow these steps:

1. Clone the repository from Github:
```bash
git clone https://github.com/butrintselishta/products.git
```
<br/>

2. Navigate to the Project Folder by executing the following command:
```bash
cd products
```
<br/>

3. Install application's dependencies by writing this in your terminal:
```bash
composer install
```

<br/>

4. Copy `.env.example` to `.env` by executing this command in your terminal:
```bash
cp .env.example .env
```
##### NOTE about ***.env***
> This file contains all the configuration settings for your application. While it comes preloaded with default configurations, you may need to modify or append certain values to match your specific environment. For instance, **DB_DATABASE** relies on your MySQL database name choice, so ensure alignment accordingly.

<br/>

5. Generate the application key:
```bash
php artisan key:generate
```

<br/>

6. Run database migrations and seeders
##### Migrations IMPORTANT NOTE 1:
> Before running your migrations, ensure that you have the correct configuration for your database by checking and adjusting the following variables: `DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, and DB_PASSWORD`.

<br>

> While we need to run the seeders as well to create the dummy user (we will need it later).

Execute this command in your terminal:
```bash
php artisan migrate --seed
```
> If you haven't created the DB manually, after you run the command above you will get a warning that says 'The database 'products' does not exist on the 'mysql' connection.', please type **Y** then press **ENTER** to create the database in MySQL.

<br/>
7. Start the Development Server:

Initiate your development server by running the following command in your terminal:
```bash
php artisan serve
```
This command sets up the server and provides a convenient way to access your application for testing and development.
