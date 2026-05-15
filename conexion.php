<?php

$conexion = new mysqli(
    "localhost",
    "root",
    "",
    "sistema_cobro"
);

if ($conexion->connect_error) {

    die("Error de conexión");

}

?>