Firstly clone the repository.

The superheroes project are two vue SPA and laravel REST API projects.

Laravel-app:

cd laravel-app/
cp env.example .env
php artisan key:generate

composer install

php artisan migrate
php artisan migrate:refresh

You should also add to storage/app/public/images an image(that represents that hero has no image yet, for example, where it is written 'no images yet') for these heroes who will not get any image.

php artisan serve - to run the app.


Vue-app:

cd vue-app/
npm install
in src/api/api.js change baseURL for Laravel-app API.

npm run serve
