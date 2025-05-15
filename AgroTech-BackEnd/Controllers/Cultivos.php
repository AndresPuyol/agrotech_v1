<?php
class Cultivos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    // Obtener todos los cultivos registrados
    public function obtenerCultivos()
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {
                $cultivos = $this->model->obtenerCultivos();
                if ($cultivos) {
                    $response = array(
                        "status" => true,
                        "data" => $cultivos
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No se encontraron cultivos"
                    );
                }
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa GET"
                );
            }
        } catch (\Exception $e) {
            $response = array(
                "status" => false,
                "msg" => "Error en el proceso: " . $e->getMessage()
            );
        }
        jsonResponse($response, 200);
    }

    // Obtener un cultivo específico por su ID
    public function obtener($idCultivo)
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {
                $cultivo = $this->model->obtenerCultivo($idCultivo);

                if ($cultivo) {
                    $response = array(
                        "status" => true,
                        "data" => $cultivo
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Cultivo no encontrado"
                    );
                }
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa GET"
                );
            }
        } catch (\Exception $e) {
            $response = array(
                "status" => false,
                "msg" => "Error en el proceso: " . $e->getMessage()
            );
        }
        jsonResponse($response, 200);
    }

    // Registrar un nuevo cultivo
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
                if (!testEntero($_POST['Cantidad'])) {
                    $response = array('status' => false, 'msg' => 'La cantidad debe ser un número entero');
                    jsonResponse($response, 200);
                    die();
                }

                $Nombre = ucwords(strtolower($_POST['Nombre']));
                $Cantidad = $_POST['Cantidad'];
                $Img = $_POST['Img'];
                $Descripcion = $_POST['Descripcion'];
                $Id_Tipo_Cultivo = $_POST['Id_Tipo_Cultivo'];

                $request = $this->model->crearCultivo($Nombre, $Cantidad, $Img, $Descripcion, $Id_Tipo_Cultivo);

                if ($request > 0) {
                    $arraCultivo = array(
                        'Id_Cultivo' => $request,
                        'Nombre' => $Nombre,
                        'Cantidad' => $Cantidad,
                        'Img' => $Img,
                        'Descripcion' => $Descripcion,
                        'Id_Tipo_Cultivo' => $Id_Tipo_Cultivo
                    );

                    $response = array(
                        "status" => true,
                        "msg" => "Cultivo registrado correctamente",
                        "data" => $arraCultivo
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al registrar el cultivo"
                    );
                }
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa POST"
                );
            }
        } catch (\Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }
        jsonResponse($response, 200);
    }

    // Actualizar un cultivo
    public function actualizar($idCultivo)
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "PUT") {
                $_PUT = json_decode(file_get_contents("php://input"), true);

                $Nombre = ucwords(strtolower($_PUT['Nombre']));
                $Cantidad = $_PUT['Cantidad'];
                $Img = $_PUT['Img'];
                $Descripcion = $_PUT['Descripcion'];
                $Id_Tipo_Cultivo = $_PUT['Id_Tipo_Cultivo'];

                $request = $this->model->actualizarCultivo($idCultivo, $Nombre, $Cantidad, $Img, $Descripcion, $Id_Tipo_Cultivo);

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "Cultivo actualizado correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al actualizar el cultivo"
                    );
                }
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa PUT"
                );
            }
        } catch (\Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }
        jsonResponse($response, 200);
    }

    // Eliminar un cultivo
    public function eliminar($idCultivo)
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {
                $request = $this->model->eliminarCultivo($idCultivo);

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "Cultivo eliminado correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al eliminar el cultivo"
                    );
                }
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa DELETE"
                );
            }
        } catch (\Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }
        jsonResponse($response, 200);
    }
}