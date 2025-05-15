<?php
class Producciones extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    // Registrar una nueva producción
    public function registrar()
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "POST") {
                $_POST = json_decode(file_get_contents("php://input"), true);

                // Validaciones
                $Cantidad = strClean($_POST['Cantidad']);
                $Fecha = strClean($_POST['Fecha']);
                $Id_Cultivo = strClean($_POST['Id_Cultivo']);

                if (!testEntero($Cantidad)) {
                    $response = array('status' => false, 'msg' => 'La cantidad debe ser un número entero');
                    jsonResponse($response, 400);
                    die();
                }

                if (!testFecha($Fecha)) {
                    $response = array('status' => false, 'msg' => 'La fecha debe estar en el formato YYYY-MM-DD HH:mm:ss');
                    jsonResponse($response, 400);
                    die();
                }

                if (!testEntero($Id_Cultivo)) {
                    $response = array('status' => false, 'msg' => 'El ID del cultivo debe ser un número entero');
                    jsonResponse($response, 400);
                    die();
                }

                // Verificar si el cultivo existe
                if (!$this->model->verificarCultivo($Id_Cultivo)) {
                    $response = array('status' => false, 'msg' => 'El cultivo especificado no existe');
                    jsonResponse($response, 400);
                    die();
                }

                // Registrar la producción
                $request = $this->model->crearProduccion($Cantidad, $Fecha, $Id_Cultivo);

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "Producción registrada correctamente",
                        "Id_Produccion" => $request
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al registrar la producción"
                    );
                }
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa POST"
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

    // Obtener todas las producciones
    public function obtenerProducciones()
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {
                $producciones = $this->model->obtenerProducciones();
                if ($producciones) {
                    $response = array(
                        "status" => true,
                        "data" => $producciones
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No se encontraron producciones"
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

    // Obtener una producción por ID
    public function obtener($idProduccion)
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {
                $produccion = $this->model->obtenerProduccion($idProduccion);
                if ($produccion) {
                    $response = array(
                        "status" => true,
                        "data" => $produccion
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Producción no encontrada"
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

    // Actualizar una producción
    public function actualizar($idProduccion)
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "PUT") {
                $_PUT = json_decode(file_get_contents("php://input"), true);

                // Validaciones
                $Cantidad = strClean($_PUT['Cantidad']);
                $Fecha = strClean($_PUT['Fecha']);
                $Id_Cultivo = strClean($_PUT['Id_Cultivo']);

                if (!testEntero($Cantidad)) {
                    $response = array('status' => false, 'msg' => 'La cantidad debe ser un número entero');
                    jsonResponse($response, 400);
                    die();
                }

                if (!testFecha($Fecha)) {
                    $response = array('status' => false, 'msg' => 'La fecha debe estar en el formato YYYY-MM-DD HH:mm:ss');
                    jsonResponse($response, 400);
                    die();
                }

                if (!testEntero($Id_Cultivo)) {
                    $response = array('status' => false, 'msg' => 'El ID del cultivo debe ser un número entero');
                    jsonResponse($response, 400);
                    die();
                }

                // Actualizar la producción
                $request = $this->model->actualizarProduccion($idProduccion, $Cantidad, $Fecha, $Id_Cultivo);

                if ($request) {
                    $response = array(
                        "status" => true,
                        "msg" => "Producción actualizada correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al actualizar la producción"
                    );
                }
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa PUT"
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

    // Eliminar una producción
    public function eliminar($idProduccion)
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {
                $request = $this->model->eliminarProduccion($idProduccion);

                if ($request) {
                    $response = array(
                        "status" => true,
                        "msg" => "Producción eliminada correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al eliminar la producción"
                    );
                }
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Método no permitido. Usa DELETE"
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
}
?>
