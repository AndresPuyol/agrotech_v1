<?php

class MaterialesModel extends Mysql
{
    private $Id_Material;
    private $Nombre;
    private $Precio;
    private $Descripcion;
    private $Tipo_Material;
    private $Tipo_Medida_Material;
    private $Cantidad;

    public function setMaterial($Nombre, $Precio, $Descripcion, $Tipo_Material, $Tipo_Medida_Material, $Cantidad)
    {
        $this->Nombre = $Nombre;
        $this->Precio = $Precio;
        $this->Descripcion = $Descripcion;
        $this->Tipo_Material = $Tipo_Material;
        $this->Tipo_Medida_Material = $Tipo_Medida_Material;
        $this->Cantidad = $Cantidad;

        $sql = "SELECT Id_Material, Nombre FROM Materiales WHERE Id_material = :Id OR Nombre = :Nom";
        $arrayParams = array(
            ':Id' => $this->Id_Material,
            ':Nom' => $this->Nombre
        );

        $request = $this->select($sql, $arrayParams);
        if (!empty($request)) {
            return false;
        } else {
            $query_insert = "INSERT INTO `materiales`(`Nombre`, `Precio`, `Descripcion`, `Tipo_Material`, `Tipo_Medida_Material`, `Cantidad`) VALUES(:Nombre,:Precio,:Descripcion,:TipoM,:TipoMM,:Cantidad)";

            $arrayMaterial = array(
                ':Nombre' => $Nombre,
                ':Precio' => $Precio,
                ':Descripcion' => $Descripcion,
                ':TipoM' => $Tipo_Material,
                ':TipoMM' => $Tipo_Medida_Material,
                ':Cantidad' => $Cantidad
            );

            $request_insert = $this->insert($query_insert, $arrayMaterial);
            return $request_insert;
        }
    }

    public function getMaterial(int $Id_Material)
    {
        $this->Id_Material = $Id_Material;
        $sql = "SELECT Nombre,Precio,Descripcion,Tipo_Material,Tipo_Medida_Material,Cantidad FROM Materiales WHERE Id_Material = :Id_Material";
        $arrayMaterial = array(
            ':Id_Material' => $Id_Material
        );

        $request = $this->select($sql, $arrayMaterial);
        return $request;
    }

    public function updateMaterial($Id_Material, $Nombre, $Precio, $Descripcion, $Tipo_Material, $Tipo_Medida_Material, $Cantidad)
    {
        // Verificar si los datos actuales son los mismos que los nuevos datos
        $sql_check = "SELECT Nombre, Precio, Descripcion, Tipo_Material, Tipo_Medida_Material, Cantidad FROM Materiales WHERE Id_Material = :Id_Material";
        $arrayCheck = array(':Id_Material' => $Id_Material);
        $currentData = $this->select($sql_check, $arrayCheck);

        if ($currentData['Nombre'] == $Nombre && $currentData['Precio'] == $Precio && $currentData['Descripcion'] == $Descripcion && $currentData['Tipo_Material'] == $Tipo_Material && $currentData['Tipo_Medida_Material'] == $Tipo_Medida_Material && $currentData['Cantidad'] == $Cantidad) {
            // Si los datos son los mismos, no realizar la actualización
            return false;
        }

        // Si los datos son diferentes, proceder con la actualización
        $sql = "UPDATE Materiales SET Nombre = :Nombre, Precio = :Precio, Descripcion = :Descripcion, Tipo_Material = :TipoM, Tipo_Medida_Material = :TipoMM, Cantidad = :Cantidad WHERE Id_Material = :Id_Material";
        $arrayMaterial = array(
            ':Nombre' => $Nombre,
            ':Precio' => $Precio,
            ':Descripcion' => $Descripcion,
            ':TipoM' => $Tipo_Material,
            ':TipoMM' => $Tipo_Medida_Material,
            ':Cantidad' => $Cantidad,
            ':Id_Material' => $Id_Material
        );

        $request = $this->update($sql, $arrayMaterial);
        return $request;
    }

    public function deleteMaterial($Id_Material)
    {
      $this->Id_Material = $Id_Material;
      $sql = "DELETE FROM Materiales WHERE Id_Material = :Id_Material";
      $arrayMaterial = array(
          ':Id_Material' => $Id_Material
      );
      $request = $this->delete($sql, $arrayMaterial);
      return $request;
    }

    public function GetAllMaterial()
    {
        $sql = 'SELECT * FROM Materiales';
        $request = $this->select_all($sql);
        return $request;
    }
    
}
