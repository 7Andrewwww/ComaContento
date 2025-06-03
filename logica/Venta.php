<?php
require_once(__DIR__ . '/../persistencia/Conexion.php');
require_once(__DIR__ . '/../persistencia/VentasDAO.php');
require_once(__DIR__ . '/Plato.php');

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
        $conexion->ejecutar($ventasDAO->consultarDetalleVenta($id_venta));
        $venta = null;
        if(($datos = $conexion->registro()) != null) {
            $plato = new Plato($datos[3], $datos[4]);
            $venta = new Venta($datos[0], $datos[1], $datos[2], $plato, $datos[5], $datos[6], $datos[7]);
        }
        $conexion->cerrar();
        return $venta;
    }
}