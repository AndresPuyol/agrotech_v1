<?php
class TratamientoModel extends Mysql
{
    private $intId;
    private $strDescripcion;
    private $dateFechaInicio;
    private $dateFechaFinal;
    private $strTipoTratamiento;

    public function __construct()
    {
        parent::__construct();
    }

    public function setTratamiento(string $descripcion, string $fechaInicio, string $fechaFinal, string $tipoTratamiento)
    {
        // Validación: Fecha de inicio no puede ser mayor a fecha final
        if (strtotime($fechaInicio) > strtotime($fechaFinal)) {
            return -1; // Código especial para indicar error en fechas
        }

        $this->strDescripcion = trim($descripcion);
        $this->dateFechaInicio = $fechaInicio;
        $this->dateFechaFinal = $fechaFinal;
        $this->strTipoTratamiento = trim($tipoTratamiento);

        $sql = "INSERT INTO tratamientos (descripcion, fecha_inicio, fecha_final, Tipo_Tratamiento) 
                VALUES (:desc, :inicio, :final, :tipo)";
        $arrayData = [
            ':desc' => $this->strDescripcion,
            ':inicio' => $this->dateFechaInicio,
            ':final' => $this->dateFechaFinal,
            ':tipo' => $this->strTipoTratamiento
        ];

        return $this->insert($sql, $arrayData);
    }

    public function updateTratamiento(int $id, string $descripcion, string $fechaInicio, string $fechaFinal, string $tipoTratamiento)
    {
        // Validación: Fecha de inicio no puede ser mayor a fecha final
        if (strtotime($fechaInicio) > strtotime($fechaFinal)) {
            if (strtotime($fechaInicio) > strtotime($fechaFinal)) {
                die("⚠️ Error: La fecha de inicio no puede ser mayor a la fecha final");
                return -1; // Código especial para indicar error en fechas
            }
            
            return -1; // Código especial para indicar error en fechas
        }

        // Verificar si el tratamiento existe antes de actualizar
        if (!$this->existsTratamiento($id)) {
            return 0; // Código especial para indicar que no existe
        }

        $this->intId = $id;
        $this->strDescripcion = trim($descripcion);
        $this->dateFechaInicio = $fechaInicio;
        $this->dateFechaFinal = $fechaFinal;
        $this->strTipoTratamiento = trim($tipoTratamiento);

        $sql = "UPDATE tratamientos SET descripcion = :desc, fecha_inicio = :inicio, fecha_final = :final, Tipo_Tratamiento = :tipo 
                WHERE PK_id_tratamiento = :id";
        $arrayData = [
            ':desc' => $this->strDescripcion,
            ':inicio' => $this->dateFechaInicio,
            ':final' => $this->dateFechaFinal,
            ':tipo' => $this->strTipoTratamiento,
            ':id' => $this->intId
        ];

        return $this->update($sql, $arrayData);
    }

    public function deleteTratamiento(int $id)
    {
        // Verificar si el tratamiento existe antes de eliminar
        if (!$this->existsTratamiento($id)) {
            return 0; // Código especial para indicar que no existe
        }

        $this->intId = $id;
        $sql = "DELETE FROM tratamientos WHERE PK_id_tratamiento = :id";
        $arrayData = [':id' => $this->intId];

        return $this->delete($sql, $arrayData);
    }

    public function getTratamiento(int $id)
    {
        $sql = "SELECT * FROM tratamientos WHERE PK_id_tratamiento = :id";
        $arrayData = [':id' => $id];

        return $this->select($sql, $arrayData);
    }

    private function existsTratamiento(int $id)
    {
        $sql = "SELECT PK_id_tratamiento FROM tratamientos WHERE PK_id_tratamiento = :id";
        $arrayData = [':id' => $id];

        $result = $this->select($sql, $arrayData);
        return !empty($result);
    }
}
?>
