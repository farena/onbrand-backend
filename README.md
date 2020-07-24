# VueJs + Laravel Test for the company OnBrand

## INSTALLATION

    // Clone the repository
    git clone git@github.com:farena/onbrand-backend.git
    // Copy the file .env.example to .env
    cd onbrand-backend
    cp .env.example .env

    // Edit the .env file to configure the Database
    DB_CONNECTION=mysql
    DB_HOST=**HOST**
    DB_PORT=**PORT**
    DB_DATABASE=**DB NAME**
    DB_USERNAME=**DB USER**
    DB_PASSWORD=**DB PASSWORD**

    // Install Dependencies
    composer install

    // Run Migrations
    php artisan migrate --seed

    // Configure Passport with default options
    php artisan passport:install