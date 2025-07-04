<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/VentasDAO.php");

class Venta {
    private $id_venta;
    private $fecha;
    private $valor_total;
    private $plato;
    private $cantidad_platos;
    private $precio_unitario;
    private $subtotal;
    
    public function __construct($id_venta="", $fecha="", $valor_total="", $plato="",
        $cantidad_platos="", $precio_unitario="", $subtotal="") {
            $this->id_venta = $id_venta;
            $this->fecha = $fecha;
            $this->valor_total = $valor_total;
            $this->plato = $plato;
            $this->cantidad_platos = $cantidad_platos;
            $this->precio_unitario = $precio_unitario;
            $this->subtotal = $subtotal;
    }
    
    public function getIdVenta() { return $this->id_venta; }
    public function getFecha() { return $this->fecha; }
    public function getValorTotal() { return $this->valor_total; }
    public function getPlato() { return $this->plato; }
    public function getCantidadPlatos() { return $this->cantidad_platos; }
    public function getPrecioUnitario() { return $this->precio_unitario; }
    public function getSubtotal() { return $this->subtotal; }
    
    public static function consultarVentasPorMes($año = null) {
        $conexion = new Conexion();
        $ventasDAO = new VentasDAO();
        $conexion->abrir();
        $conexion->ejecutar($ventasDAO->consultarVentasPorMes($año));
        $resultados = array();
        while(($datos = $conexion->registro()) != null) {
            $resultados[] = array(
                'año' => $datos[0],
                'mes' => $datos[1],
                'total_ventas' => $datos[2],
                'cantidad_ventas' => $datos[3]
            );
        }
        $conexion->cerrar();
        return $resultados;
    }
    
    public static function consultarVentasPorPlato($mes, $año) {
        $conexion = new Conexion();
        $ventasDAO = new VentasDAO();
        $conexion->abrir();
        $conexion->ejecutar($ventasDAO->consultarVentasPorPlato($mes, $año));
        $ventas = array();
        while(($datos = $conexion->registro()) != null) {
            $plato = new Plato($datos[0], $datos[1]);
            $ventas[] = new Venta("", "", "", $plato, $datos[2], "", $datos[3]);
        }
        $conexion->cerrar();
        return $ventas;
    }
    
    public static function consultarAniosDisponibles() {
        $conexion = new Conexion();
        $ventasDAO = new VentasDAO();
        $conexion->abrir();
        $conexion->ejecutar($ventasDAO->consultarAniosDisponibles());
        $anios = array();
        while(($datos = $conexion->registro()) != null) {
            $anios[] = $datos[0];
        }
        $conexion->cerrar();
        return $anios;
    }
    
    public static function consultarDetalleVenta($id_venta) {
    $conexion = new Conexion();
    $ventasDAO = new VentasDAO();
    $conexion->abrir();
    // Use the new DAO method that queries the view
    $conexion->ejecutar($ventasDAO->consultarDetalleVentaPorId($id_venta));
    $venta = null;
    if(($datos = $conexion->registro()) != null) {
        // Ensure that $datos array indices match the order of columns in your VistasVentasDetalle view
        // Specifically, for 'plato', you are passing $datos[3] (id_plato) and $datos[4] (nombre_plato)
        $plato = new Plato($datos[3], $datos[4]); 
        $venta = new Venta($datos[0], $datos[1], $datos[2], $plato, $datos[5], $datos[6], $datos[7]);
    }
    $conexion->cerrar();
    return $venta;
}

    public static function consultarTodasLasVentasDetalle($mes = null, $año = null) {
    $conexion = new Conexion();
    $ventasDAO = new VentasDAO();
    $conexion->abrir();
    $conexion->ejecutar($ventasDAO->consultarDetalleVentasGeneral($mes, $año));
    $detallesVenta = array();
    while(($datos = $conexion->registro()) != null) {
        $plato = new Plato($datos[3], $datos[4]); // Assuming $datos[3] is id_plato, $datos[4] is nombre_plato
        $detallesVenta[] = array(
            'id_venta' => $datos[0],
            'fecha' => $datos[1],
            'valor_total' => $datos[2],
            'plato' => $plato,
            'cantidad_platos' => $datos[5],
            'precio_unitario' => $datos[6],
            'subtotal' => $datos[7],
            'año_venta' => $datos[8],
            'mes_venta' => $datos[9]
        );
    }
    $conexion->cerrar();
    return $detallesVenta;
}
    
    public static function consultarVentasPorPlatoRegion($mes = null, $año = null) {
    $conexion = new Conexion();
    $ventasDAO = new VentasDAO();
    $conexion->abrir();
    $conexion->ejecutar($ventasDAO->consultarVentasPorPlatoRegion($mes, $año));

    $ventasPorRegion = array();
    while(($datos = $conexion->registro()) != null) {
        $regionId = $datos[0];
        $regionNombre = $datos[1];
        $plato = new Plato($datos[2], $datos[3]); // id_plato and nombre_plato

        if (!isset($ventasPorRegion[$regionId])) {
            $ventasPorRegion[$regionId] = array(
                'id_region' => $regionId,
                'nombre_region' => $regionNombre,
                'platos' => array()
            );
        }

        $ventasPorRegion[$regionId]['platos'][] = array(
            'plato' => $plato,
            'cantidad_vendida' => $datos[4], // cantidad_vendida
            'total_vendido' => $datos[5]    // total_vendido
        );
    }

    $conexion->cerrar();
    return $ventasPorRegion;
}
    
    public static function consultarVentasPorMomentoConsumo($mes = null, $año = null) {
        $conexion = new Conexion();
        $ventasDAO = new VentasDAO();
        $conexion->abrir();
        $conexion->ejecutar($ventasDAO->consultarVentasPorMomentoConsumo($mes, $año));
        
        $ventasPorMomento = array();
        while(($datos = $conexion->registro()) != null) {
            $momentoId = $datos[0];
            $momentoNombre = $datos[1];
            $plato = new Plato($datos[2], $datos[3]);
            
            if (!isset($ventasPorMomento[$momentoId])) {
                $ventasPorMomento[$momentoId] = array(
                    'id_momento' => $momentoId,
                    'nombre_momento' => $momentoNombre,
                    'platos' => array()
                );
            }
            
            $ventasPorMomento[$momentoId]['platos'][] = array(
                'plato' => $plato,
                'cantidad_vendida' => $datos[4],
                'total_vendido' => $datos[5]
            );
        }
        
        $conexion->cerrar();
        return $ventasPorMomento;
    }
}