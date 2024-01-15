
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

<br/>

5. Generate the application key:
```bash
php artisan key:generate
```

<br/>

6. Generate the JWT Secret key:

```bash
php artisan jwt:secret
```

<br/>

7. Run database migrations and seeders
```bash
php artisan migrate --seed
```
> If you haven't created the DB manually, after you run the command above, you will get a warning that says 'The database 'products' does not exist on the 'mysql' connection.', please type **Y** then press **ENTER** to create the database in MySQL.

<br/>

8. Start the Development Server:

```bash
php artisan serve
```
