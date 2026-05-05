//  Lógica del formulario - Programa 1 (Almacén)
// Esto maneja la actualización dinámica de precios y el botón Limpiar


document.addEventListener('DOMContentLoaded', function () {

    // --- Referencias a elementos del DOM ---
    const formAlmacen = document.getElementById('form-almacen');
    const selectMonitor = document.getElementById('select-monitor');
    const selectCPU = document.getElementById('select-cpu');
    const selectImpresora = document.getElementById('select-impresora');

    const precioMonitor = document.getElementById('precio-monitor');
    const precioCPU = document.getElementById('precio-cpu');
    const precioImpresora = document.getElementById('precio-impresora');

    const cantMonitor = document.getElementById('cant-monitor');
    const cantCPU = document.getElementById('cant-cpu');
    const cantImpresora = document.getElementById('cant-impresora');

    const edadInput = document.getElementById('edad-cliente');
    const btnLimpiar = document.getElementById('btn-limpiar');

    
      //Actualiza el badge de precio unitario al cambiar la marca.
    /**
     * @param {HTMLSelectElement} selectElement  // El <select> de marca
     * @param {HTMLElement}       precioElement  // El div que muestra el precio
     */
    function actualizarPrecio(selectElement, precioElement) {
        var selectedOption = selectElement.options[selectElement.selectedIndex];
        var precio = selectedOption.getAttribute('data-precio');

        if (precio && parseFloat(precio) > 0) {
            precioElement.textContent = '$' + parseFloat(precio).toFixed(2);
            // Animación de pulso al cambiar
            precioElement.classList.add('actualizado');
            setTimeout(function () {
                precioElement.classList.remove('actualizado');
            }, 400);
        } else {
            precioElement.textContent = '$0.00';
        }
    }

    // Eventos de cambio en los selects de marc
    if (selectMonitor) {
        selectMonitor.addEventListener('change', function () {
            actualizarPrecio(this, precioMonitor);
        });
    }

    if (selectCPU) {
        selectCPU.addEventListener('change', function () {
            actualizarPrecio(this, precioCPU);
        });
    }

    if (selectImpresora) {
        selectImpresora.addEventListener('change', function () {
            actualizarPrecio(this, precioImpresora);
        });
    }

    // Botón limpiar
    if (btnLimpiar) {
        btnLimpiar.addEventListener('click', function (e) {
            e.preventDefault();

            // Usa form.reset() como base para limpiar todos los inputs
            if (formAlmacen) {
                formAlmacen.reset();
            }

            // Forzamos los selects al primer producto (índice 0)
            if (selectMonitor) selectMonitor.selectedIndex = 0;
            if (selectCPU) selectCPU.selectedIndex = 0;
            if (selectImpresora) selectImpresora.selectedIndex = 0;

            // Actualizar los badges de precio al primer producto
            if (selectMonitor && precioMonitor) {
                actualizarPrecio(selectMonitor, precioMonitor);
            }
            if (selectCPU && precioCPU) {
                actualizarPrecio(selectCPU, precioCPU);
            }
            if (selectImpresora && precioImpresora) {
                actualizarPrecio(selectImpresora, precioImpresora);
            }

            // Limpiar explícitamente los inputs de cantidad
            if (cantMonitor) cantMonitor.value = '';
            if (cantCPU) cantCPU.value = '';
            if (cantImpresora) cantImpresora.value = '';

            // Limpiar el campo de edad
            if (edadInput) edadInput.value = '';

            // Limpiar la zona de resultados cuando exista
            var resultadoZona = document.getElementById('resultado-factura');
            if (resultadoZona) {
                resultadoZona.innerHTML = '';
                resultadoZona.style.display = 'none';
            }
        });
    }

});
