<?php
include 'conexion.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: listar.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente = $conexion->real_escape_string($_POST['cliente'] ?? '');
    $servicio = $conexion->real_escape_string($_POST['servicio'] ?? '');
    $cantidad = intval($_POST['cantidad'] ?? 0);
    $precio = floatval($_POST['precio'] ?? 0);
    $subtotal = floatval($_POST['subtotal'] ?? 0);
    $iva = floatval($_POST['iva'] ?? 0);
    $descuento = floatval($_POST['descuento'] ?? 0);
    $total = floatval($_POST['total'] ?? 0);

    if ($precio <= 0 || $cantidad <= 0) {
        $error = 'El precio y la cantidad deben ser mayores que cero.';
    } else {
        $stmt = $conexion->prepare(
            'UPDATE facturas SET cliente = ?, servicio = ?, cantidad = ?, precio = ?, subtotal = ?, iva = ?, descuento = ?, total = ? WHERE id = ?'
        );

        if ($stmt) {
            $stmt->bind_param('ssidddddi', $cliente, $servicio, $cantidad, $precio, $subtotal, $iva, $descuento, $total, $id);

            if ($stmt->execute()) {
                header('Location: listar.php?status=editado');
                exit;
            }

            $error = 'Error al actualizar: ' . $stmt->error;
            $stmt->close();
        } else {
            $error = 'Error al preparar la consulta: ' . $conexion->error;
        }
    }
}

$stmt = $conexion->prepare('SELECT * FROM facturas WHERE id = ?');
$stmt->bind_param('i', $id);
$stmt->execute();
$resultado = $stmt->get_result();
$fila = $resultado->fetch_assoc();
$stmt->close();

if (!$fila) {
    header('Location: listar.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Factura</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-slate-900 to-slate-700 min-h-screen p-10">
    <div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden">
        <div class="bg-black text-white p-8">
            <h1 class="text-5xl font-bold">Editar Factura</h1>
            <p class="text-gray-300 mt-3 text-lg">Actualiza los datos de la factura antes de guardar.</p>
        </div>

        <div class="p-10">
            <?php if ($error): ?>
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-5 text-red-800 shadow-sm">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form action="editar.php?id=<?php echo urlencode($id); ?>" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="bg-gray-50 p-8 rounded-3xl shadow-lg">
                        <h2 class="text-2xl font-bold mb-6 text-gray-700">Información del Cliente</h2>

                        <div class="mb-5">
                            <label class="block mb-2 font-semibold text-gray-700">Cliente</label>
                            <input type="text" name="cliente" required value="<?php echo htmlspecialchars($fila['cliente']); ?>" placeholder="Ingrese nombre"
                                class="w-full border-2 border-gray-200 focus:border-blue-500 outline-none p-4 rounded-2xl">
                        </div>

                        <div class="mb-5">
                            <label class="block mb-2 font-semibold text-gray-700">Servicio</label>
                            <select name="servicio" class="w-full border-2 border-gray-200 focus:border-blue-500 outline-none p-4 rounded-2xl">
                                <option value="Servicio Técnico" <?php echo $fila['servicio'] === 'Servicio Técnico' ? 'selected' : ''; ?>>Servicio Técnico</option>
                                <option value="Mensualidad" <?php echo $fila['servicio'] === 'Mensualidad' ? 'selected' : ''; ?>>Mensualidad</option>
                                <option value="Reparación" <?php echo $fila['servicio'] === 'Reparación' ? 'selected' : ''; ?>>Reparación</option>
                                <option value="Instalación" <?php echo $fila['servicio'] === 'Instalación' ? 'selected' : ''; ?>>Instalación</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block mb-2 font-semibold text-gray-700">Cantidad</label>
                                <input type="number" id="cantidad" name="cantidad" min="1" step="1" value="<?php echo htmlspecialchars($fila['cantidad']); ?>"
                                    class="w-full border-2 border-gray-200 focus:border-blue-500 outline-none p-4 rounded-2xl">
                            </div>
                            <div>
                                <label class="block mb-2 font-semibold text-gray-700">Precio</label>
                                <input type="number" id="precio" name="precio" min="0" step="0.01" value="<?php echo htmlspecialchars($fila['precio']); ?>"
                                    class="w-full border-2 border-gray-200 focus:border-blue-500 outline-none p-4 rounded-2xl">
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-900 text-white p-8 rounded-3xl shadow-lg">
                        <h2 class="text-2xl font-bold mb-6">Resumen de Factura</h2>

                        <div class="mb-5">
                            <label class="block mb-2">Descuento (%)</label>
                            <input type="number" id="descuento" min="0" max="100" step="1" value="<?php echo htmlspecialchars($fila['descuento']); ?>"
                                class="w-full bg-slate-800 border border-slate-600 p-4 rounded-2xl outline-none">
                        </div>

                        <div class="space-y-5">
                            <div>
                                <label class="block mb-2">Subtotal</label>
                                <input type="text" id="subtotal" readonly class="w-full bg-slate-800 border border-slate-600 p-4 rounded-2xl">
                                <input type="hidden" id="subtotalHidden" name="subtotal" value="<?php echo htmlspecialchars($fila['subtotal']); ?>">
                            </div>
                            <div>
                                <label class="block mb-2">IVA (19%)</label>
                                <input type="text" id="iva" readonly class="w-full bg-slate-800 border border-slate-600 p-4 rounded-2xl">
                                <input type="hidden" id="ivaHidden" name="iva" value="<?php echo htmlspecialchars($fila['iva']); ?>">
                            </div>
                            <input type="hidden" id="descuentoHidden" name="descuento" value="<?php echo htmlspecialchars($fila['descuento']); ?>">
                            <div>
                                <label class="block mb-2 text-xl font-bold">Total</label>
                                <input type="text" id="total" readonly class="w-full bg-green-600 text-white text-2xl font-bold p-5 rounded-2xl">
                                <input type="hidden" id="totalHidden" name="total" value="<?php echo htmlspecialchars($fila['total']); ?>">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-5 mt-10">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 transition text-white px-8 py-4 rounded-2xl text-lg font-semibold shadow-lg">Guardar cambios</button>
                    <a href="listar.php" class="bg-black hover:bg-gray-800 transition text-white px-8 py-4 rounded-2xl text-lg font-semibold shadow-lg">Volver a facturas</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        const precio = document.getElementById('precio');
        const cantidad = document.getElementById('cantidad');
        const descuento = document.getElementById('descuento');

        function calcular() {
            const precioValor = parseFloat(precio.value || 0);
            const cantidadValor = parseInt(cantidad.value || 0, 10);
            const descuentoValor = (parseFloat(descuento.value || 0) / 100) * (precioValor * cantidadValor);

            const subtotal = precioValor * cantidadValor;
            const iva = subtotal * 0.19;
            const total = subtotal + iva - descuentoValor;

            document.getElementById('subtotal').value = '$ ' + subtotal.toFixed(2);
            document.getElementById('subtotalHidden').value = subtotal.toFixed(2);
            document.getElementById('iva').value = '$ ' + iva.toFixed(2);
            document.getElementById('ivaHidden').value = iva.toFixed(2);
            document.getElementById('total').value = '$ ' + total.toFixed(2);
            document.getElementById('totalHidden').value = total.toFixed(2);
            document.getElementById('descuentoHidden').value = descuentoValor.toFixed(2);
        }

        precio.addEventListener('input', calcular);
        cantidad.addEventListener('input', calcular);
        descuento.addEventListener('input', calcular);
        calcular();
    </script>
</body>

</html>
