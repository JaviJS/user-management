# Mi Sistema de gestión de usuarios - Dockerizado

## Instrucciones de configuración

Dirigete a la carpeta user-management-system:
```
cd user-management-system
```
Luego copia el archivo .env.example y renombralo a .env:
```
cp .env.example .env
```

## Instrucciones de Uso

### Ejecutar compose

En la carpeta raiz del proyecto ejecuta el siguiente comando para levantar los contenedores con docker-compose:

```
docker-compose up --build -d
```
Esperar que las migraciones y seeder se ejecuten (se demora entre 30-60 segundos en establecer la conexión de la base de datos con el backend. Se reintenta cada 30 segundos la conexión).

Para detener y eliminar todos los contenedores asociados al proyecto, utiliza el siguiente comando:
```
docker-compose down
```

Ingresar en sitio
```
localhost:8001/
```
Usuario de prueba

- email : javivimi14@gmail.com
- contraseña : Goals123*