# Setup Guide for Running Locally

## Prerequisites

- PHP
- Composer
- Node.js & npm
- PostgreSQL

See the [prerequisites](prerequisites.md) page for detailed instructions.

## Steps

#### Clone the repository
```sh
git clone https://github.com/jonathank1906/Web-Technologies-Project.git
cd Web-Technologies-Project
```

#### Install PHP dependencies
```sh
composer install
```

#### Copy and configure environment file
```sh
cp .env.example .env
```
Copy and paste from [here](env.md).

#### Install Node.js dependencies
```sh
npm install
```

#### Build frontend assets
```sh
npm run build
```

#### Create the PostgreSQL database
```sh
psql -U postgres
```
Then, in the PostgreSQL prompt, run:
```sql
CREATE DATABASE laravel;
```
Type \q to exit.

#### Run database migrations
```sh
php artisan migrate
```

#### Start the development server
```sh
php artisan serve
```

#### Access the app
Visit [http://localhost:8000](http://localhost:8000) in your browser.
