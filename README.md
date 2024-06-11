# Instalacion de proyecto

## levantar backend

1. [git clone ](https://github.com/HectorMarroquin/direcciones.git)
2. Configurar DB con credenciales "propias" .env (copiarse el .env.example):
2.  `composer install`
7.  `php artisan migrate`
8.  `php artisan db:seed --class=UserSeeder && php artisan db:seed --class=ContactosSeeder`
9.  `php artisan key:generate`
10. `php artisan serve --port=8000`

## levantar frontend

1. Acceder a carpeta Frontend
2. `npm install`
2. `ng serve`
4. Acceder con credenciales:
 * usuario: lider@gmail.com
 * contraseÃ±a: 1234

_Herramientas usadas:_

* Angular 17
* Laravel 9
* Laravel/sactum
* Postman
* Mysql
* Bootstrap

> Se deberan contar con las herramientas Angular CLI, composer y Algun gestor de DB
