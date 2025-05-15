<?php
class Usuarios extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    private function getInputData()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        if (!is_array($input)) {
            jsonResponse(["status" => false, "msg" => "Datos de entrada inválidos"], 400);
            exit;
        }
        return $input;
    }

    public function registrar()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== "POST") {
                jsonResponse(["status" => false, "msg" => "Método no permitido, use POST"], 405);
                return;
            }

            $_POST = json_decode(file_get_contents("php://input"), true);

            $camposObligatorios = ['Id_Identificacion', 'Nombre', 'Apellidos', 'Telefono', 'Correo', 'Password_Hash', 'Id_Tipo_Usuario'];
            foreach ($camposObligatorios as $campo) {
                if (empty($_POST[$campo])) {
                    jsonResponse(["status" => false, "msg" => "Falta el campo: $campo"], 400);
                    return;
                }
            }

            $Correo = trim($_POST['Correo']);
            $Id_Identificacion = trim($_POST['Id_Identificacion']);
            $Id_Tipo_Usuario = intval($_POST['Id_Tipo_Usuario']); // Convertir a entero

            if (!filter_var($Correo, FILTER_VALIDATE_EMAIL)) {
                jsonResponse(["status" => false, "msg" => "Correo inválido"], 400);
                return;
            }

            if (!is_numeric($Id_Identificacion)) {
                jsonResponse(["status" => false, "msg" => "La identificación debe ser numérica"], 400);
                return;
            }

            if (!is_numeric($Id_Tipo_Usuario)) {
                jsonResponse(["status" => false, "msg" => "Tipo de usuario inválido"], 400);
                return;
            }

           // Verificar que el tipo de usuario exista
           $tipoUsuarioExiste = $this->model->verificarTipoUsuario($Id_Tipo_Usuario);

           if (!$tipoUsuarioExiste) {
               jsonResponse(["status" => false, "msg" => "El tipo de usuario no existe"], 400);
               return;
           }


            if ($this->model->verificarUsuarioPorCorreo($Correo)) {
                jsonResponse(["status" => false, "msg" => "El correo ya está en uso"], 409);
                return;
            }

            if ($this->model->verificarIdentificacionExistente($Id_Identificacion)) {
                jsonResponse(["status" => false, "msg" => "La identificación ya está en uso"], 409);
                return;
            }

            $Password_Hash = password_hash($_POST['Password_Hash'], PASSWORD_DEFAULT);

            $request = $this->model->crearUsuario(
                $Id_Identificacion,
                $_POST['Nombre'],
                $_POST['Apellidos'],
                $_POST['Telefono'],
                $Correo,
                $Password_Hash,
                $Id_Tipo_Usuario
            );

            jsonResponse(
                $request > 0
                    ? ["status" => true, "msg" => "Usuario registrado correctamente"]
                    : ["status" => false, "msg" => "Error al registrar el usuario"],
                $request > 0 ? 200 : 400
            );
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error: " . $e->getMessage()], 500);
        }
    }

    public function obtener($Id_Usuario)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== "GET") {
                jsonResponse(["status" => false, "msg" => "Método no permitido, use GET"], 405);
                return;
            }

            if (!is_numeric($Id_Usuario)) {
                jsonResponse(["status" => false, "msg" => "El ID del usuario debe ser numérico"], 400);
                return;
            }

            $usuario = $this->model->obtenerUsuario($Id_Usuario);

            if ($usuario) {
                unset($usuario['Password_Hash']);
                jsonResponse(["status" => true, "data" => $usuario], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "Usuario no encontrado"], 404);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error interno: " . $e->getMessage()], 500);
        }
    }

    public function actualizar($Id_Usuario)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== "PUT") {
                jsonResponse(["status" => false, "msg" => "Método no permitido, use PUT"], 405);
                return;
            }

            $data = $this->getInputData();

            if (!isset($data['Nombre'], $data['Apellidos'], $data['Telefono'], $data['Correo'], $data['Id_Tipo_Usuario'])) {
                jsonResponse(["status" => false, "msg" => "Faltan datos obligatorios"], 400);
                return;
            }

            if (!filter_var($data['Correo'], FILTER_VALIDATE_EMAIL)) {
                jsonResponse(["status" => false, "msg" => "Correo inválido"], 400);
                return;
            }

            if (!is_numeric($Id_Usuario)) {
                jsonResponse(["status" => false, "msg" => "El ID del usuario debe ser numérico"], 400);
                return;
            }

            $Id_Tipo_Usuario = intval($data['Id_Tipo_Usuario']);

            if (!is_numeric($Id_Tipo_Usuario)) {
                jsonResponse(["status" => false, "msg" => "El tipo de usuario debe ser numérico"], 400);
                return;
            }

            // Verificar que el tipo de usuario exista
            $tipoUsuarioExiste = $this->model->verificarTipoUsuario($Id_Tipo_Usuario);

            if (!$tipoUsuarioExiste) {
                jsonResponse(["status" => false, "msg" => "El tipo de usuario no existe"], 400);
                return;
            }

            $request = $this->model->actualizarUsuario(
                $Id_Usuario,
                $data['Nombre'],
                $data['Apellidos'],
                $data['Telefono'],
                $data['Correo'],
                $Id_Tipo_Usuario
            );

            if ($request !== false) {
                jsonResponse(["status" => true, "msg" => "Datos actualizados correctamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "Error al actualizar o datos no cambiaron"], 400);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error interno: " . $e->getMessage()], 500);
        }
    }

    public function eliminar($Id_Usuario)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== "DELETE") {
                jsonResponse(["status" => false, "msg" => "Método no permitido, use DELETE"], 405);
                return;
            }

            if (!is_numeric($Id_Usuario)) {
                jsonResponse(["status" => false, "msg" => "El ID del usuario debe ser numérico"], 400);
                return;
            }

            $request = $this->model->eliminarUsuario($Id_Usuario);

            if ($request > 0) {
                jsonResponse(["status" => true, "msg" => "Usuario eliminado correctamente"], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se encontró el usuario"], 404);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error interno: " . $e->getMessage()], 500);
        }
    }

    public function iniciarSesion()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== "POST") {
                jsonResponse(["status" => false, "msg" => "Método no permitido, use POST"], 405);
                return;
            }

            $_POST = json_decode(file_get_contents("php://input"), true);

            if (empty($_POST['Correo']) || empty($_POST['Password'])) {
                jsonResponse(["status" => false, "msg" => "Faltan datos"], 400);
                return;
            }

            if (!filter_var($_POST['Correo'], FILTER_VALIDATE_EMAIL)) {
                jsonResponse(["status" => false, "msg" => "Correo inválido"], 400);
                return;
            }

            $usuario = $this->model->obtenerPorCorreo($_POST['Correo']);

            if ($usuario && password_verify($_POST['Password'], $usuario['Password_Hash'])) {
                unset($usuario['Password_Hash']);
                jsonResponse(["status" => true, "msg" => "Inicio de sesión exitoso", "data" => $usuario], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "Credenciales incorrectas"], 401);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error: " . $e->getMessage()], 500);
        }
    }

    public function obtenerTodos()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== "GET") {
                jsonResponse(["status" => false, "msg" => "Método no permitido, use GET"], 405);
                return;
            }

            $usuarios = $this->model->obtenerTodosUsuarios();

            if ($usuarios) {
                foreach ($usuarios as &$usuario) {
                    unset($usuario['Password_Hash']);
                }
                jsonResponse(["status" => true, "data" => $usuarios], 200);
            } else {
                jsonResponse(["status" => false, "msg" => "No se encontraron usuarios"], 404);
            }
        } catch (Exception $e) {
            jsonResponse(["status" => false, "msg" => "Error interno: " . $e->getMessage()], 500);
        }
    }
}
?>
