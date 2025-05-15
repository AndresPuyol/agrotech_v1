<?php
class TipoUsuarioModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // Crear un nuevo tipo de usuario
    public function crearTipoUsuario($nombre, $descripcion)
    {
        $sql = "INSERT INTO Tipo_Usuario (Nombre, Descripcion) VALUES (?, ?)";
        $arrData = array($nombre, $descripcion);
        return $this->insert($sql, $arrData);
    }

    // Actualizar un tipo de usuario existente
    public function actualizarTipoUsuario($idTipoUsuario, $nombre, $descripcion)
    {
        $sql = "UPDATE Tipo_Usuario SET Nombre = ?, Descripcion = ? WHERE Id_Tipo_Usuario = ?";
        $arrData = array($nombre, $descripcion, $idTipoUsuario);
        return $this->update($sql, $arrData);
    }

    // Eliminar un tipo de usuario
    public function eliminarTipoUsuario($idTipoUsuario)
    {
        $sql = "DELETE FROM Tipo_Usuario WHERE Id_Tipo_Usuario = ?";
        $arrData = array($idTipoUsuario);
        return $this->delete($sql, $arrData);
    }

    // Obtener un tipo de usuario por ID
    public function obtenerTipoUsuario($idTipoUsuario)
    {
        $sql = "SELECT * FROM Tipo_Usuario WHERE Id_Tipo_Usuario = ?";
        return $this->select($sql, array($idTipoUsuario));
    }

    // Obtener todos los tipos de usuario
    public function obtenerTodosLosTiposUsuario()
    {
        $sql = "SELECT * FROM Tipo_Usuario";
        return $this->select_all($sql);
    }

    // Obtener un tipo de usuario por nombre
    public function obtenerTipoUsuarioPorNombre($nombre)
    {
        $sql = "SELECT * FROM Tipo_Usuario WHERE Nombre = ?";
        return $this->select($sql, array($nombre));
    }
}
?>
