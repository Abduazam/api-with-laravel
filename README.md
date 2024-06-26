<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Simple Laravel Rest-API project with Laravel Sanctum based on learning Laracasts API Master Class course.

### Installation

#### Install composer packages
```shell
composer install
```
#### Create .env file
```shell
cp .env.example .env
```
#### Generate Key
```shell
php artisan key:generate
```

#### Migrate
```shell
php artisan migrate
```

#### DB Seed
```shell
php artisan db:seed
```

#### Run
```shell
php artisan serve
```
### Default credentials
```shell
email: admin@admin.com
password: password
```

### Documentation
#### Used Scramble package to generate API doc inside projects
```
localhost:8000/docs/api
```
