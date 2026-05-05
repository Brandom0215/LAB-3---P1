<?php require_once 'html/menu.html'; ?>

<main class="main-content">
    <div class="container">
        <?php require_once 'L3P1/html/header.html'; ?>

        <!-- Formulario con arrays, precios y botón limpiar -->
        <?php require_once 'L3P1/html/formulario.html'; ?>

        <?php
        
        // PROCESAMIENTO PHP AL ENVIAR EL FORMULARIO
        
        if (isset($_POST['btnComprar'])) {

            // Datos recibidos del formulario
            $monitor_marca   = isset($_POST['monitor_marca'])   ? $_POST['monitor_marca']          : '';
            $monitor_cant    = isset($_POST['monitor_cant'])     ? intval($_POST['monitor_cant'])   : 0;
            $cpu_marca       = isset($_POST['cpu_marca'])        ? $_POST['cpu_marca']              : '';
            $cpu_cant        = isset($_POST['cpu_cant'])         ? intval($_POST['cpu_cant'])       : 0;
            $impresora_marca = isset($_POST['impresora_marca'])  ? $_POST['impresora_marca']        : '';
            $impresora_cant  = isset($_POST['impresora_cant'])   ? intval($_POST['impresora_cant']) : 0;
            $edad_cliente    = isset($_POST['edad_cliente'])     ? intval($_POST['edad_cliente'])   : 0;

            // Precios unitarios usando el método de la clase Almacen 
            $precio_monitor   = $almacen->getPrecio('monitor', $monitor_marca);
            $precio_cpu       = $almacen->getPrecio('cpu', $cpu_marca);
            $precio_impresora = $almacen->getPrecio('impresora', $impresora_marca);

            // Carga del "Array Componente" 
        
            $compra = array(
                "Monitor"   => array("marca" => $monitor_marca,   "cantidad" => $monitor_cant,    "precio" => $precio_monitor),
                "CPU"       => array("marca" => $cpu_marca,       "cantidad" => $cpu_cant,        "precio" => $precio_cpu),
                "Impresora" => array("marca" => $impresora_marca, "cantidad" => $impresora_cant, "precio" => $precio_impresora)
            );

            // Guardamos el HTML de los componentes  para luego imprimir en la factura
            $html_componentes = $almacen->imprimirComponentesCompra($compra);

            
            // Alexandra: Validaciones y restricciones
            

            
            // Luis: Cálculos (subtotal, ITBMS 7%, descuento 20%)


            
            // Anthony: Salida / Detalle de factura
            
            
            echo "<script>
                document.getElementById('resultado-factura').style.display = 'block';
                document.getElementById('resultado-factura').innerHTML = '$html_componentes';
            </script>";

        }
        ?>
    </div>
</main>

<?php require_once 'L3P1/html/footer.html'; ?>
