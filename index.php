<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Sistema Profesional de Cobro</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gradient-to-r from-slate-900 to-slate-700 min-h-screen p-10">

    <div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-2xl overflow-hidden">

        <!-- HEADER -->

        <div class="bg-black text-white p-8">

            <h1 class="text-5xl font-bold">
                Sistema Profesional de Cobro
            </h1>

            <p class="text-gray-300 mt-3 text-lg">
                Gestión de facturación y cobros
            </p>

        </div>

        <!-- CONTENIDO -->

        <div class="p-10">

            <form action="guardar.php" method="POST">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                    <!-- CLIENTE -->

                    <div class="bg-gray-50 p-8 rounded-3xl shadow-lg">

                        <h2 class="text-2xl font-bold mb-6 text-gray-700">
                            Información del Cliente
                        </h2>

                        <div class="mb-5">

                            <label class="block mb-2 font-semibold text-gray-700">
                                Cliente
                            </label>

                            <input
                                type="text"
                                name="cliente"
                                required
                                placeholder="Ingrese nombre"
                                class="w-full border-2 border-gray-200 focus:border-blue-500 outline-none p-4 rounded-2xl">

                        </div>

                        <div class="mb-5">

                            <label class="block mb-2 font-semibold text-gray-700">
                                Servicio
                            </label>

                            <select
                                name="servicio"
                                class="w-full border-2 border-gray-200 focus:border-blue-500 outline-none p-4 rounded-2xl">

                                <option value="Servicio Técnico">
                                    Servicio Técnico
                                </option>

                                <option value="Mensualidad">
                                    Mensualidad
                                </option>

                                <option value="Reparación">
                                    Reparación
                                </option>

                                <option value="Instalación">
                                    Instalación
                                </option>

                            </select>

                        </div>

                        <div class="grid grid-cols-2 gap-4">

                            <div>

                                <label class="block mb-2 font-semibold text-gray-700">
                                    Cantidad
                                </label>

                                <input
                                    type="number"
                                    id="cantidad"
                                    name="cantidad"
                                    value="1"
                                    class="w-full border-2 border-gray-200 focus:border-blue-500 outline-none p-4 rounded-2xl">

                            </div>

                            <div>

                                <label class="block mb-2 font-semibold text-gray-700">
                                    Precio
                                </label>

                                <input
                                    type="number"
                                    id="precio"
                                    name="precio"
                                    placeholder="$0"
                                    class="w-full border-2 border-gray-200 focus:border-blue-500 outline-none p-4 rounded-2xl">

                            </div>

                        </div>

                    </div>

                    <!-- FACTURA -->

                    <div class="bg-slate-900 text-white p-8 rounded-3xl shadow-lg">

                        <h2 class="text-2xl font-bold mb-6">
                            Resumen de Factura
                        </h2>

                        <div class="mb-5">

                            <label class="block mb-2">
                                Descuento (%)
                            </label>

                            <input
                                type="number"
                                id="descuento"
                                value="0"
                                class="w-full bg-slate-800 border border-slate-600 p-4 rounded-2xl outline-none">

                        </div>

                        <div class="space-y-5">

                            <div>

                                <label class="block mb-2">
                                    Subtotal
                                </label>

                                <input
                                    type="text"
                                    id="subtotal"
                                    name="subtotal"
                                    readonly
                                    class="w-full bg-slate-800 border border-slate-600 p-4 rounded-2xl">
                            </div>

                            <div>

                                <label class="block mb-2">
                                    IVA (19%)
                                </label>

                                <input
                                    type="text"
                                    id="iva"
                                    name="iva"
                                    readonly
                                    class="w-full bg-slate-800 border border-slate-600 p-4 rounded-2xl">

                            </div>

                            <input
                                type="hidden"
                                id="descuentoHidden"
                                name="descuento">

                            <div>

                                <label class="block mb-2 text-xl font-bold">
                                    Total
                                </label>

                                <input
                                    type="text"
                                    id="total"
                                    name="total"
                                    readonly
                                    class="w-full bg-green-600 text-white text-2xl font-bold p-5 rounded-2xl">

                            </div>

                        </div>

                    </div>

                </div>

                <!-- BOTONES -->

                <div class="flex flex-wrap gap-5 mt-10">

                    <button
                        type="submit"
                        class="bg-blue-600 hover:bg-blue-700 transition text-white px-8 py-4 rounded-2xl text-lg font-semibold shadow-lg">

                        Guardar Factura

                    </button>

                    <a
                        href="listar.php"
                        class="bg-black hover:bg-gray-800 transition text-white px-8 py-4 rounded-2xl text-lg font-semibold shadow-lg">

                        Ver Facturas

                    </a>

                </div>

            </form>

        </div>

    </div>

    <script>

        const precio =
            document.getElementById('precio');

        const cantidad =
            document.getElementById('cantidad');

        const descuento =
            document.getElementById('descuento');

        function calcular() {

            let subtotal =

                (parseFloat(precio.value || 0)) *

                (parseFloat(cantidad.value || 0));

            let iva = subtotal * 0.19;

            let descuentoValor =

                subtotal *

                ((parseFloat(descuento.value || 0)) / 100);

            let total = subtotal + iva - descuentoValor;

            document.getElementById('subtotal').value =
                "$ " + subtotal.toFixed(2);

            document.getElementById('iva').value =
                "$ " + iva.toFixed(2);

            document.getElementById('total').value =
                "$ " + total.toFixed(2);

            document.getElementById('descuentoHidden').value =
                descuentoValor.toFixed(2);

        }

        precio.addEventListener('input', calcular);

        cantidad.addEventListener('input', calcular);

        descuento.addEventListener('input', calcular);

    </script>

</body>

</html>