<?php
class VentasDAO {
    private $id_venta;
    private $fecha;
    private $valor_total;
    private $id_plato;
    private $nombre_plato;
    private $cantidad_platos;
    private $precio_unitario;
    private $subtotal;
    
    public function __construct($id_venta="", $fecha="", $valor_total="", $id_plato="",
        $nombre_plato="", $cantidad_platos="", $precio_unitario="", $subtotal="") {
            $this->id_venta = $id_venta;
            $this->fecha = $fecha;
            $this->valor_total = $valor_total;
            $this->id_plato = $id_plato;
            $this->nombre_plato = $nombre_plato;
            $this->cantidad_platos = $cantidad_platos;
            $this->precio_unitario = $precio_unitario;
            $this->subtotal = $subtotal;
    }
    
    public function consultarVentasPorMes($año = null) {
        $añoParam = ($año !== null) ? intval($año) : 'NULL';
        return "CALL Consultar_Resumen_Ventas_Por_Mes(" . $añoParam . ")";
    }
    
    public function consultarVentasPorPlato($mes, $año) {
        $mesParam = intval($mes);
        $añoParam = intval($año);
        return "CALL Consultar_Ventas_Plato_Por_Mes_Año(" . $mesParam . ", " . $añoParam . ")";
    }
    
    public function consultarAniosDisponibles() {
        return "CALL Consultar_Años_Disponibles()";
    }
    
    public function consultarDetalleVenta($id_venta) {
        $idVentaParam = intval($id_venta);
        return "CALL Consultar_Detalle_Venta_Por_Id(" . $idVentaParam . ")";
    }

    public function consultarVentasPorPlatoRegion($mes = null, $año = null) {
        $sentencia = "SELECT
                          id_reg,
                          nombre_region,
                          id_plato,
                          nombre_plato,
                          cantidad_vendida,
                          total_vendido
                      FROM VistasVentasPorRegion"; 

        $conditions = [];

        if (!is_null($mes) && is_numeric($mes) && $mes >= 1 && $mes <= 12) {
            $conditions[] = "mes_venta = " . intval($mes);
        }

        if (!is_null($año) && is_numeric($año)) {
            $año = intval($año);
            if ($año >= 2000 && $año <= 2100) {
                $conditions[] = "año_venta = " . $año;
            }
        }

        if (!empty($conditions)) {
            $sentencia .= " WHERE " . implode(" AND ", $conditions);
        }

        $sentencia .= " ORDER BY nombre_region, total_vendido DESC"; 
        return $sentencia;
    }
    
    public function consultarVentasPorMomentoConsumo($mes = null, $año = null) {
        $sentencia = "SELECT
                              id_mc,
                              nombre_momento,
                              id_plato,
                              nombre_plato,
                              cantidad_vendida,
                              total_vendido
                          FROM VistasVentasPorMomento";
        
        $conditions = [];
        
        if (!is_null($mes) && is_numeric($mes) && $mes >= 1 && $mes <= 12) {
            $conditions[] = "mes_venta = " . intval($mes);
        }
        
        if (!is_null($año) && is_numeric($año)) {
            $año = intval($año);
            if ($año >= 2000 && $año <= 2100) {
                $conditions[] = "año_venta = " . $año;
            }
        }
        
        if (!empty($conditions)) {
            $sentencia .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $sentencia .= " ORDER BY nombre_momento, total_vendido DESC";
        
        return $sentencia;
    }
    
    public function consultarDetalleVentasGeneral($mes = null, $año = null) {
        $sentencia = "SELECT id_venta, fecha, valor_total, id_plato, nombre_plato, cantidad_platos, precio_unitario, subtotal, año_venta, mes_venta FROM VistasVentasDetalle";
        $conditions = [];

        if (!is_null($mes) && is_numeric($mes) && $mes >= 1 && $mes <= 12) {
            $conditions[] = "mes_venta = " . intval($mes);
        }

        if (!is_null($año) && is_numeric($año)) {
            $año = intval($año);
            if ($año >= 2000 && $año <= 2100) {
                $conditions[] = "año_venta = " . $año;
            }
        }

        if (!empty($conditions)) {
            $sentencia .= " WHERE " . implode(" AND ", $conditions);
        }
        
        $sentencia .= " ORDER BY fecha DESC, id_venta, nombre_plato";
        return $sentencia;
    }

    public function consultarDetalleVentaPorId($id_venta) {
        return "SELECT id_venta, fecha, valor_total, id_plato, nombre_plato, cantidad_platos, precio_unitario, subtotal FROM VistasVentasDetalle WHERE id_venta = " . intval($id_venta);
    }
}
?>