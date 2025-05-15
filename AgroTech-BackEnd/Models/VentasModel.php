<?php

class VentasModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // Verificar si una producción existe
    public function verificarProduccion($Id_Produccion)
    {
        $query = "SELECT * FROM producciones WHERE Id_Produccion = ?";
        $arrData = array($Id_Produccion);
        $request = $this->select($query, $arrData);
        return !empty($request);
    }

    // Crear una nueva venta
    public function crearVenta($Fecha, $Precio_Unitario, $Cantidad_Venta, $Valor_Total_Venta, $Id_Produccion)
    {
        $query = "INSERT INTO ventas (Fecha, Precio_Unitario, Cantidad_Venta, Valor_Total_Venta, Id_Produccion) 
                VALUES (?, ?, ?, ?, ?)";
        $arrData = array($Fecha, $Precio_Unitario, $Cantidad_Venta, $Valor_Total_Venta, $Id_Produccion);
        error_log("Consulta SQL Crear Venta: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->insert($query, $arrData);
        return $request;
    }

    // Obtener todas las ventas
    public function obtenerVentas()
    {
        $query = "SELECT * FROM ventas";
        error_log("Consulta SQL Obtener Todas las Ventas: " . $query);
        $request = $this->select_all($query);
        return $request;
    }

    // Obtener una venta por su ID
    public function obtenerVenta($Id_Venta)
    {
        $query = "SELECT * FROM ventas WHERE Id_Venta = ?";
        $arrData = array($Id_Venta);
        error_log("Consulta SQL Obtener Venta: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->select($query, $arrData);
        return $request;
    }

    // Actualizar una venta
    public function actualizarVenta($Id_Venta, $Fecha, $Precio_Unitario, $Cantidad_Venta, $Valor_Total_Venta, $Id_Produccion)
    {
        $query = "UPDATE ventas SET Fecha = ?, Precio_Unitario = ?, Cantidad_Venta = ?, Valor_Total_Venta = ?, Id_Produccion = ?
                WHERE Id_Venta = ?";
        $arrData = array($Fecha, $Precio_Unitario, $Cantidad_Venta, $Valor_Total_Venta, $Id_Produccion, $Id_Venta);
        error_log("Consulta SQL Actualizar Venta: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->update($query, $arrData);
        return $request;
    }

    // Eliminar una venta
    public function eliminarVenta($Id_Venta)
    {
        $query = "DELETE FROM ventas WHERE Id_Venta = ?";
        $arrData = array($Id_Venta);
        error_log("Consulta SQL Eliminar Venta: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->delete($query, $arrData);
        return $request;
    }
}
?>
