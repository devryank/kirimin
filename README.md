<p align="center"><a href="https://laravel.com"
       target="_blank"><img
             src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg"
             width="400"></a></p>

<p align="center">
    <a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg"
             alt="Build Status"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img
             src="https://img.shields.io/packagist/dt/laravel/framework"
             alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img
             src="https://img.shields.io/packagist/v/laravel/framework"
             alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/laravel/framework"><img
             src="https://img.shields.io/packagist/l/laravel/framework"
             alt="License"></a>
</p>

## Introduction

Kirimin adalah wadah para pedagang untuk menjualkan dagangannya kepada lebih banyak calon pembeli secara online.

## Include

-   <a href="https://laravel-livewire.com/">Laravel Livewire 2.0</a>
-   <a href="https://jetstream.laravel.com/2.x/introduction.html">Jetstream 2.3</a>
-   <a href="https://spatie.be/docs/laravel-permission/v4/introduction">Spatie 4.2</a>
-   <a href="https://github.com/davidgrzyb/tailwind-admin-template">Tailwind Admin Template</a>

## Installation

Run these command from your terminal

```
git clone https://github.com/devryank/kirimin.git
```

-   rename `.env.example` to `.env`
-   setting your env
-   Composer command

```
composer install
composer dump-autoload
```

-   Artisan command

```
php artisan key:generate
php artisan migrate --seed
```

## Demo Credentials

### Superadmin

email : superadmin@app.test

password : password

### Seller

email : seller@app.test

password : password

### User

email : user@app.test

password : password
