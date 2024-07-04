# Mi Sistema de gestión de usuarios - Backend

## Versiones
| Nombre | Version    |
|----------|----------|
| Php      | 8.1      | 
| Laravel  | 10       | 
## Instrucciones de Uso para ejecutar el proyecto sin docker

Primero instalamos las dependencias:

```
composer install
```
Copia el archivo de configuracion de ejemplo y configura tu entorno:
```
cp .env.example .env
```
Configura el archivo .env:
```
APP_URL_COMPLETE=url_servidor
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base_de_datos
DB_USERNAME=tu_usuario_de_base_de_datos
DB_PASSWORD=tu_contraseña_de_base_de_datos
```
Genera la key del proyecto
```
php artisan key:generate
```
Genera las migraciones y seeder del proyecto:
```
php artisan migrate -- seed
```
Si quieres volver a generar las migraciones, utiliza el siguiente comando:
```
php artisan migrate:fresh --seed
```

Y por ultimo, ejecuta el proyecto con el siguiente comando:
```
php artisan serve
```

Probar test:
```
php artisan test
```

Probar test y ver cobertura:
```
php artisan test --coverage
```