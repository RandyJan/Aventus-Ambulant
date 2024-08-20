# Requirements
- PHP >= 7.4.*
- NODE >= v16.19.1
- NPM >= 8.19.3



# Installation

Open a terminal pointed into this project root directory.

Run
```
composer install
```

Create env file
```
cp .env.example .env
```

Generate Key
```
php artisan key:generate
```

Change `.env` variables with a  `required ` value according to your setup

# Optional Commands that can be use.
```
> npm run prod                          // run this command to minify js/css files
```
