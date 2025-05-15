<?php
class TipoCultivo extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function tipoCultivo($idTipo)
    {
        echo "Hola desde tipo de cultivo " . $idTipo;
    }

    public function registrar()
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "POST") {
                $_POST = json_decode(file_get_contents("php://input"), true);

                if (!testString($_POST['Nombre'])) {
                    $response = array('status' => false, 'msg' => 'El nombre debe ser un texto');
                    jsonResponse($response, 200);
                    die();
                }

                $Nombre = ucwords(strtolower($_POST['Nombre']));
                $Descripcion = $_POST['Descripcion'];

                $request = $this->model->crearTipoCultivo($Nombre, $Descripcion);

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "Tipo de cultivo registrado correctamente",
                        "Id_Tipo_Cultivo" => $request
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al registrar el tipo de cultivo"
                    );
                }
                $code = 200;

            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa POST"
                );
                $code = 400;
            }

        } catch (\Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function actualizar($idTipo)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "PUT") {
                $_PUT = json_decode(file_get_contents("php://input"), true);

                error_log("Datos recibidos en actualizar: " . print_r($_PUT, true));

                $Nombre = ucwords(strtolower($_PUT['Nombre']));
                $Descripcion = $_PUT['Descripcion'];

                $request = $this->model->actualizarTipoCultivo($idTipo, $Nombre, $Descripcion);

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "Tipo de cultivo actualizado correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al actualizar el tipo de cultivo"
                    );
                }
                $code = 200;

            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa PUT"
                );
                $code = 400;
            }

        } catch (\Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function eliminar($idTipo)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {
                $request = $this->model->eliminarTipoCultivo($idTipo);

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "Tipo de cultivo eliminado correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al eliminar el tipo de cultivo"
                    );
                }
                $code = 200;

            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa DELETE"
                );
                $code = 400;
            }

        } catch (\Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function obtener($idTipo)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {
                $tipoCultivo = $this->model->obtenerTipoCultivo($idTipo);

                if ($tipoCultivo) {
                    $response = array(
                        "status" => true,
                        "data" => $tipoCultivo
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Tipo de cultivo no encontrado"
                    );
                }
                $code = 200;

            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa GET"
                );
                $code = 400;
            }

        } catch (\Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function obtenerTipos()
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {
                $tiposCultivo = $this->model->obtenerTiposCultivo();

                if ($tiposCultivo) {
                    $response = array(
                        "status" => true,
                        "data" => $tiposCultivo
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No se encontraron tipos de cultivo"
                    );
                }
                $code = 200;

            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa GET"
                );
                $code = 400;
            }

        } catch (\Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }

        jsonResponse($response, $code);
    }
}
?>
