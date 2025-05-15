<?php

class SurcoModel extends Mysql
{
    private $intIdSurco;
    private $strNombre;
    private $strDescripcion;
    private $intIdLote;
    private $intIdCultivo;

    public function __construct()
    {
        parent::__construct();
    }

    public function setSurco(string $Nombre, string $Descripcion, int $Id_Lote, int $Id_Cultivo)
    {
        $this->strNombre = $Nombre;
        $this->strDescripcion = $Descripcion;
        $this->intIdLote = $Id_Lote;
        $this->intIdCultivo = $Id_Cultivo;

        $sql = "SELECT Nombre FROM surcos WHERE Nombre = :Nombre AND Id_Lote = :Id_Lote AND Id_Cultivo = :Id_Cultivo";
        $arrayParams = array(
            ':Nombre' => $Nombre,
            ':Id_Lote' => $Id_Lote,
            ':Id_Cultivo' => $Id_Cultivo
        );

        $request = $this->select($sql, $arrayParams);

        if (!empty($request)) {
            return false;
        } else {
            $query_insert = "INSERT INTO surcos(Nombre, Descripcion, Id_Lote, Id_Cultivo) VALUES (:Nombre, :Descripcion, :Id_Lote, :Id_Cultivo)";
            $arrayData = array(
                ':Nombre' => $this->strNombre,
                ':Descripcion' => $this->strDescripcion,
                ':Id_Lote' => $this->intIdLote,
                ':Id_Cultivo' => $this->intIdCultivo
            );

            $request_insert = $this->insert($query_insert, $arrayData);
            return $request_insert;
        }
    }

    public function updateSurco(int $Id_Surco, string $Nombre, string $Descripcion, int $Id_Lote, int $Id_Cultivo)
    {
        $this->intIdSurco = $Id_Surco;
        $this->strNombre = $Nombre;
        $this->strDescripcion = $Descripcion;
        $this->intIdLote = $Id_Lote;
        $this->intIdCultivo = $Id_Cultivo;

        $sql = "UPDATE surcos SET Nombre = :Nombre, Descripcion = :Descripcion, Id_Lote = :Id_Lote, Id_Cultivo = :Id_Cultivo WHERE Id_Surco = :Id_Surco";
        $arrayData = array(
            ':Nombre' => $this->strNombre,
            ':Descripcion' => $this->strDescripcion,
            ':Id_Lote' => $this->intIdLote,
            ':Id_Cultivo' => $this->intIdCultivo,
            ':Id_Surco' => $this->intIdSurco
        );

        $request = $this->update($sql, $arrayData);
        return $request;
    }

    public function deleteSurco(int $Id_Surco)
    {
        $this->intIdSurco = $Id_Surco;
        $sql = "DELETE FROM surcos WHERE Id_Surco = :Id_Surco";
        $arrayData = array(':Id_Surco' => $this->intIdSurco);

        $request = $this->delete($sql, $arrayData);
        return $request;
    }

    public function getSurco(int $Id_Surco)
    {
        $this->intIdSurco = $Id_Surco;
        $sql = "SELECT * FROM surcos WHERE Id_Surco = :Id_Surco";
        $arrayData = array(':Id_Surco' => $this->intIdSurco);

        $request = $this->select($sql, $arrayData);
        return $request;
    }

    public function getAllSurcos()
    {
        $sql = "SELECT * FROM surcos";
        $request = $this->select_all($sql);
        return $request;
    }
}
?>