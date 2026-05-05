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

            // Guardamos el HTML de los componentes  para luego imprimir en la factura
            $html_componentes = $almacen->imprimirComponentesCompra($compra);


            // Alexandra: Validaciones y restricciones
            // Si no se selecciono ningun producto, mostrar advertencia
            if ($monitor_cant == 0 && $cpu_cant == 0 && $impresora_cant == 0) {
                echo "<script>
        var div = document.getElementById('resultado-factura');
        div.style.display = 'block';
        div.innerHTML = '<div style=\"background:#fff8e1; border:1px solid #f39c12; border-radius:8px; padding:15px; color:#e67e22;\"><strong>Compra vacia:</strong><br><br>Debe seleccionar al menos un producto antes de generar la factura.</div>';
        div.scrollIntoView({behavior: 'smooth'});
    </script>";
                exit;
            }

            // Si el campo edad viene vacio, pedir que lo llene
            if (empty($_POST['edad_cliente']) || $_POST['edad_cliente'] === '') {
                echo "<script>
        var div = document.getElementById('resultado-factura');
        div.style.display = 'block';
        div.innerHTML = '<div style=\"background:#fff8e1; border:1px solid #f39c12; border-radius:8px; padding:15px; color:#e67e22;\"><strong>Edad requerida:</strong><br><br>Por favor ingrese su edad antes de generar la factura.</div>';
        div.scrollIntoView({behavior: 'smooth'});
    </script>";
                exit;
            }

            // Si la edad es negativa, cero, o mayor a 75, no es valida
            if ($edad_cliente <= 0 || $edad_cliente > 75 || !is_numeric($edad_cliente)) {
                echo "<script>
        var div = document.getElementById('resultado-factura');
        div.style.display = 'block';
        div.innerHTML = '<div style=\"background:#fff8e1; border:1px solid #f39c12; border-radius:8px; padding:15px; color:#e67e22;\"><strong>Edad invalida:</strong><br><br>Debe ingresar una edad entre 1 y 75 anos. No se permiten numeros negativos ni valores fuera de rango.</div>';
        div.scrollIntoView({behavior: 'smooth'});
    </script>";
                exit;
            }

            // Revisar restricciones de cantidad por producto
            $errores = [];

            // El cliente solo puede llevar 1 monitor
            if ($monitor_cant > 1) {
                $errores[] = "Solo se permite comprar maximo 1 monitor.";
            }

            // El cliente puede llevar hasta 3 CPUs sin importar la marca
            if ($cpu_cant > 3) {
                $errores[] = "Solo se permite comprar maximo 3 CPUs.";
            }

            // Las impresoras no tienen limite de cantidad
        
            // Si hay algun error de cantidad, mostrarlos todos juntos
            if (!empty($errores)) {
                $lista_errores = implode("<br>- ", $errores);
                echo "<script>
        var div = document.getElementById('resultado-factura');
        div.style.display = 'block';
        div.innerHTML = '<div style=\"background:#fff0f0; border:1px solid #e74c3c; border-radius:8px; padding:15px; color:#c0392b;\"><strong>Errores en la compra:</strong><br><br>- $lista_errores</div>';
        div.scrollIntoView({behavior: 'smooth'});
    </script>";
                exit;
            }


            // Luis: Cálculos (subtotal, ITBMS 7%, descuento 20%)
            // Subtotal: suma de (precio * cantidad) de cada componente
            $subtotal = 0;

            foreach ($compra as $item) {
                $subtotal += $item['precio'] * $item['cantidad'];
            }

            // ITBMS 7%
            $itbms = $subtotal * 0.07;

            // Descuento 20% si es mayor de 57 años
            $descuento = ($edad_cliente > 57) ? ($subtotal * 0.20) : 0;

            // Total a pagar
            $total = $subtotal + $itbms - $descuento;


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