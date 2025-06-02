<?php
Class Categoria{
    private $idCat;
    private $nombre;
    
    public function __construct($idCat = "", $nombre = "") {
        $this -> idCat = $idCat;
        $this -> nombre = $nombre;
    }
    
    public function getIdCat() {
        return $this -> idCat;
    }
    
    public function getNombre() {
        return $this -> nombre;
    }
    
    public function setIdCat($idCat) {
        $this -> idCat = $idCat;
    }
    
    public function setNombre($nombre) {
        $this -> nombre = $nombre;
    }
}
?>