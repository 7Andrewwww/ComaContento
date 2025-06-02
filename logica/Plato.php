<?php
class Plato {
    private $idPlato;
    private $nombre;
    private $descripcion;
    private $nivelComplejidad;
    private $precioBase;
    private $foto;
    private $categoria;
    private $momentoConsumo;
    private $region;
    private $encargado;
    private $ingrediente; 

    public function __construct($idPlato ="", $nombre= "", $descripcion = "", $nivelComplejidad = "", $precioBase = "", $foto = "", 
                                $categoria = "", $momentoConsumo = "", $region = "", $encargado = "", $ingrediente = "") {
        $this -> idPlato = $idPlato;
        $this -> nombre = $nombre;
        $this -> descripcion = $descripcion;
        $this -> nivelComplejidad = $nivelComplejidad;
        $this -> precioBase = $precioBase;
        $this -> foto = $foto;
        $this -> categoria = $categoria;
        $this -> momentoConsumo = $momentoConsumo;
        $this -> region = $region;
        $this -> encargado = $encargado;
        $this -> ingrediente = $ingrediente;
    }
    
    public function getIdPlato(){
        return $this -> idPlato;
    }
    
    public function getNombre(){
        return $this -> nombre;
    }
    
    public function getDescripcion(){
        return $this -> descripcion;
    }
    
    public function getNivelComplejidad(){
        return $this -> nivelComplejidad;
    }
    
    public function getPrecioBase(){
        return $this -> precioBase;
    }
    
    public function getFoto(){
        return $this -> foto;
    }
    
    public function getCategoria(){
        return $this -> categoria;
    }
    
    public function getMomentoConsumo(){
        return $this -> momentoConsumo;
    }
    
    public function getEncargado(){
        return $this -> encargado;
    }
    
    public function getId(){
        return $this -> id;
    }
    
    public function getIngrediente(){
        return $this -> ingrediente;
    }
    
    public function setIdPlato($idPlato) {
        $this->idPlato = $idPlato;
    }
    
    public function setNombre($idNombre) {
        $this->nombre = $nombre;
    }
    
    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    public function setNivelComplejidad($nivelComplejidad) {
        $this->nivelComplejidad = $nivelComplejidad;
    }
    
    public function setPreciobase($precioBase) {
        $this->precioBase = $precioBase;
    }
    
    public function setFoto($foto) {
        $this->foto = $foto;
    }
    
    public function setCategoria($categoria) {
        $this->categoria = $categoria;
    }
    
    public function setMomentoConsumo($momentoConsumo) {
        $this->momentoConsumo = $momentoConsumo;
    }
    
    public function setRegion($region) {
        $this->region = $region;
    }
    
    public function setEncargado($encargado) {
        $this->idPlato = $idPlato;
    }
    
    public function setIngrediente($ingrediente) {
        $this->ingrediente = $ingrediente;
    }
    
}
?>