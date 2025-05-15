<?php

class EpaTratamientoModel extends Mysql
{
    private $Id_Tratamiento;
    private $Id_Epa;

    public function setEpaTratamiento($Id_Tratamiento, $Id_Epa)
    {
        $this->Id_Tratamiento = $Id_Tratamiento;
        $this->Id_Epa = $Id_Epa;

        $sql = "SELECT * FROM epa_tratamiento WHERE Id_Tratamiento = :Id_Tratamiento AND Id_Epa = :Id_Epa";
        $arrayParams = array(
            ':Id_Tratamiento' => $this->Id_Tratamiento,
            ':Id_Epa' => $this->Id_Epa
        );

        $request = $this->select($sql, $arrayParams);
        if (!empty($request)) {
            return false;
        } else {
            $query_insert = "INSERT INTO epa_tratamiento (Id_Tratamiento, Id_Epa) VALUES (:Id_Tratamiento, :Id_Epa)";
            $arrayInsert = array(
                ':Id_Tratamiento' => $this->Id_Tratamiento,
                ':Id_Epa' => $this->Id_Epa
            );

            $request_insert = $this->insert($query_insert, $arrayInsert);
            return $request_insert;
        }
    }

    public function getEpaTratamiento(int $Id_EpaTratamiento)
    {
        $sql = "SELECT * FROM epa_tratamiento WHERE Id_EpaTratamiento = :Id_EpaTratamiento";
        $arrayParams = array(
            ':Id_EpaTratamiento' => $Id_EpaTratamiento
        );

        $request = $this->select($sql, $arrayParams);
        return $request;
    }

    public function deleteEpaTratamiento(int $Id_EpaTratamiento)
    {
        $sql = "DELETE FROM epa_tratamiento WHERE Id_EpaTratamiento = :Id_EpaTratamiento";
        $arrayParams = array(
            ':Id_EpaTratamiento' => $Id_EpaTratamiento
        );

        $request = $this->delete($sql, $arrayParams);
        return $request;
    }

    public function getAllEpaTratamientos()
    {
        $sql = "SELECT * FROM epa_tratamiento";
        $request = $this->select_all($sql);
        return $request;
    }
}
?>
