<?php
class Actividad extends Controllers
{
    public function registrarActividad()
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "POST") {
                $_POST = json_decode(file_get_contents("php://input"), true);

                if (!testString($_POST['Titulo'])) {
                    $response = array('status' => false, 'msg' => 'El título debe ser un texto');
                    jsonResponse($response, 200);
                    die();
                }

                if (!testString($_POST['Descripcion'])) {
                    $response = array('status' => false, 'msg' => 'La descripción debe ser un texto');
                    jsonResponse($response, 200);
                    die();
                }

                if (!validateDate($_POST['Fecha'])) {
                    $response = array('status' => false, 'msg' => 'La fecha no es válida');
                    jsonResponse($response, 200);
                    die();
                }

                $Titulo = ucwords(strtolower($_POST['Titulo']));
                $Descripcion = ucwords(strtolower($_POST['Descripcion']));
                $Fecha = $_POST['Fecha'];
                $Img = isset($_POST['Img']) ? $_POST['Img'] : null;
                $Id_Identificacion = $_POST['Id_Identificacion'];
                $Id_Cultivo = $_POST['Id_Cultivo'];

                $request = $this->model->setactividad($Titulo, $Descripcion, $Fecha, $Img, $Id_Identificacion, $Id_Cultivo);

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "Actividad registrada correctamente",
                        "data" => array(
                            'Titulo' => $Titulo,
                            'Descripcion' => $Descripcion,
                            'Fecha' => $Fecha,
                            'Img' => $Img,
                            'Id_Identificacion' => $Id_Identificacion,
                            'Id_Cultivo' => $Id_Cultivo
                        )
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al registrar la actividad, ya está registrada"
                    );
                }
                $code = 200;
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Error en la solicitud: " . $method . " cambie a POST"
                );
                $code = 400;
            }
        } catch (Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }
        jsonResponse($response, $code);
    }

    public function obtenerActividad($Id_Actividad)
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {
                $actividad = $this->model->getactividad($Id_Actividad);

                if ($actividad) {
                    $response = array(
                        "status" => true,
                        "data" => $actividad
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No se encontraron registros de la actividad con ID: " . $Id_Actividad
                    );
                }
                $code = 200;
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Error en la solicitud: " . $method . " cambie a GET"
                );
                $code = 400;
            }
        } catch (Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }
        jsonResponse($response, $code);
    }

    public function actualizarActividad($Id_Actividad)
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "PUT") {
                $_PUT = json_decode(file_get_contents("php://input"), true);

                if (!testString($_PUT['Titulo'])) {
                    $response = array('status' => false, 'msg' => 'El título debe ser un texto');
                    jsonResponse($response, 200);
                    die();
                }

                if (!testString($_PUT['Descripcion'])) {
                    $response = array('status' => false, 'msg' => 'La descripción debe ser un texto');
                    jsonResponse($response, 200);
                    die();
                }

                $Titulo = ucwords(strtolower($_PUT['Titulo']));
                $Descripcion = ucwords(strtolower($_PUT['Descripcion']));
                $Fecha = $_PUT['Fecha'];
                $Img = isset($_PUT['Img']) ? $_PUT['Img'] : null;
                $Id_Identificacion = $_PUT['Id_Identificacion'];
                $Id_Cultivo = $_PUT['Id_Cultivo'];

                $request = $this->model->updateactividad($Id_Actividad, $Titulo, $Descripcion, $Fecha, $Img, $Id_Identificacion, $Id_Cultivo);

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "Actividad actualizada correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al actualizar la actividad"
                    );
                }
                $code = 200;
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Error en la solicitud: " . $method . " cambie a PUT"
                );
                $code = 400;
            }
        } catch (Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }
        jsonResponse($response, $code);
    }

    public function eliminarActividad($Id_Actividad)
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {
                $actividad = $this->model->deletectividad($Id_Actividad);

                if ($actividad) {
                    $request = $this->model->deleteActividad($Id_Actividad);

                    if ($request > 0) {
                        $response = array(
                            "status" => true,
                            "msg" => "Actividad eliminada correctamente",
                            "data" => $actividad
                        );
                    } else {
                        $response = array(
                            "status" => false,
                            "msg" => "Error al eliminar la actividad"
                        );
                    }
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Actividad no encontrada"
                    );
                }
                $code = 200;
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Error en la solicitud: " . $method . " cambie a DELETE"
                );
                $code = 400;
            }
        } catch (Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }
        jsonResponse($response, $code);
    }

    public function informacionActividad()
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {
                $actividades = $this->model->getactividades();

                if ($actividades) {
                    $response = array(
                        "status" => true,
                        "data" => $actividades
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No se encontraron registros de actividades"
                    );
                }
                $code = 200;
            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Error en la solicitud: " . $method . " cambie a GET"
                );
                $code = 400;
            }
        } catch (Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }
        jsonResponse($response, $code);
    }
}