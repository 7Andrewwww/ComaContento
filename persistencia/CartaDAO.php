<?php
class CartaDAO {
    private $id_carta;
    private $fecha_inicio;
    private $fecha_fin;
    private $es_vigente;
    private $descripcion;
    
    // Modificar el constructor
    public function __construct($id_carta = "", $fecha_inicio = "", $fecha_fin = "",
        $es_vigente = "", $descripcion = "") {
            $this->id_carta = $id_carta;
            $this->fecha_inicio = $fecha_inicio;
            $this->fecha_fin = $fecha_fin;
            $this->es_vigente = $es_vigente;
            $this->descripcion = $descripcion;
    }
    
    public function consultarTodos() {
        return "SELECT c.id_carta, c.fecha_inicio, c.fecha_fin, c.es_vigente,
                       c.descripcion, p.id_plato, p.nombre as nombre_plato
                FROM carta c
                JOIN plato p ON c.id_plato = p.id_plato
                ORDER BY c.fecha_inicio DESC";
    }
    
    public function consultar() {
        return "SELECT c.fecha_inicio, c.fecha_fin, c.es_vigente, c.descripcion,
                       p.id_plato, p.nombre as nombre_plato
                FROM carta c
                JOIN plato p ON c.id_plato = p.id_plato
                WHERE c.id_carta = '" . $this->id_carta . "'";
    }
    
    public function crear() {
        return "INSERT INTO carta (id_carta, fecha_inicio, fecha_fin, es_vigente, descripcion)
            VALUES ('" . $this->id_carta . "',
                    '" . $this->fecha_inicio . "',
                    '" . $this->fecha_fin . "',
                    " . $this->es_vigente . ",
                    '" . $this->descripcion . "')";
    }
    
    public function actualizar() {
        return "UPDATE carta SET
            fecha_inicio = '" . $this->fecha_inicio . "',
            fecha_fin = '" . $this->fecha_fin . "',
            es_vigente = " . $this->es_vigente . ",
            descripcion = '" . $this->descripcion . "'
            WHERE id_carta = '" . $this->id_carta . "'";
    }
    
    public function eliminar() {
        return "DELETE FROM carta WHERE id_carta = '" . $this->id_carta . "'";
    }
    
    public function consultarPlatosDisponibles() {
        return "SELECT id_plato, nombre FROM plato ORDER BY nombre";
    }
    
    public function consultarCartasVigentes() {
        return "SELECT c.id_carta, c.fecha_inicio, c.fecha_fin, c.descripcion,
                       p.id_plato, p.nombre as nombre_plato
                FROM carta c
                JOIN plato p ON c.id_plato = p.id_plato
                WHERE c.es_vigente = 1
                ORDER BY c.fecha_inicio DESC";
    }
    
    public function agregarPlato($id_carta, $id_plato, $orden) {
        // Asegúrate que los nombres de columnas coincidan exactamente
        return "INSERT INTO carta_plato (id_carta, id_plato, orden) VALUES ("
            . intval($id_carta) . ", "
                . intval($id_plato) . ", "
                    . intval($orden) . ")";
    }
    
    public function eliminarPlato($id_carta, $id_plato) {
        return "DELETE FROM carta_plato
                WHERE id_carta = '" . $id_carta . "'
                AND id_plato = '" . $id_plato . "'";
    }
    
    public function consultarPlatosDeCarta($id_carta) {
        return "SELECT p.id_plato, p.nombre, p.descripcion, p.precio_base, p.foto, cp.orden
            FROM plato p
            JOIN carta_plato cp ON p.id_plato = cp.id_plato
            WHERE cp.id_carta = '" . $id_carta . "'
            ORDER BY cp.orden";
    }
}
?>