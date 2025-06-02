<?php
Class Region{
    private $idRegion;
    private $nombre;
    
    public function __construct($idRegion = "", $nombre = "") {
        $this -> idRegion = $idRegion;
        $this -> nombre = $nombre;
    }
    
    public function getIdRegion() {
        return $this -> idRegion;
    }
    
    public function getNombre() {
        return $this -> nombre;
    }
    
    public function setIdRegion($idRegion) {
         $this -> idRegion = $idRegion;
    }
    
    public function setNombre($nombre) {
        $this -> nombre = $nombre;
    }
}
?>