# Installation

Requirements:
- Composer
- php 8.2 or higher
- some database server

```bash
cp .env.example .env
composer install
php artisan key:generate
```

Create a new database and update the database connection values in the `.env` file. 
Then run:

```bash 
php artisan migrate
```

# Running the app

You can use your favourite stack (Docker, Mamp, Homestead). Or just run:

```bash
php artisan serve
```

# Syncing colleagues via the API

Colleagues can be retrieved via the [api](https://pastebin.com/raw/uDzdKzGG), 
this can be done by running the following command: `php artisan schedule:run`.

# Run Tests

```bash
./vendor/bin/phpunit
```
