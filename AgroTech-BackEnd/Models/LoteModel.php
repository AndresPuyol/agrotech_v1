<?php

class LoteModel extends Mysql
{
    private $intIdLote;
    private $decLongitud;
    private $intLocalizacion;
    private $strNombre;
    private $decLatitud;
    private $decArea;

    public function __construct()
    {
        parent::__construct();
    }

    public function setLote(float $longitud, int $localizacion, string $nombre, float $latitud, float $area)
    {
        $this->decLongitud = $longitud;
        $this->intLocalizacion = $localizacion;
        $this->strNombre = $nombre;
        $this->decLatitud = $latitud;
        $this->decArea = $area;

        // Verificar si el lote ya existe
        $sql = "SELECT nombre FROM lotes WHERE nombre = :nombre";
        $arrayParams = array(':nombre' => $nombre);

        $request = $this->select($sql, $arrayParams);

        if (!empty($request)) {
            return false;
        } else {
            // Insertar el lote si no existe
            $query_insert = "INSERT INTO lotes(longitud, localizacion, nombre, latitud, area) VALUES (:longitud, :localizacion, :nombre, :latitud, :area)";
            $arrayData = array(
                ':longitud' => $this->decLongitud,
                ':localizacion' => $this->intLocalizacion,
                ':nombre' => $this->strNombre,
                ':latitud' => $this->decLatitud,
                ':area' => $this->decArea
            );

            $request_insert = $this->insert($query_insert, $arrayData);
            return $request_insert;
        }
    }

    public function updateLote(int $idLote, float $longitud, int $localizacion, string $nombre, float $latitud, float $area)
    {
        $this->intIdLote = $idLote;
        $this->decLongitud = $longitud;
        $this->intLocalizacion = $localizacion;
        $this->strNombre = $nombre;
        $this->decLatitud = $latitud;
        $this->decArea = $area;

        $sql = "UPDATE lotes SET longitud = :longitud, localizacion = :localizacion, nombre = :nombre, latitud = :latitud, area = :area WHERE id_lote = :id";
        $arrayData = array(
            ':id' => $this->intIdLote,
            ':longitud' => $this->decLongitud,
            ':localizacion' => $this->intLocalizacion,
            ':nombre' => $this->strNombre,
            ':latitud' => $this->decLatitud,
            ':area' => $this->decArea
        );

        $request = $this->update($sql, $arrayData);
        return $request;
    }

    public function deleteLote(int $idLote)
    {
        $this->intIdLote = $idLote;
        $sql = "DELETE FROM lotes WHERE id_lote = :id";
        $arrayData = array(':id' => $this->intIdLote);

        $request = $this->delete($sql, $arrayData);
        return $request;
    }

    public function getLote(int $idLote)
    {
        $this->intIdLote = $idLote;
        $sql = "SELECT * FROM lotes WHERE id_lote = :id";
        $arrayData = array(':id' => $this->intIdLote);

        $request = $this->select($sql, $arrayData);
        return $request;
    }

    public function getAllLotes()
    {
        $sql = "SELECT * FROM lotes";
        $request = $this->select_all($sql);
        return $request;
    }
}
?>