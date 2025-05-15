<?php

class CultivosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function crearCultivo($Nombre, $Cantidad, $Img, $Descripcion, $Id_Tipo_Cultivo)
    {
        $query = "INSERT INTO cultivos (Nombre, Cantidad, Img, Descripcion, Id_Tipo_Cultivo) VALUES (?, ?, ?, ?, ?)";
        $arrData = array($Nombre, $Cantidad, $Img, $Descripcion, $Id_Tipo_Cultivo);
        error_log("Consulta SQL Crear: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->insert($query, $arrData);
        return $request;
    }

    public function obtenerCultivo($Id_Cultivo)
    {
        $query = "SELECT * FROM cultivos WHERE Id_Cultivo = ?";
        $arrData = array($Id_Cultivo);
        error_log("Consulta SQL Obtener: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->select($query, $arrData);
        return $request;
    }

    public function obtenerCultivos()
    {
        $query = "SELECT * FROM cultivos";
        error_log("Consulta SQL Obtener Todos: " . $query);
        $request = $this->select_all($query);
        return $request;
    }


    public function actualizarCultivo($idCultivo, $Nombre, $Cantidad, $Img, $Descripcion, $Id_Tipo_Cultivo) 
    {
        $sql = "UPDATE cultivos SET Nombre = ?, Cantidad = ?, Img = ?, Descripcion = ?, Id_Tipo_Cultivo = ? WHERE Id_Cultivo = ?";
        $arrData = array($Nombre, $Cantidad, $Img, $Descripcion, $Id_Tipo_Cultivo, $idCultivo);
        return $this->update($sql, $arrData);
    }
    

    public function eliminarCultivo($Id_Cultivo)
    {
        $query = "DELETE FROM cultivos WHERE Id_Cultivo = ?";
        $arrData = array($Id_Cultivo);
        error_log("Consulta SQL Eliminar: " . $query . " Valores: " . print_r($arrData, true));
        $request = $this->delete($query, $arrData);
        return $request;
    }
}

?>