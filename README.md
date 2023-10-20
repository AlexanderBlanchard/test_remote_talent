# Prueba Técnica para Full Stack Developer

## Descripción

##### Objetivo: Crear una aplicación web que permita a los usuarios generar URLs personalizadas con parámetros que afectan el contenido dinámico de una página. Además, cualquier parámetro nuevo y único ingresado por el usuario debe ser almacenado en una base de datos y simular un envío de un email.

## Requisitos
Docker y Docker Compose instalados.

## Instrucciones de Configuración
Clonar el Repositorio 

Configurar el archivo .env principal (para Docker)
Desde la raíz del proyecto, copia el archivo .env.example a .env (si no existe ya):

```bash
cp .env.example .env
```

Edita el archivo .env con las configuraciones de tu base de datos para imagen de Mysql de Docker:

```php
MYSQL_DATABASE=tu_base_de_datos_docker
MYSQL_USER=tu_usuario_docker
MYSQL_PASSWORD=tu_contraseña_docker
MYSQL_ROOT_PASSWORD=contraseña_root_docker
```

Configurar el archivo .env para el Backend (Laravel)
Dirígete a /backend y copia el archivo .env.example a .env:

```bash
cp .env.example .env
```

Edita el archivo con tus propias configuraciones, especialmente las relacionadas con la base de datos (coincidientes con la de la instancia de Mysql de Docker), adicionalmente añade el archivo de credenciales en /backend/credentials/firebase-credentials.json (que se compartio al correo):

```php
DB_DATABASE=db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña_laravel
FIREBASE_CREDENTIALS_PATH=/var/www/credentials/firebase-credentials.json
```

Construir y Ejecutar con Docker Compose
Desde la raíz del proyecto:

```bash
docker-compose up -d
```

## Acceso:

Backend (Laravel a través de Nginx): Accede a http://localhost:8001
Frontend: Accede a http://localhost:8080

## Estructura del Proyecto
##### /backend: Contiene el código fuente del backend en Laravel.
##### /frontend: Contiene el código fuente del frontend en Vue.js el cual se comunica con Backend(Laravel).
##### /backend/credentials: Lugar en donde estan las credenciales de Firebase. No olvides colocar las credenciales aquí.
