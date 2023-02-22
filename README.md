## Description

API GraphQL en LARAVEL 10 y LighHouse

## Installation

```bash
$ composer install
$ npm install
```
Una vez instalados todos los paquetes ejecutar

```bash
# Ejecutar todas las migraciones de la base de datos
$ php artisan migrate

# Ejecutar un seeder con 10 registros
$ php artisan db:seed 

# Compilar estilos CSS y JS para uso de la utilidad Graphiql 
$ npm run build
```
## Running the app

```bash
# Ejecucion del servidor Laravel
$ php artisan serve

# EndPoint GraphQL
http://127.0.0.1:8000/graphql

# Documentacion y pruebas (Graphiql)
http://127.0.0.1:8000/graphiql
```


## Stay in touch

- Author - Brayan Duitama
<!-- - Website - [https://nestjs.com](https://nestjs.com/) -->
<!-- - Twitter - [@nestframework](https://twitter.com/nestframework) -->


## License

This is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
