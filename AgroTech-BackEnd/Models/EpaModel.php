<?php

class EpaModel extends Mysql
{
    private $Id_Epa;
    private $Fecha_Encuentro;
    private $Nombre;
    private $Descripcion;
    private $Tipo_Enfermedad;
    private $Deficiencias;
    private $Img;
    private $Complicaciones;

    public function setEpa($Fecha_Encuentro, $Nombre, $Descripcion, $Tipo_Enfermedad, $Deficiencias, $Img, $Complicaciones)
    {
        $this->Fecha_Encuentro = $Fecha_Encuentro;
        $this->Nombre = $Nombre;
        $this->Descripcion = $Descripcion;
        $this->Tipo_Enfermedad = $Tipo_Enfermedad;
        $this->Deficiencias = $Deficiencias;
        $this->Img = $Img;
        $this->Complicaciones = $Complicaciones;

        $sql = "SELECT Id_Epa, Nombre FROM epa WHERE Id_Epa = :Id OR Nombre = :Nom";
        $arrayParams = array(
            ':Id' => $this->Id_Epa,
            ':Nom' => $this->Nombre
        );

        $request = $this->select($sql, $arrayParams);
        if (!empty($request)) {
            return false;
        } else {
            $query_insert = "INSERT INTO `epa`(`Fecha_Encuentro`, `Nombre`, `Descripcion`, `Tipo_Enfermedad`, `Deficiencias`, `Img`, `Complicaciones`) VALUES(:Fecha_Encuentro,:Nombre,:Descripcion,:Tipo_Enfermedad,:Deficiencias,:Img,:Complicaciones)";

            $arrayEpa = array(
                ':Fecha_Encuentro' => $Fecha_Encuentro,
                ':Nombre' => $Nombre,
                ':Descripcion' => $Descripcion,
                ':Tipo_Enfermedad' => $Tipo_Enfermedad,
                ':Deficiencias' => $Deficiencias,
                ':Img' => $Img,
                ':Complicaciones' => $Complicaciones
            );

            $request_insert = $this->insert($query_insert, $arrayEpa);
            return $request_insert;
        }
    }

    public function getEpa(int $Id_Epa)
    {
        $this->Id_Epa = $Id_Epa;
        $sql = "SELECT Fecha_Encuentro, Nombre, Descripcion, Tipo_Enfermedad, Deficiencias, Img, Complicaciones FROM epa WHERE Id_Epa = :Id_Epa";
        $arrayEpa = array(
            ':Id_Epa' => $Id_Epa
        );

        $request = $this->select($sql, $arrayEpa);
        return $request;
    }

    public function updateEpa($Id_Epa, $Fecha_Encuentro, $Nombre, $Descripcion, $Tipo_Enfermedad, $Deficiencias, $Img, $Complicaciones)
    {
        $sql = "UPDATE epa SET Fecha_Encuentro = :Fecha_Encuentro, Nombre = :Nombre, Descripcion = :Descripcion, Tipo_Enfermedad = :Tipo_Enfermedad, Deficiencias = :Deficiencias, Img = :Img, Complicaciones = :Complicaciones WHERE Id_Epa = :Id_Epa";
        $arrayEpa = array(
            ':Fecha_Encuentro' => $Fecha_Encuentro,
            ':Nombre' => $Nombre,
            ':Descripcion' => $Descripcion,
            ':Tipo_Enfermedad' => $Tipo_Enfermedad,
            ':Deficiencias' => $Deficiencias,
            ':Img' => $Img,
            ':Complicaciones' => $Complicaciones,
            ':Id_Epa' => $Id_Epa
        );

        $request = $this->update($sql, $arrayEpa);
        return $request;
    }

    public function deleteEpa($Id_Epa)
    {
        $this->Id_Epa = $Id_Epa;
        $sql = "DELETE FROM epa WHERE Id_Epa = :Id_Epa";
        $arrayEpa = array(
            ':Id_Epa' => $Id_Epa
        );
        $request = $this->delete($sql, $arrayEpa);
        return $request;
    }

    public function getAllEpa()
    {
        $sql = 'SELECT * FROM epa';
        $request = $this->select_all($sql);
        return $request;
    }
}
?>