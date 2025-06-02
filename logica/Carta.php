<?php
Class Carta {
    private $idCarta;
    private $fechaInicio;
    private $fechaFin;
    private $esVigente;
    private $descripcion;
    private $plato;
    
    public function __construct($idCarta = "", $fechaInicio = "", $fechaFin = "", $esVigente = "", $descripcion = "", $plato = ""){
        $this -> idCarta = $idCarta;
        $this -> fechaInicio = $fechaInicio;
        $this -> fechaFin = $fechaFin;
        $this -> esVigente = $esVigente;
        $this -> descripcion = $descripcion;
        $this -> plato = $plato;
    }
    
    public function getIdCarta() {
        return $this -> idCarta;
    }
    
    public function getFechaInicio() {
        return $this -> fechaInicio;
    }
    
    public function getFechaFin() {
        return $this -> fechaFin;
    }
    
    public function getEsVigente() {
        return $this -> esVigente;
    }
    
    public function getDescripcion() {
        return $this -> descripcion;
    }
    
    public function getPlato() {
        return $this -> plato;
    }
    
    public function setIdCarta($idCarta) {
        $this -> idCarta = $idCarta;
    }
    
    public function setFechaInicio($fechaInicio) {
        $this -> fechaInicio = $fechaInicio;
    }
    
    public function setFechaFin($fechaFin) {
        $this -> fechaFin = $fechaFin;
    }
    
    public function setEsVigente($esVigente) {
        $this -> esVigente = $esVigente;
    }
    
    public function setDescripcion($descripcion) {
        $this -> descripcion = $descripcion;
    }
    
    public function setPlato($plato) {
        $this -> plato = $plato;
    }
}
?>