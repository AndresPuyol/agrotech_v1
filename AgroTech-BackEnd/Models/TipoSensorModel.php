<?php

class TipoSensorModel extends Mysql
{
    private $intIdTipoSensor;
    private $strNombre;

    public function __construct()
    {
        parent::__construct();
    }

    public function setTipoSensor(string $Nombre)
    {
        $this->strNombre = $Nombre;

        // Verificar si el tipo de sensor ya existe
        $sql = "SELECT Nombre FROM tipo_sensor WHERE Nombre = :Nombre";
        $arrayParams = array(':Nombre' => $Nombre);

        $request = $this->select($sql, $arrayParams);

        if (!empty($request)) {
            return false;
        } else {
            // Insertar el tipo de sensor si no existe
            $query_insert = "INSERT INTO tipo_sensor(Nombre) VALUES (:Nombre)";
            $arrayData = array(
                ':Nombre' => $this->strNombre
            );

            $request_insert = $this->insert($query_insert, $arrayData);
            return $request_insert;
        }
    }

    public function updateTipoSensor(int $Id_Tipo_Sensor, string $Nombre)
    {
        $this->intIdTipoSensor = $Id_Tipo_Sensor;
        $this->strNombre = $Nombre;

        $sql = "UPDATE tipo_sensor SET Nombre = :Nombre WHERE Id_Tipo_Sensor = :Id_Tipo_Sensor";
        $arrayData = array(
            ':Id_Tipo_Sensor' => $this->intIdTipoSensor,
            ':Nombre' => $this->strNombre
        );

        $request = $this->update($sql, $arrayData);
        return $request;
    }

    public function deleteTipoSensor(int $Id_Tipo_Sensor)
    {
        $this->intIdTipoSensor = $Id_Tipo_Sensor;
        $sql = "DELETE FROM tipo_sensor WHERE Id_Tipo_Sensor = :Id_Tipo_Sensor";
        $arrayData = array(':Id_Tipo_Sensor' => $this->intIdTipoSensor);

        $request = $this->delete($sql, $arrayData);
        return $request;
    }

    public function getTipoSensor(int $Id_Tipo_Sensor)
    {
        $this->intIdTipoSensor = $Id_Tipo_Sensor;
        $sql = "SELECT * FROM tipo_sensor WHERE Id_Tipo_Sensor = :Id_Tipo_Sensor";
        $arrayData = array(':Id_Tipo_Sensor' => $this->intIdTipoSensor);

        $request = $this->select($sql, $arrayData);
        return $request;
    }

    public function getAllTiposSensores()
    {
        $sql = "SELECT * FROM tipo_sensor";
        $request = $this->select_all($sql);
        return $request;
    }
}
?>