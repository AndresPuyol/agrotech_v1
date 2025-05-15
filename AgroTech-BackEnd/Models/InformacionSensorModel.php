<?php   
class InformacionSensorModel extends Mysql
{
    private $Id_Informacion_Sensor;
    private $Fecha_Registro;
    private $Valor_Maximo;
    private $Valor_Minimo;
    private $Id_Sensor;

    public function setInformacionSensor($Fecha_Registro, $Valor_Maximo, $Valor_Minimo, $Id_Sensor)
    {
        $this->Fecha_Registro = $Fecha_Registro;
        $this->Valor_Maximo = $Valor_Maximo;
        $this->Valor_Minimo = $Valor_Minimo;
        $this->Id_Sensor = $Id_Sensor;

        $sql = "SELECT Id_Informacion_Sensor FROM Informacion_Sensor WHERE Id_Sensor = :Id_Sensor AND Fecha_Registro = :Fecha_Registro";
        $arrayParams = array(
            ':Id_Sensor' => $this->Id_Sensor,
            ':Fecha_Registro' => $this->Fecha_Registro
        );

        $request = $this->select($sql, $arrayParams);
        if (!empty($request)) {
            return false;
        } else {
            $query_insert = "INSERT INTO `Informacion_Sensor`(`Fecha_Registro`, `Valor_Maximo`, `Valor_Minimo`, `Id_Sensor`) VALUES(:Fecha_Registro, :Valor_Maximo, :Valor_Minimo, :Id_Sensor)";

            $arraySensorInfo = array(
                ':Fecha_Registro' => $Fecha_Registro,
                ':Valor_Maximo' => $Valor_Maximo,
                ':Valor_Minimo' => $Valor_Minimo,
                ':Id_Sensor' => $Id_Sensor
            );

            $request_insert = $this->insert($query_insert, $arraySensorInfo);
            return $request_insert;
        }
    }

    public function getInformacionSensor(int $Id_Informacion_Sensor)
    {
        $this->Id_Informacion_Sensor = $Id_Informacion_Sensor;
        $sql = "SELECT Fecha_Registro, Valor_Maximo, Valor_Minimo, Id_Sensor FROM Informacion_Sensor WHERE Id_Informacion_Sensor = :Id_Informacion_Sensor";
        $arraySensorInfo = array(
            ':Id_Informacion_Sensor' => $Id_Informacion_Sensor
        );

        $request = $this->select($sql, $arraySensorInfo);
        return $request;
    }

    public function updateInformacionSensor($Id_Informacion_Sensor, $Fecha_Registro, $Valor_Maximo, $Valor_Minimo, $Id_Sensor)
    {
        $sql_check = "SELECT Fecha_Registro, Valor_Maximo, Valor_Minimo, Id_Sensor FROM Informacion_Sensor WHERE Id_Informacion_Sensor = :Id_Informacion_Sensor";
        $arrayCheck = array(':Id_Informacion_Sensor' => $Id_Informacion_Sensor);
        $currentData = $this->select($sql_check, $arrayCheck);

        if ($currentData['Fecha_Registro'] == $Fecha_Registro && $currentData['Valor_Maximo'] == $Valor_Maximo && $currentData['Valor_Minimo'] == $Valor_Minimo && $currentData['Id_Sensor'] == $Id_Sensor) {
            return false;
        }

        $sql = "UPDATE Informacion_Sensor SET Fecha_Registro = :Fecha_Registro, Valor_Maximo = :Valor_Maximo, Valor_Minimo = :Valor_Minimo, Id_Sensor = :Id_Sensor WHERE Id_Informacion_Sensor = :Id_Informacion_Sensor";
        $arraySensorInfo = array(
            ':Fecha_Registro' => $Fecha_Registro,
            ':Valor_Maximo' => $Valor_Maximo,
            ':Valor_Minimo' => $Valor_Minimo,
            ':Id_Sensor' => $Id_Sensor,
            ':Id_Informacion_Sensor' => $Id_Informacion_Sensor
        );

        $request = $this->update($sql, $arraySensorInfo);
        return $request;
    }

    public function deleteInformacionSensor($Id_Informacion_Sensor)
    {
        $this->Id_Informacion_Sensor = $Id_Informacion_Sensor;
        $sql = "DELETE FROM Informacion_Sensor WHERE Id_Informacion_Sensor = :Id_Informacion_Sensor";
        $arraySensorInfo = array(
            ':Id_Informacion_Sensor' => $Id_Informacion_Sensor
        );
        $request = $this->delete($sql, $arraySensorInfo);
        return $request;
    }

    public function GetAllInformacionSensor()
    {
        $sql = 'SELECT * FROM Informacion_Sensor';
        $request = $this->select_all($sql);
        return $request;
    }
}