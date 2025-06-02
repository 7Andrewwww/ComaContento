<?php
Class Venta{
    private $idVenta;
    private $fecha;
    private $valorTotal;
    
    public function __construct($idVenta = "", $fecha = "", $valorTotal = "") {
        $this -> idVenta = $idVenta;
        $this -> fecha = $fecha;
        $this -> valorTotal = $valorTotal;
    }
    
    public function getIdVenta() {
        return $this -> idVenta;
    }
    
    public function getFecha() {
        return $this -> fecha;
    }
    
    public function getValorTotal() {
        return $this -> valorTotal;
    }
    
    public function setIdVenta($idVenta) {
        $this -> idVenta = $idVenta;
    }
    
    public function setFecha($fecha) {
        $this -> fecha = $fecha;
    }
    
    public function setValorTotal($valorTotal) {
        $this -> valorTotal = $valorTotal;
    }
    
    
}
?>