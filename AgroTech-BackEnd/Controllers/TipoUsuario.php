<?php
class TipoUsuario extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    // Método para validar método HTTP
    private function validarMetodo($metodo)
    {
        if ($_SERVER['REQUEST_METHOD'] !== $metodo) {
            jsonResponse(["status" => false, "msg" => "Método no permitido, use {$metodo}"], 405);
            exit;
        }
    }

    // Método para validar que el ID sea numérico
    private function validarId($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            jsonResponse(["status" => false, "msg" => "ID inválido"], 400);
            exit;
        }
    }

    // Registrar un tipo de usuario
    public function registrar()
    {
        try {
            $this->validarMetodo('POST');

            $_POST = json_decode(file_get_contents("php://input"), true);

            if (empty($_POST['nombre']) || !is_string($_POST['nombre'])) {
                jsonResponse(['status' => false, 'msg' => 'El nombre es obligatorio y debe ser texto'], 400);
                return;
            }

            $nombre = trim($_POST['nombre']);
            $descripcion = $_POST['descripcion'] ?? '';

            $existe = $this->model->obtenerTipoUsuarioPorNombre($nombre);
            if ($existe) {
                jsonResponse(["status" => false, "msg" => "Ya existe un tipo de usuario con ese nombre"], 409);
                return;
            }

            $request = $this->model->crearTipoUsuario($nombre, $descripcion);

            jsonResponse(
                $request > 0
                    ? ["status" => true, "msg" => "Tipo de usuario registrado correctamente"]
                    : ["status" => false, "msg" => "Error al registrar el tipo de usuario"],
                $request > 0 ? 200 : 400
            );
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error interno: " . $e->getMessage()], 500);
        }
    }

    // Actualizar un tipo de usuario
    public function actualizar($idTipoUsuario)
    {
        try {
            $this->validarMetodo('PUT');
            $this->validarId($idTipoUsuario);

            $_PUT = json_decode(file_get_contents("php://input"), true);

            if (empty($_PUT['nombre']) || !is_string($_PUT['nombre'])) {
                jsonResponse(["status" => false, "msg" => "El nombre es obligatorio y debe ser texto"], 400);
                return;
            }

            $nombre = trim($_PUT['nombre']);
            $descripcion = $_PUT['descripcion'] ?? '';

            $existe = $this->model->obtenerTipoUsuarioPorNombre($nombre);
            if ($existe && $existe['id'] != $idTipoUsuario) {
                jsonResponse(["status" => false, "msg" => "Ya existe otro tipo de usuario con ese nombre"], 409);
                return;
            }

            $request = $this->model->actualizarTipoUsuario($idTipoUsuario, $nombre, $descripcion);

            jsonResponse(
                $request > 0
                    ? ["status" => true, "msg" => "Datos actualizados correctamente"]
                    : ["status" => false, "msg" => "Error al actualizar o no hubo cambios"],
                $request > 0 ? 200 : 400
            );
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error interno: " . $e->getMessage()], 500);
        }
    }

    // Eliminar un tipo de usuario
    public function eliminar($idTipoUsuario)
    {
        try {
            $this->validarMetodo('DELETE');
            $this->validarId($idTipoUsuario);

            $request = $this->model->eliminarTipoUsuario($idTipoUsuario);

            jsonResponse(
                $request > 0
                    ? ["status" => true, "msg" => "Tipo de usuario eliminado"]
                    : ["status" => false, "msg" => "No se encontró el tipo de usuario"],
                $request > 0 ? 200 : 404
            );
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error interno: " . $e->getMessage()], 500);
        }
    }

    // Obtener un tipo de usuario por ID
    public function obtener($idTipoUsuario)
    {
        try {
            $this->validarMetodo('GET');
            $this->validarId($idTipoUsuario);

            $tipoUsuario = $this->model->obtenerTipoUsuario($idTipoUsuario);

            jsonResponse(
                $tipoUsuario
                    ? ["status" => true, "data" => $tipoUsuario]
                    : ["status" => false, "msg" => "Tipo de usuario no encontrado"],
                $tipoUsuario ? 200 : 404
            );
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error interno: " . $e->getMessage()], 500);
        }
    }

    // Obtener todos los tipos de usuario
    public function listarTodos()
    {
        try {
            $this->validarMetodo('GET');

            $tiposUsuario = $this->model->obtenerTodosLosTiposUsuario();

            jsonResponse(
                !empty($tiposUsuario)
                    ? ["status" => true, "data" => $tiposUsuario]
                    : ["status" => false, "msg" => "No hay tipos de usuario registrados"],
                !empty($tiposUsuario) ? 200 : 404
            );
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error interno: " . $e->getMessage()], 500);
        }
    }
}
?>
