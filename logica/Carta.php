<?php
require_once("persistencia/Conexion.php");
require_once("persistencia/CartaDAO.php");
require_once("logica/Plato.php");

class Carta {
    private $id_carta;
    private $fecha_inicio;
    private $fecha_fin;
    private $es_vigente;
    private $descripcion;
    private $platos = array();
    
    public function __construct($id_carta = "", $fecha_inicio = "", $fecha_fin = "",
        $es_vigente = false, $descripcion = "") {
            $this->id_carta = $id_carta;
            $this->fecha_inicio = $fecha_inicio;
            $this->fecha_fin = $fecha_fin;
            $this->es_vigente = $es_vigente;
            $this->descripcion = $descripcion;
            $this->platos = array();
    }
    
    public function getId() { return $this->id_carta; }
    public function getFechaInicio() { return $this->fecha_inicio; }
    public function getFechaFin() { return $this->fecha_fin; }
    public function getEsVigente() { return $this->es_vigente; }
    public function getDescripcion() { return $this->descripcion; }
    public function setPlatos($platos) { $this->platos = $platos; }
    
    public function setFechaInicio($fecha_inicio) { $this->fecha_inicio = $fecha_inicio; }
    public function setFechaFin($fecha_fin) { $this->fecha_fin = $fecha_fin; }
    public function setEsVigente($es_vigente) { $this->es_vigente = $es_vigente; }
    public function setDescripcion($descripcion) { $this->descripcion = $descripcion; }
    public function setPlato($plato) { $this->plato = $plato; }
    
    public function consultar() {
        $conexion = new Conexion();
        $cartaDAO = new CartaDAO($this->id_carta);
        $conexion->abrir();
        
        $conexion->ejecutar($cartaDAO->consultar());
        $datos = $conexion->registro();
        
        $this->fecha_inicio = $datos[0];
        $this->fecha_fin = $datos[1];
        $this->es_vigente = $datos[2];
        $this->descripcion = $datos[3];
        
        $conexion->ejecutar($cartaDAO->consultarPlatosDeCarta($this->id_carta));
        while($datosPlato = $conexion->registro()) {
            $plato = new Plato(
                $datosPlato[0], 
                $datosPlato[1], 
                $datosPlato[2], 
                $datosPlato[3], 
                null,           
                $datosPlato[4]  
                );
            $this->agregarPlato($plato, $datosPlato[5]); 
        }
        
        $conexion->cerrar();
    }
    
    public static function consultarTodos() {
        $conexion = new Conexion();
        $cartaDAO = new CartaDAO();
        $conexion->abrir();
        $conexion->ejecutar($cartaDAO->consultarTodos());
        $cartas = array();
        
        while($datos = $conexion->registro()) {
            $plato = new Plato($datos[5], $datos[6]);
            $cartas[] = new Carta($datos[0], $datos[1], $datos[2], $datos[3], $datos[4], $plato);
        }
        
        $conexion->cerrar();
        return $cartas;
    }
    
    public static function consultarPlatosDisponibles() {
        $conexion = new Conexion();
        $cartaDAO = new CartaDAO();
        $conexion->abrir();
        $conexion->ejecutar($cartaDAO->consultarPlatosDisponibles());
        $platos = array();
        
        while($datos = $conexion->registro()) {
            $platos[] = new Plato($datos[0], $datos[1]);
        }
        
        $conexion->cerrar();
        return $platos;
    }
    
    public static function consultarCartasVigentes() {
        $conexion = new Conexion();
        $cartaDAO = new CartaDAO();
        $conexion->abrir();
        $conexion->ejecutar($cartaDAO->consultarCartasVigentes());
        $cartas = array();
        
        while($datos = $conexion->registro()) {
            $plato = new Plato($datos[4], $datos[5]);
            $cartas[] = new Carta($datos[0], $datos[1], $datos[2], true, $datos[3], $plato);
        }
        
        $conexion->cerrar();
        return $cartas;
    }
    
    public function crear() {
        $conexion = new Conexion();
        $cartaDAO = new CartaDAO(
            $this->id_carta,
            $this->fecha_inicio,
            $this->fecha_fin,
            $this->es_vigente ? 1 : 0,
            $this->descripcion
            );
        
        $conexion->abrir();
        
        $conexion->ejecutar("SELECT id_carta FROM carta WHERE id_carta = '" . $this->id_carta . "'");
        if($conexion->filas() > 0) {
            $conexion->cerrar();
            throw new Exception("El ID de la carta ya existe");
        }
        
        $resultado = $conexion->ejecutar($cartaDAO->crear());
        $conexion->cerrar();
        return $resultado;
    }
    
    public function actualizar() {
        $conexion = new Conexion();
        $cartaDAO = new CartaDAO(
            $this->id_carta,
            $this->fecha_inicio,
            $this->fecha_fin,
            $this->es_vigente ? 1 : 0,
            $this->descripcion
            );
        
        $conexion->abrir();
        $resultado = $conexion->ejecutar($cartaDAO->actualizar());
        $conexion->cerrar();
        return $resultado;
    }
    
    public function eliminar() {
        $conexion = new Conexion();
        $cartaDAO = new CartaDAO($this->id_carta);
        
        $conexion->abrir();
        $resultado = $conexion->ejecutar($cartaDAO->eliminar());
        $conexion->cerrar();
        return $resultado;
    }
    
    public function agregarPlato($plato, $orden = null) {
        $this->platos[] = [
            'plato' => $plato,
            'orden' => $orden
        ];
    }
    
    public function guardarPlatos() {
        $conexion = new Conexion();
        $cartaDAO = new CartaDAO();
        $conexion->abrir();
        
        try {
            $conexion->ejecutar("DELETE FROM carta_plato WHERE id_carta = " . intval($this->id_carta));
            foreach($this->platos as $platoInfo) {
                $query = $cartaDAO->agregarPlato(
                    $this->id_carta,
                    $platoInfo['plato']->getId(),
                    $platoInfo['orden'] ?? 0  
                    );
                $conexion->ejecutar($query);
            }
            
            $conexion->cerrar();
            return true;
        } catch(Exception $e) {
            $conexion->cerrar();
            error_log("Error al guardar platos: " . $e->getMessage());
            return false;
        }
    }
}
?>