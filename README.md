# Smart Fish BD

## Installation

### Clone the repository

    git clone https://github.com/ArsssN/smart-fish-bd.git

### Switch to the repo folder

    cd smart-fish-bd

### Install all the dependencies using composer

    composer install

### Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

### Database configuration

    DB_DATABASE=your_database_name
    DB_USERNAME=your_user_name
    DB_PASSWORD=your_password

### Generate a new application key & storage link create

    php artisan key:generate 

### Create table & dummy data from seeder

    php artisan migrate --seed

### Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000
