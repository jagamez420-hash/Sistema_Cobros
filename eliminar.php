<?php
include 'conexion.php';

if (!isset($_GET['id'])) {
    header('Location: listar.php');
    exit;
}

$id = intval($_GET['id']);

if ($id <= 0) {
    header('Location: listar.php');
    exit;
}

$stmt = $conexion->prepare('DELETE FROM facturas WHERE id = ?');

if ($stmt) {
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
}

header('Location: listar.php?status=eliminado');
exit;
