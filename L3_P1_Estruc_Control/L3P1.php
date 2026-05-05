<?php require_once 'html/menu.html'; ?>

<main class="main-content">
    <div class="container">
        <?php require_once 'L3P1/html/header.html'; ?>

        <!-- Formulario con arrays, precios y botón limpiar -->
        <?php require_once 'L3P1/html/formulario.html'; ?>

        <!-- CONTENEDOR DONDE SE MOSTRARÁ LA FACTURA -->
        <div id="resultado-factura">

            <?php

            // PROCESAMIENTO PHP AL ENVIAR EL FORMULARIO

            if (isset($_POST['btnComprar'])) {

                try {

                    // Datos recibidos del formulario
                    $monitor_marca = isset($_POST['monitor_marca']) ? $_POST['monitor_marca'] : '';
                    $monitor_cant = isset($_POST['monitor_cant']) ? intval($_POST['monitor_cant']) : 0;
                    $cpu_marca = isset($_POST['cpu_marca']) ? $_POST['cpu_marca'] : '';
                    $cpu_cant = isset($_POST['cpu_cant']) ? intval($_POST['cpu_cant']) : 0;
                    $impresora_marca = isset($_POST['impresora_marca']) ? $_POST['impresora_marca'] : '';
                    $impresora_cant = isset($_POST['impresora_cant']) ? intval($_POST['impresora_cant']) : 0;
                    $edad_cliente = isset($_POST['edad_cliente']) ? intval($_POST['edad_cliente']) : 0;

                    // Precios unitarios usando el método de la clase Almacen 
                    $precio_monitor = $almacen->getPrecio('monitor', $monitor_marca);
                    $precio_cpu = $almacen->getPrecio('cpu', $cpu_marca);
                    $precio_impresora = $almacen->getPrecio('impresora', $impresora_marca);

                    // Carga del "Array Componente" 
                    $compra = array(
                        "Monitor" => array("marca" => $monitor_marca, "cantidad" => $monitor_cant, "precio" => $precio_monitor),
                        "CPU" => array("marca" => $cpu_marca, "cantidad" => $cpu_cant, "precio" => $precio_cpu),
                        "Impresora" => array("marca" => $impresora_marca, "cantidad" => $impresora_cant, "precio" => $precio_impresora)
                    );

                    // Alexandra: Validaciones y restricciones

                    // Si no se selecciono ningun producto
                    if ($monitor_cant == 0 && $cpu_cant == 0 && $impresora_cant == 0) {
                        throw new Exception("Compra vacía: debe seleccionar al menos un producto.");
                    }

                    // Validar edad vacía
                    if (empty($_POST['edad_cliente'])) {
                        throw new Exception("Edad requerida: debe ingresar su edad.");
                    }

                    // Validar rango de edad
                    if ($edad_cliente < 18 || $edad_cliente > 110) {
                        throw new Exception("Edad inválida: debe estar entre 18 y 110 años.");
                    }

                    // Revisar restricciones de cantidad
                    if ($monitor_cant > 1) {
                        throw new Exception("Solo se permite comprar máximo 1 monitor.");
                    }

                    if ($cpu_cant > 3) {
                        throw new Exception("Solo se permite comprar máximo 3 CPUs.");
                    }

                    // Luis: Cálculos (subtotal, ITBMS 7%, descuento 20%)

                    $subtotal = 0;

                    // Recorrido del array de compra (foreach obligatorio)
                    foreach ($compra as $item) {
                        $subtotal += $item['precio'] * $item['cantidad'];
                    }

                    // Descuento 20% si es mayor de 57 años
                    $descuento = ($edad_cliente > 57) ? ($subtotal * 0.20) : 0;

                    // Subtotal con descuento aplicado
                    $subtotal_descuento = $subtotal - $descuento;

                    // ITBMS 7% aplicado al subtotal ya con descuento
                    $itbms = $subtotal_descuento * 0.07;

                    // Total a pagar
                    $total = $subtotal_descuento + $itbms;

                    // Anthony: Salida / Detalle de factura

                    // Se incluye el archivo externo que muestra la factura
                    include 'L3P1/php/factura.php';
                } catch (Exception $e) {

                    // Mostrar error con Bootstrap
                    echo "<div class='alert alert-danger mt-3'>
                        <strong>Error:</strong><br>" . $e->getMessage() . "
                      </div>";
                }
            }

            ?>

        </div>
    </div>
</main>

<?php require_once 'L3P1/html/footer.html'; ?>