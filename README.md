## TechHub Store

TechHub Store es una plataforma web de venta de productos tecnológicos, creada para brindar una experiencia rápida, intuitiva y adaptable a distintos dispositivos. Integra catálogo dinámico, búsqueda y filtros, carrito de compras, autenticación de usuarios, historial de compras y herramientas de administración para la gestión de productos y permisos.

La solución está construida con PHP 8, POO, Bootstrap 5, JavaScript (AJAX) y MySQL.

## Tecnologías

- PHP 8
- MySQL 
- Bootstrap 5
- JavaScript
- XAMPP

## Estructura general


techhub-store/
├── app/
│   ├── config/
│   ├── controllers/
│   ├── core/
│   ├── models/
│   └── views/
│       ├── admin/
│       ├── auth/
│       ├── home/
│       ├── layouts/
│       └── orders/
├── public/
│   └── assets/
│       ├── css/
│       ├── img/
│       └── js/
├── sql/
├── storage/
│   └── logs/
├── index.php
└── README.md


## Instalación en XAMPP

1. Copia la carpeta `techhub-store` dentro de `C:/xampp/htdocs/`.
2. Inicia los servicios Apache y MySQL desde el panel de XAMPP.
3. Abre `http://localhost/phpmyadmin` en tu navegador, o utiliza otra herramienta de administración de bases de datos con acceso a MySQL.
4. Importa y ejecuta el archivo `sql/techhub_store.sql`. Este script creará la base de datos, las tablas y los datos de prueba necesarios para una navegación mínima.
5. Abre el proyecto en el navegador:
   - `http://localhost/techhub-store/`
   - `http://localhost:8080/techhub-store/` si Apache está configurado en el puerto 8080.

## Conexión a base de datos

La configuración de conexión ya viene predefinida en `app/config/config.php`:

- Host (`DB_HOST`): `localhost`
- Base de datos (`DB_NAME`): `techhub_store`
- Usuario (`DB_USER`): `root`
- Clave (`DB_PASS`): `gop2025`

Si trabajarás con MySQL en local desde XAMPP, sólo debes cambiar `DB_USER` y `DB_PASS` a los definidos en XAMPP. 
Si la base de datos se encuentra en otro servidor o entorno, deberás ajustar los valores de conexión, `DB_HOST`, `DB_USER` y `DB_PASS`, según corresponda.

## Usuarios de prueba

Credenciales:

- Administrador: `admin@techhub.cl`
- Usuario normal: `usuario@techhub.cl`

Ambos usuarios usan la contraseña: `12345678`

## Funcionalidades implementadas

- Catálogo responsivo de productos.
- Búsqueda y filtros por AJAX.
- Carrito persistente.
- Guardado de carrito en base de datos para usuarios autenticados.
- Registro e inicio de sesión.
- Panel de administración:
  - Crear productos
  - Editar productos
  - Eliminar productos
  - Cambiar permiso administrador a otros usuarios
- Historial de compras del usuario.


## Endpoints principales

Revisa el archivo `/documentacion.txt` para revisar el detalle.

## Diagrama MVC

Revisa la imagen `/diagrama_mvc.png` para ver el detalle del diagrama.


