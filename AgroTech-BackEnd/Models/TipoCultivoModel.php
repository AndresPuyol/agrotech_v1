<?php

class TipoCultivoModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // Crear un nuevo tipo de cultivo
    public function crearTipoCultivo($Nombre, $Descripcion)
    {
        $query = "INSERT INTO tipo_cultivo (Nombre, Descripcion) VALUES (?, ?)";
        $arrData = array($Nombre, $Descripcion);
        error_log("Consulta SQL Crear: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->insert($query, $arrData);
        return $request;
    }

    // Obtener un tipo de cultivo por su ID
    public function obtenerTipoCultivo($Id_Tipo_Cultivo)
    {
        $query = "SELECT * FROM tipo_cultivo WHERE Id_Tipo_Cultivo = ?";
        $arrData = array($Id_Tipo_Cultivo);
        error_log("Consulta SQL Obtener: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->select($query, $arrData);
        return $request;
    }

    // Obtener todos los tipos de cultivo
    public function obtenerTiposCultivo()
    {
        $query = "SELECT * FROM tipo_cultivo";
        error_log("Consulta SQL Obtener Todos: " . $query);
        $request = $this->select_all($query);
        return $request;
    }

    // Actualizar un tipo de cultivo
    public function actualizarTipoCultivo($Id_Tipo_Cultivo, $Nombre, $Descripcion)
    {
        $query = "UPDATE tipo_cultivo SET Nombre = ?, Descripcion = ? WHERE Id_Tipo_Cultivo = ?";
        $arrData = array($Nombre, $Descripcion, $Id_Tipo_Cultivo);
        error_log("Consulta SQL Actualizar: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->update($query, $arrData);
        return $request;
    }

    // Eliminar un tipo de cultivo
    public function eliminarTipoCultivo($Id_Tipo_Cultivo)
    {
        $query = "DELETE FROM tipo_cultivo WHERE Id_Tipo_Cultivo = ?";
        $arrData = array($Id_Tipo_Cultivo);
        error_log("Consulta SQL Eliminar: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->delete($query, $arrData);
        return $request;
    }
}
?>
