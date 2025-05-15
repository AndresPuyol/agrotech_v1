<?php

class ActividadesMaterialModel extends Mysql
{
    private $Id_Actividad;
    private $Id_Material;
    private $Cantidad_Uso;

    public function setActividadMaterial($Id_Actividad, $Id_Material, $Cantidad_Uso)
    {
        $this->Id_Actividad = $Id_Actividad;
        $this->Id_Material = $Id_Material;
        $this->Cantidad_Uso = $Cantidad_Uso;

        $sql = "INSERT INTO `actividades_materiales`(`Id_Actividad`, `Id_Material`, `Cantidad_Uso`) 
                VALUES(:Id_Actividad, :Id_Material, :Cantidad_Uso)";
        
        $arrayParams = array(
            ':Id_Actividad' => $this->Id_Actividad,
            ':Id_Material' => $this->Id_Material,
            ':Cantidad_Uso' => $this->Cantidad_Uso
        );

        $request = $this->insert($sql, $arrayParams); 
        return $request;
    }

    public function getActividadMaterial($Id_Actividad)
    {
        $sql = "SELECT * FROM `actividades_materiales` WHERE `Id_Actividad` = :Id_Actividad";
        $arrayParams = array(':Id_Actividad' => $Id_Actividad);
        $request = $this->select($sql, $arrayParams); 
        return $request;
    }
    public function updateActividadMaterial($Id_Actividad, $Id_Material, $Cantidad_Uso)
    {
        $this->Id_Actividad = $Id_Actividad;
        $this->Id_Material = $Id_Material;
        $this->Cantidad_Uso = (float)$Cantidad_Uso;

        $sql = "UPDATE `actividades_materiales` 
                SET `Id_Material` = :Id_Material, `Cantidad_Uso` = :Cantidad_Uso 
                WHERE `Id_Actividad` = :Id_Actividad";
        
        $arrayParams = array(
            ':Id_Actividad' => $this->Id_Actividad,
            ':Id_Material' => $this->Id_Material,
            ':Cantidad_Uso' => $this->Cantidad_Uso
        );

        $request = $this->update($sql, $arrayParams); 
        return $request;
    }

    public function deleteActividadMaterial($Id_Actividad)
    {
        $sql = "DELETE FROM `actividades_materiales` WHERE `Id_Actividad` = :Id_Actividad";
        $arrayParams = array(':Id_Actividad' => $Id_Actividad);
        $request = $this->delete($sql, $arrayParams); 
        return $request;
    }

    public function getAllActividadMaterial()
    {
        $sql = "SELECT * FROM `actividades_materiales`";
        $request = $this->select_all($sql); 
        return $request;
    }
}
?>
