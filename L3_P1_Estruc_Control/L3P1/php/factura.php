<?php

/* detalle_factura.php
 * 
 * Este archivo procesa y muestra un array MULTIDIMENSIONAL ASOCIATIVO.
 * Estructura esperada de $compra:
 */

// Validacion de datos
// Verificamos que todas las variables necesarias existan
if (!isset($compra, $subtotal, $itbms, $descuento, $total)) {
    echo "<div class='alert alert-danger'>No hay datos de factura disponibles.</div>";
    return;
}
?>

<!-- Contenedor principal de la factura -->
<div class="resultado-section mt-4">

    <h4 class="mb-3 text-primary">🧾 Detalle de Factura</h4>

    <!-- Tabla de desglose de productos -->
    <table class="table table-bordered table-hover">
        <thead class="table-light">
            <tr>
                <th>Producto</th>
                <th>Marca</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>

            <?php
            /**
             * RECORRIDO DEL ARRAY ASOCIATIVO
             * $item: Representa la clave (Key) del array (el nombre del producto).
             * $datos: Representa el valor (Value), que es otro array con las propiedades.
             */
            foreach ($compra as $item => $datos) {

                // Filtro: Solo mostrar si el usuario seleccionó al menos una unidad
                if ($datos['cantidad'] > 0) {

                    // Cálculo interno por línea de producto
                    $total_item = $datos['cantidad'] * $datos['precio'];

                    // Impresión formateada:
                    // %s = string, %d = entero, %.2f = flotante con 2 decimales
                    printf(
                        "<tr>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%d</td>
                            <td>$%.2f</td>
                            <td>$%.2f</td>
                        </tr>",
                        htmlspecialchars($item),
                        htmlspecialchars($datos['marca']),
                        $datos['cantidad'],
                        $datos['precio'],
                        $total_item
                    );
                }
            }
            ?>

        </tbody>
    </table>

    <!-- sección totales -->
    <div class="text-end mt-3">

        <?php
        // Mostramos el resumen de la factura 
        printf("<p><strong>Subtotal:</strong> $%.2f</p>", $subtotal);
        printf("<p><strong>ITBMS (7%%):</strong> $%.2f</p>", $itbms);
        printf("<p><strong>Descuento:</strong> $%.2f</p>", $descuento);
        ?>

        <hr>

        <!-- Total Final -->
        <h4 class="text-success">
            <?php printf("Total a Pagar: $%.2f", $total); ?>
        </h4>
    </div>

</div>