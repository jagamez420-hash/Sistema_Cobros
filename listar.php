<?php include 'conexion.php'; ?>

<!DOCTYPE html>
<html lang="es">

<head>

<meta charset="UTF-8">

<title>Facturas Guardadas</title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 p-10">

<div class="max-w-6xl mx-auto bg-white p-8 rounded-3xl shadow-2xl">

<h1 class="text-4xl font-bold mb-8">
Facturas Registradas
</h1>
<?php
$status = $_GET['status'] ?? '';
if ($status === 'guardado') {
    echo '<div class="mb-6 rounded-2xl border border-green-200 bg-green-50 p-5 text-green-800 shadow-sm">Factura guardada correctamente.</div>';
} elseif ($status === 'eliminado') {
    echo '<div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 p-5 text-amber-800 shadow-sm">Factura eliminada correctamente.</div>';
}
?>
<div class="mb-6 flex flex-wrap items-center justify-between gap-4">
    <a href="index.html" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl shadow-lg">Nueva Factura</a>
    <p class="text-sm text-slate-600">Aqu� puedes ver todas las facturas guardadas y eliminarlas si lo necesitas.</p>
</div>

<table class="w-full border-collapse text-sm">

<thead>

<tr class="bg-black text-white uppercase text-left">

<th class="p-3">ID</th>
<th class="p-3">Cliente</th>
<th class="p-3">Servicio</th>
<th class="p-3">Cantidad</th>
<th class="p-3">Subtotal</th>
<th class="p-3">IVA</th>
<th class="p-3">Descuento</th>
<th class="p-3">Total</th>
<th class="p-3">Acciones</th>

</tr>

</thead>

<tbody>

<?php

$sql = "SELECT * FROM facturas ORDER BY id DESC";

$resultado = $conexion->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    while ($fila = $resultado->fetch_assoc()) {
        ?>
        <tr class="border-b text-center hover:bg-slate-50">
            <td class="p-3 font-semibold"><?php echo htmlspecialchars($fila['id']); ?></td>
            <td class="p-3"><?php echo htmlspecialchars($fila['cliente']); ?></td>
            <td class="p-3"><?php echo htmlspecialchars($fila['servicio']); ?></td>
            <td class="p-3"><?php echo htmlspecialchars($fila['cantidad']); ?></td>
            <td class="p-3">$<?php echo number_format($fila['subtotal'], 2); ?></td>
            <td class="p-3">$<?php echo number_format($fila['iva'], 2); ?></td>
            <td class="p-3">$<?php echo number_format($fila['descuento'], 2); ?></td>
            <td class="p-3 font-bold text-green-700">$<?php echo number_format($fila['total'], 2); ?></td>
            <td class="p-3 space-x-2">
                <a href="editar.php?id=<?php echo urlencode($fila['id']); ?>" class="inline-block bg-slate-600 hover:bg-slate-700 text-white px-4 py-2 rounded-full">Editar</a>
                <a href="eliminar.php?id=<?php echo urlencode($fila['id']); ?>" class="delete-link inline-block bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-full">Eliminar</a>
            </td>
        </tr>
        <?php
    }
} else {
    ?>
    <tr class="border-b text-center">
        <td class="p-6" colspan="9">No hay facturas registradas.</td>
    </tr>
    <?php
}

?>

</tbody>

</table>

</div>

<script>
    document.querySelectorAll('.delete-link').forEach(link => {
        link.addEventListener('click', event => {
            if (!confirm('¿Eliminar esta factura?')) {
                event.preventDefault();
            }
        });
    });
</script>

</body>
</html>
