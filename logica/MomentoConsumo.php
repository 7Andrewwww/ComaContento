<?php
Class MomentoConsumo{
    private $idMc;
    private $nombre;
    
    public function __construct($idMc = "", $nombre = "") {
        $this -> idMc = $idMc;
        $this -> nombre = $nombre;
    }
    
    public function getIdMc() {
        return $this -> idMc;
    }
    
    public function getNombre() {
        return $this -> nombre;
    }
    
    public function setIdRegion($idMc) {
        $this -> idRegion = $idMc;
    }
    
    public function setNombre($nombre) {
        $this -> nombre = $nombre;
    }
}
?>