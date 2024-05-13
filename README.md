<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Hopital NApps
Bienvenido a la API para la gestión de pacientes del Hospital XYZ. Esta API permite a los médicos del hospital buscar pacientes, crear nuevos registros de pacientes y agregar diagnósticos a los pacientes existentes.

## Tecnologías
- Laravel
- Docker

# Esquema DB
<img src="dbdiagram.svg" alt="License">

# Documentación
<a href="https://documenter.getpostman.com/view/2104738/2sA3JNcgnX"> Ir a postman</a>

## Instalación
Estos pasos asumen que se tiene docker instalado en la maquina

 ```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
 ```
- cp .env.example .env
- vendor/bin/sail up -d
- vendor/bin/sail php artisan key:generate
- vendor/bin/sail php artisan migrate --seed

## Credenciales
apiToken: GgFjt0EkDfieG1Kc7EvYl9AZU6ND7q3v
