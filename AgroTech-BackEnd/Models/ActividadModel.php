<?php

class ActividadModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todas las actividades
    public function getactividades()
    {
        $sql = "SELECT * FROM actividades";
        return $this->select_all($sql);
    }

    // Obtener una actividad por ID
    public function getactividad($idActividad)
    {
        $sql = "SELECT * FROM actividades WHERE Id_Actividad = ?";
        return $this->select($sql, [$idActividad]);
    }

    // Crear una nueva actividad
    public function setactividad($titulo, $descripcion, $fecha, $img, $idIdentificacion, $idCultivo)
    {
        $sql = "INSERT INTO actividades (Titulo, Descripcion, Fecha, Img, Id_Identificacion, Id_Cultivo) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $datos = [$titulo, $descripcion, $fecha, $img, $idIdentificacion, $idCultivo];

        try {
            return $this->insert($sql, $datos);
        } catch (Exception $e) {
            error_log("Error al insertar actividad: " . $e->getMessage());
            return false;
        }
    }

    // Actualizar una actividad
    public function updateactividad($idActividad, $titulo, $descripcion, $fecha, $img, $idIdentificacion, $idCultivo)
    {
        $sql = "UPDATE actividades 
                SET Titulo = ?, Descripcion = ?, Fecha = ?, Img = ?, Id_Identificacion = ?, Id_Cultivo = ? 
                WHERE Id_Actividad = ?";
        $datos = [$titulo, $descripcion, $fecha, $img, $idIdentificacion, $idCultivo, $idActividad];
        return $this->update($sql, $datos);
    }

    // Eliminar una actividad
    public function deleteactividad($idActividad)
    {
        $sql = "DELETE FROM actividades WHERE Id_Actividad = ?";
        return $this->delete($sql, [$idActividad]);
    }
}