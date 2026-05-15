<?php

include 'conexion.php';

$cliente = $conexion->real_escape_string($_POST['cliente'] ?? '');
$servicio = $conexion->real_escape_string($_POST['servicio'] ?? '');
$cantidad = intval($_POST['cantidad'] ?? 0);
$precio = floatval($_POST['precio'] ?? 0);
$subtotal = floatval($_POST['subtotal'] ?? 0);
$iva = floatval($_POST['iva'] ?? 0);
$descuento = floatval($_POST['descuento'] ?? 0);
$total = floatval($_POST['total'] ?? 0);

$stmt = $conexion->prepare(
    "INSERT INTO facturas (cliente, servicio, cantidad, precio, subtotal, iva, descuento, total) VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
);

if ($stmt) {
    $stmt->bind_param(
        'ssiddddd',
        $cliente,
        $servicio,
        $cantidad,
        $precio,
        $subtotal,
        $iva,
        $descuento,
        $total
    );

    if ($stmt->execute()) {
        header("Location: listar.php?status=guardado");
        exit;
    }

    echo "Error al guardar: " . $stmt->error;
    $stmt->close();
} else {
    echo "Error al preparar la consulta: " . $conexion->error;
}


?>