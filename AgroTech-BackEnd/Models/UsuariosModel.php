<?php
class UsuariosModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    public function crearUsuario($Id_Identificacion, $Nombre, $Apellidos, $Telefono, $Correo, $Password_Hash, $Id_Tipo_Usuario)
    {
        $sql = "INSERT INTO Usuarios (Id_Identificacion, Nombre, Apellidos, Telefono, Correo, Password_Hash, Id_Tipo_Usuario) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $arrData = array($Id_Identificacion, $Nombre, $Apellidos, $Telefono, $Correo, $Password_Hash, $Id_Tipo_Usuario);
        return $this->insert($sql, $arrData);
    }

    public function obtenerUsuario($Id_Usuario)
    {
        if (!is_numeric($Id_Usuario)) {
            return false;
        }

        $sql = "SELECT Id_Usuario, Id_Identificacion, Nombre, Apellidos, Telefono, Correo, Id_Tipo_Usuario 
                FROM Usuarios 
                WHERE Id_Usuario = ?";
        $arrData = array($Id_Usuario);
        return $this->select($sql, $arrData);
    }

    public function actualizarUsuario($Id_Usuario, $Nombre, $Apellidos, $Telefono, $Correo, $Id_Tipo_Usuario)
    {
        $sql = "UPDATE Usuarios 
                SET Nombre = ?, Apellidos = ?, Telefono = ?, Correo = ?, Id_Tipo_Usuario = ? 
                WHERE Id_Usuario = ?";
        $arrData = array($Nombre, $Apellidos, $Telefono, $Correo, $Id_Tipo_Usuario, $Id_Usuario);
        return $this->update($sql, $arrData);
    }

    public function eliminarUsuario($Id_Usuario)
    {
        if (!is_numeric($Id_Usuario)) {
            return false;
        }

        $sql = "DELETE FROM Usuarios WHERE Id_Usuario = ?";
        $arrData = array($Id_Usuario);
        return $this->delete($sql, $arrData);
    }

    public function verificarTipoUsuario($Id_Tipo_Usuario)
    {
        $sql = "SELECT COUNT(*) as total 
                FROM Tipo_Usuario 
                WHERE Id_Tipo_Usuario = ?";
        $arrData = array($Id_Tipo_Usuario);
        $result = $this->select($sql, $arrData);

        return ($result && isset($result['total']) && $result['total'] > 0);
    }

    public function obtenerPorCorreo($Correo)
    {
        if (!filter_var($Correo, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        $sql = "SELECT Id_Usuario, Id_Identificacion, Nombre, Apellidos, Telefono, Correo, Password_Hash, Id_Tipo_Usuario 
                FROM Usuarios 
                WHERE Correo = ?";
        $arrData = array($Correo);
        return $this->select($sql, $arrData);
    }

    public function obtenerTodosUsuarios()
    {
        $sql = "SELECT Id_Usuario, Id_Identificacion, Nombre, Apellidos, Telefono, Correo, Id_Tipo_Usuario 
                FROM Usuarios";
        return $this->select_all($sql);
    }

    public function verificarUsuarioPorCorreo($Correo, $Id_Usuario = null)
    {
        $sql = "SELECT Id_Usuario 
                FROM Usuarios 
                WHERE Correo = ?";
        $arrData = array($Correo);

        if (!empty($Id_Usuario)) {
            $sql .= " AND Id_Usuario != ?";
            $arrData[] = $Id_Usuario;
        }

        $result = $this->select($sql, $arrData);

        return !empty($result);
    }
    public function verificarIdentificacionExistente($Id_Identificacion)
    {
        if (!is_numeric($Id_Identificacion)) {
            return false;
        }
    
        $sql = "SELECT Id_Usuario 
                FROM Usuarios 
                WHERE Id_Identificacion = ?";
        $arrData = array($Id_Identificacion);
        $result = $this->select($sql, $arrData);
    
        return !empty($result);
    }
    

}
?>
