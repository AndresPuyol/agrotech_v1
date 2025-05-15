<?php

class ProduccionesModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // Verificar si un cultivo existe
    public function verificarCultivo($Id_Cultivo)
    {
        $query = "SELECT * FROM cultivos WHERE Id_Cultivo = ?";
        $arrData = array($Id_Cultivo);
        $request = $this->select($query, $arrData);
        return !empty($request);
    }

    // Crear una nueva producción
    public function crearProduccion($Cantidad, $Fecha, $Id_Cultivo)
    {
        $query = "INSERT INTO producciones (Cantidad, Fecha, Id_Cultivo) VALUES (?, ?, ?)";
        $arrData = array($Cantidad, $Fecha, $Id_Cultivo);
        error_log("Consulta SQL Crear Producción: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->insert($query, $arrData);
        return $request;
    }

    // Obtener todas las producciones
    public function obtenerProducciones()
    {
        $query = "SELECT * FROM producciones";
        error_log("Consulta SQL Obtener Todas: " . $query);
        $request = $this->select_all($query);
        return $request;
    }

    // Obtener una producción por su ID
    public function obtenerProduccion($Id_Produccion)
    {
        $query = "SELECT * FROM producciones WHERE Id_Produccion = ?";
        $arrData = array($Id_Produccion);
        error_log("Consulta SQL Obtener Producción: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->select($query, $arrData);
        return $request;
    }

    // Actualizar una producción
    public function actualizarProduccion($Id_Produccion, $Cantidad, $Fecha, $Id_Cultivo)
    {
        $query = "UPDATE producciones SET Cantidad = ?, Fecha = ?, Id_Cultivo = ? WHERE Id_Produccion = ?";
        $arrData = array($Cantidad, $Fecha, $Id_Cultivo, $Id_Produccion);
        error_log("Consulta SQL Actualizar Producción: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->update($query, $arrData);
        return $request;
    }

    // Eliminar una producción
    public function eliminarProduccion($Id_Produccion)
    {
        $query = "DELETE FROM producciones WHERE Id_Produccion = ?";
        $arrData = array($Id_Produccion);
        error_log("Consulta SQL Eliminar Producción: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->delete($query, $arrData);
        return $request;
    }
}
?>

