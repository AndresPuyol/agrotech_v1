<?php

class CultivosEpaModel extends Mysql
{
    private $Id_Cultivo_Epa;
    private $Id_Cultivo;
    private $Id_Epa;

    public function setCultivoEpa($Id_Cultivo, $Id_Epa)
    {
        $this->Id_Cultivo = $Id_Cultivo;
        $this->Id_Epa = $Id_Epa;

        $sql = "SELECT Id_Cultivo_Epa FROM Cultivos_Epa WHERE Id_Cultivo = :IdCultivo AND Id_Epa = :IdEpa";
        $arrayParams = array(
            ':IdCultivo' => $this->Id_Cultivo,
            ':IdEpa' => $this->Id_Epa
        );

        $request = $this->select($sql, $arrayParams);
        if (!empty($request)) {
            return false;
        } else {
            $query_insert = "INSERT INTO Cultivos_Epa (Id_Cultivo, Id_Epa) VALUES(:IdCultivo, :IdEpa)";
            $arrayInsert = array(
                ':IdCultivo' => $Id_Cultivo,
                ':IdEpa' => $Id_Epa
            );

            $request_insert = $this->insert($query_insert, $arrayInsert);
            return $request_insert;
        }
    }

    public function getCultivoEpa(int $Id_Cultivo_Epa)
    {
        $this->Id_Cultivo_Epa = $Id_Cultivo_Epa;
        $sql = "SELECT Id_Cultivo, Id_Epa FROM Cultivos_Epa WHERE Id_Cultivo_Epa = :IdCultivoEpa";
        $arrayParams = array(
            ':IdCultivoEpa' => $Id_Cultivo_Epa
        );

        $request = $this->select($sql, $arrayParams);
        return $request;
    }

    public function updateCultivoEpa($Id_Cultivo_Epa, $Id_Cultivo, $Id_Epa)
    {
        $sql_check = "SELECT Id_Cultivo, Id_Epa FROM Cultivos_Epa WHERE Id_Cultivo_Epa = :IdCultivoEpa";
        $arrayCheck = array(':IdCultivoEpa' => $Id_Cultivo_Epa);
        $currentData = $this->select($sql_check, $arrayCheck);

        if ($currentData['Id_Cultivo'] == $Id_Cultivo && $currentData['Id_Epa'] == $Id_Epa) {
            return false;
        }

        $sql = "UPDATE Cultivos_Epa SET Id_Cultivo = :IdCultivo, Id_Epa = :IdEpa WHERE Id_Cultivo_Epa = :IdCultivoEpa";
        $arrayParams = array(
            ':IdCultivo' => $Id_Cultivo,
            ':IdEpa' => $Id_Epa,
            ':IdCultivoEpa' => $Id_Cultivo_Epa
        );

        $request = $this->update($sql, $arrayParams);
        return $request;
    }

    public function deleteCultivoEpa($Id_Cultivo_Epa)
    {
        $this->Id_Cultivo_Epa = $Id_Cultivo_Epa;
        $sql = "DELETE FROM Cultivos_Epa WHERE Id_Cultivo_Epa = :IdCultivoEpa";
        $arrayParams = array(
            ':IdCultivoEpa' => $Id_Cultivo_Epa
        );

        $request = $this->delete($sql, $arrayParams);
        return $request;
    }

    public function getAllCultivoEpa()
    {
        $sql = "SELECT * FROM Cultivo_Epa";
        $request = $this->select_all($sql);
        return $request;
    }
}

?>
