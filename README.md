# SistemaCobro

Sistema Profesional de Cobro desarrollado en PHP con Tailwind CSS. Permite:

- registrar facturas
- calcular subtotal, IVA y descuento
- listar facturas guardadas
- editar facturas existentes
- eliminar facturas

## Archivos principales

- `index.html` — formulario de ingreso de facturas
- `guardar.php` — guarda la factura en la base de datos
- `listar.php` — muestra las facturas guardadas
- `editar.php` — edita facturas existentes
- `eliminar.php` — elimina facturas
- `conexion.php` — conexión a MySQL

## Requisitos

- PHP 8+
- MySQL
- XAMPP o servidor local con PHP

## Uso

1. Colocar el proyecto en la raíz del servidor local.
2. Abrir `http://localhost:8000/index.html`.
3. Ingresar datos de la factura y guardar.
4. Ver y administrar facturas en `listar.php`.
