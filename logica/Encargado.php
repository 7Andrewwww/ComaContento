<?php
Class Encargado{
    private $idEnc;
    private $nombre;
    
    public function __construct($idEnc = "", $nombre = "") {
        $this -> idEnc = $idEnc;
        $this -> nombre = $nombre;
    }
    
    public function getIdEnc() {
        return $this -> idEnc;
    }
    
    public function getNombre() {
        return $this -> nombre;
    }
    
    public function setIdEnc($idEnc) {
        return $this -> idEnc;
    }
    
    public function setNombre($nombre) {
        return $this -> nombre;
    }
}
?>