![enter image description here](https://zupimages.net/up/22/10/d249.jpg)

## Introduction 

Kartobuilder est un package php pour le framework laravel qui fonctionne avec la pile inertia jetstream pour construire votre propre carte. Ce package fonctionne avec [vue-leafleat](https://github.com/vue-leaflet/vue-leaflet) (vue3).

**This is a beta version, any contribution is appreciated.**

## Instalation guide

First download the package with composer : 

    composer require noxyz20/kartobuilder-laravel

Then install this with the artisan command

    php artisan kartobuilder:install

Finally migrate your bd and en build mix

    php artisan migrate
    npm install && npm run dev

## Usage 

The basic routes are `/maps` for creating our map and `/map/:id` for creating markers etc.

To rewrite these routes you can use the environment variable 

    KARTOBUILDER_ROUTE_ENABLE = true

