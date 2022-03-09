![enter image description here](https://zupimages.net/up/22/10/d249.jpg)

## Introduction 

Kartobuilder is a php package for the laravel framework that works with the inertia jetstream stack to build your own map. This package works with [vue-leafleat](https://github.com/vue-leaflet/vue-leaflet) (vue3).

**This is a beta version, any contribution is appreciated.**

## Instalation guide

First download the package with composer : 

    composer require noxyz20/kartobuilder-laravel

Then install this with the artisan command

    php artisan kartobuilder:install

Finally migrate your db and en build mix

    php artisan migrate
    npm install && npm run dev

## Usage 

The basic routes are `/maps` for creating our map and `/map/:id` for creating markers etc.

To rewrite these routes you can use the environment variable 

    KARTOBUILDER_ROUTE_ENABLE = true

