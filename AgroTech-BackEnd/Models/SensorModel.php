<?php

class SensorModel extends Mysql
{
    private $intIdSensor;
    private $strNombre;
    private $intIdSurco;
    private $intIdTipoSensor;

    public function __construct()
    {
        parent::__construct();
    }

    public function setSensor(string $Nombre, int $Id_Surco, int $Id_Tipo_Sensor)
    {
        $this->strNombre = $Nombre;
        $this->intIdSurco = $Id_Surco;
        $this->intIdTipoSensor = $Id_Tipo_Sensor;

        // Verificar si el sensor ya existe
        $sql = "SELECT Nombre FROM sensores WHERE Nombre = :Nombre";
        $arrayParams = array(':Nombre' => $Nombre);

        $request = $this->select($sql, $arrayParams);

        if (!empty($request)) {
            return false;
        } else {
            // Insertar el sensor si no existe
            $query_insert = "INSERT INTO sensores(Nombre, Id_Surco, Id_Tipo_Sensor) VALUES (:Nombre, :Id_Surco, :Id_Tipo_Sensor)";
            $arrayData = array(
                ':Nombre' => $this->strNombre,
                ':Id_Surco' => $this->intIdSurco,
                ':Id_Tipo_Sensor' => $this->intIdTipoSensor
            );

            $request_insert = $this->insert($query_insert, $arrayData);
            return $request_insert;
        }
    }

    public function updateSensor(int $Id_Sensor, string $Nombre, int $Id_Surco, int $Id_Tipo_Sensor)
    {
        $this->intIdSensor = $Id_Sensor;
        $this->strNombre = $Nombre;
        $this->intIdSurco = $Id_Surco;
        $this->intIdTipoSensor = $Id_Tipo_Sensor;

        $sql = "UPDATE sensores SET Nombre = :Nombre, Id_Surco = :Id_Surco, Id_Tipo_Sensor = :Id_Tipo_Sensor WHERE Id_Sensor = :Id_Sensor";
        $arrayData = array(
            ':Id_Sensor' => $this->intIdSensor,
            ':Nombre' => $this->strNombre,
            ':Id_Surco' => $this->intIdSurco,
            ':Id_Tipo_Sensor' => $this->intIdTipoSensor
        );

        $request = $this->update($sql, $arrayData);
        return $request;
    }

    public function deleteSensor(int $Id_Sensor)
    {
        $this->intIdSensor = $Id_Sensor;
        $sql = "DELETE FROM sensores WHERE Id_Sensor = :Id_Sensor";
        $arrayData = array(':Id_Sensor' => $this->intIdSensor);

        $request = $this->delete($sql, $arrayData);
        return $request;
    }

    public function getSensor(int $Id_Sensor)
    {
        $this->intIdSensor = $Id_Sensor;
        $sql = "SELECT * FROM sensores WHERE Id_Sensor = :Id_Sensor";
        $arrayData = array(':Id_Sensor' => $this->intIdSensor);

        $request = $this->select($sql, $arrayData);
        return $request;
    }

    public function getAllSensores()
    {
        $sql = "SELECT * FROM sensores";
        $request = $this->select_all($sql);
        return $request;
    }
}
?>