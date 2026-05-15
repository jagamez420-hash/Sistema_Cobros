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
- `README.md` — documentación del proyecto
- `.gitignore` — archivos y carpetas ignoradas por Git

## Requisitos

- PHP 8+
- MySQL
- XAMPP, WAMP, Laragon o servidor local compatible
- Navegador web moderno

## Configuración de la base de datos

1. Abre tu administrador MySQL (por ejemplo, PHPMyAdmin).
2. Crea una base de datos llamada `sistema_cobro`.
3. Ejecuta la siguiente consulta SQL para crear la tabla `facturas`:

```sql
CREATE TABLE facturas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  cliente VARCHAR(255) NOT NULL,
  servicio VARCHAR(255) NOT NULL,
  cantidad INT NOT NULL,
  precio DECIMAL(12,2) NOT NULL,
  subtotal DECIMAL(12,2) NOT NULL,
  iva DECIMAL(12,2) NOT NULL,
  descuento DECIMAL(12,2) NOT NULL,
  total DECIMAL(12,2) NOT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

4. Asegúrate de que los valores de conexión en `conexion.php` sean correctos:

```php
$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "sistema_cobro"
);
```

Si tu servidor MySQL usa otro usuario o contraseña, actualiza `root` y `""`.

## Instalación y ejecución

1. Copia el proyecto a la carpeta raíz de tu servidor local (por ejemplo, `htdocs` en XAMPP).
2. Inicia Apache y MySQL desde tu panel de control local.
3. Abre el navegador y ve a `http://localhost/SistemaCobro/index.html` o `http://localhost:8000/index.html` si usas el servidor PHP embebido.
4. Crea una factura y luego revisa `http://localhost/SistemaCobro/listar.php` para ver los registros.

## Uso del servidor PHP integrado

Si prefieres ejecutar el proyecto sin XAMPP, en la carpeta del proyecto ejecuta:

```powershell
& 'C:\xampp\php\php.exe' -S localhost:8000 -t .
```

Luego abre `http://localhost:8000/index.html`.

## Notas importantes

- `index.html` utiliza JavaScript para calcular subtotal, IVA, descuento y total antes de enviar los datos.
- `guardar.php` y `editar.php` usan consultas preparadas para proteger las inserciones y actualizaciones.
- `listar.php` muestra las facturas guardadas y permite editar o eliminar registros.

## Repositorio

Este proyecto está publicado en GitHub:

- https://github.com/jagamez420-hash/Cuentacobros

## Licencia

Puedes usar este proyecto como base para tu propio sistema de facturación.
