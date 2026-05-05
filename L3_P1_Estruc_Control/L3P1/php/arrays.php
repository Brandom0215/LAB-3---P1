<?php
// Clase Almacén - Programación Orientada a Objetos

/**
 * Gestiona los productos del almacén de computadoras.
 * Carga los arreglos de Monitores, CPUs e Impresoras con sus
 * respectivos precios unitarios.
*/

class Almacen
{
    //Arreglo asociativo de monitores (marca => precio)
    private $monitores;

    //Arreglo asociativo de CPUs (marca => precio)
    private $cpus;

    //Arreglo asociativo de impresoras (marca => precio)
    private $impresoras;

    /**
     * El Constructor inicializa los tres arreglos de productos 
     * con las marcas y precios definidos
     */
    public function __construct()
    {
        //Arreglo de Monitores
        $this->monitores = array(
            "SONY"    => 415.85,
            "SAMSUNG" => 325.15,
            "LG"      => 370.20,
            "ACER"    => 299.99
        );

        // Arreglo de CPUs 
        $this->cpus = array(
            "SONY"    => 800.00,
            "SAMSUNG" => 715.50,
            "LG"      => 775.00,
            "ACER"    => 700.00
        );

        // Arreglo de Impresoras 
        $this->impresoras = array(
            "HP"    => 295.00,
            "EPSON" => 215.00,
            "CANON" => 200.00
        );
    }

    /**
     * Obtiene el arreglo completo de monitores.
     * 
     * @return array Arreglo asociativo [marca => precio]
     */
    public function getMonitores()
    {
        return $this->monitores;
    }

    /**
     * Obtiene el arreglo completo de CPUs.
     * 
     * @return array Arreglo asociativo [marca => precio]
     */
    public function getCpus()
    {
        return $this->cpus;
    }

    /**
     * Obtiene el arreglo completo de impresoras.
     */
    public function getImpresoras()
    {
        return $this->impresoras;
    }

    /**
     * Obtiene el precio de un producto según su categoría y marca.
     */                                                                                                                                                                                                                                                                                                                                                                                                                                                                  
    public function getPrecio($categoria, $marca)
    {
        switch (strtolower($categoria)) {
            case 'monitor':
                return isset($this->monitores[$marca]) ? $this->monitores[$marca] : 0;
            case 'cpu':
                return isset($this->cpus[$marca]) ? $this->cpus[$marca] : 0;
            case 'impresora':
                return isset($this->impresoras[$marca]) ? $this->impresoras[$marca] : 0;
            default:
                return 0;
        }
    }

    /**
     * Genera las opciones HTML para un select,
     */

    public function generarOpciones($productos, $seleccionada = '')
    {
        $html = '';
        $primero = true;

        foreach ($productos as $marca => $precio) {
            // Si no hay selección previa, marcar la primera opción como selected
            if ($seleccionada === '' && $primero) {
                $selected = ' selected';
                $primero = false;
            } else {
                $selected = ($marca === $seleccionada) ? ' selected' : '';
            }
            $html .= sprintf(
                '<option value="%s" data-precio="%s"%s>%s</option>',
                $marca,
                $precio,
                $selected,
                $marca
            );
        }

        return $html;
    }

    /**
     * Genera una tabla HTML de precios de referencia
     */
    public function generarTablaPrecios($productos)
    {
        $html  = '<table class="table table-sm tabla-precios mb-3">';
        $html .= '<thead><tr><th>Marca</th><th class="text-end">Precio</th></tr></thead>';
        $html .= '<tbody>';

        foreach ($productos as $marca => $precio) {
            $html .= sprintf(
                '<tr><td>%s</td><td class="text-end precio-cell">$%s</td></tr>',
                $marca,
                number_format($precio, 2)
            );
        }

        $html .= '</tbody></table>';
        return $html;
    }

    /**
     * Genera la salida HTML para el "Array Componente" con las cantidades compradas.
     */
    public function imprimirComponentesCompra($compra)
    {
        $html = '<div class="compra-detalle mb-4">';
        $html .= '<h6 class="text-primary border-bottom pb-2 mb-3"><i class="bi bi-box-seam me-2"></i>Componentes Seleccionados</h6>';
        $html .= '<ul class="list-group list-group-flush">';

        foreach ($compra as $item => $datos) {
            if ($datos['cantidad'] > 0) {
                $html .= sprintf(
                    '<li class="list-group-item d-flex justify-content-between align-items-center bg-transparent px-0">
                        <div>
                            <span class="fw-bold">%s</span> <small class="text-muted">(%s)</small>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-primary rounded-pill me-2">%d und.</span>
                            <span class="text-dark fw-semibold">$%s c/u</span>
                        </div>
                    </li>',
                    $item,
                    $datos['marca'],
                    $datos['cantidad'],
                    number_format($datos['precio'], 2)
                );
            }
        }

        $html .= '</ul></div>';
        return $html;
    }
}

// Instanciación del objeto Almacen
$almacen = new Almacen();

// Obtener los arreglos para uso en el formulario y procesamiento
$monitores  = $almacen->getMonitores();
$cpus       = $almacen->getCpus();
$impresoras = $almacen->getImpresoras();
?>
