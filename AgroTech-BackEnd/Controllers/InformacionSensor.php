<?php
class InformacionSensor extends Controllers
{
    public function informacionSensor($Id_Informacion_Sensor)
    {
        echo "Hola desde InformacionSensor con ID: " . $Id_Informacion_Sensor;
    }

    public function registrarInformacionSensor()
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "POST") {

                $_POST = json_decode(file_get_contents("php://input"), true);

                if (!isset($_POST['Fecha_Registro'])) {
                    $response = array('status' => false, 'msg' => 'Debe incluir la Fecha_Registro');
                    jsonResponse($response, 200);
                    die();
                }

                if (!isset($_POST['Valor_Maximo']) || !testEntero($_POST['Valor_Maximo'])) {
                    $response = array('status' => false, 'msg' => 'El Valor_Maximo debe ser numerico');
                    jsonResponse($response, 200);
                    die();
                }

                if (!isset($_POST['Valor_Minimo']) || !testEntero($_POST['Valor_Minimo'])) {
                    $response = array('status' => false, 'msg' => 'El Valor_Minimo debe ser numerico');
                    jsonResponse($response, 200);
                    die();
                }

                if (!isset($_POST['Id_Sensor']) || !testEntero($_POST['Id_Sensor'])) {
                    $response = array('status' => false, 'msg' => 'El Id_Sensor debe ser numerico');
                    jsonResponse($response, 200);
                    die();
                }

                $fecha = $_POST['Fecha_Registro'];
                $max = $_POST['Valor_Maximo'];
                $min = $_POST['Valor_Minimo'];
                $sensor = $_POST['Id_Sensor'];

                $request = $this->model->setInformacionSensor($fecha, $max, $min, $sensor);

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "Datos registrados correctamente",
                        "data" => [
                            "Id_Informacion_Sensor" => $request,
                            "Fecha_Registro" => $fecha,
                            "Valor_Maximo" => $max,
                            "Valor_Minimo" => $min,
                            "Id_Sensor" => $sensor
                        ]
                    );
                } else {
                    $response = array("status" => false, "msg" => "Error al registrar");
                }
                $code = 200;
            } else {
                $response = array("status" => false, "msg" => "Error en solicitud: $method. Use POST");
                $code = 400;
            }
        } catch (Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function obtenerInformacionSensor($Id_Informacion_Sensor)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $info = $this->model->getInformacionSensor($Id_Informacion_Sensor);

                if ($info) {
                    $response = array("status" => true, "data" => $info);
                } else {
                    $response = array("status" => false, "msg" => "Registro no encontrado");
                }
                $code = 200;
            } else {
                $response = array("status" => false, "msg" => "Error en solicitud: $method. Use GET");
                $code = 400;
            }
        } catch (Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function actualizarInformacionSensor($Id_Informacion_Sensor)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "PUT") {

                $_PUT = json_decode(file_get_contents("php://input"), true);

                if (!isset($_PUT['Fecha_Registro'])) {
                    $response = array('status' => false, 'msg' => 'Debe incluir la Fecha_Registro');
                    jsonResponse($response, 200);
                    die();
                }

                if (!isset($_PUT['Valor_Maximo']) || !testEntero($_PUT['Valor_Maximo'])) {
                    $response = array('status' => false, 'msg' => 'El Valor_Maximo debe ser numerico');
                    jsonResponse($response, 200);
                    die();
                }

                if (!isset($_PUT['Valor_Minimo']) || !testEntero($_PUT['Valor_Minimo'])) {
                    $response = array('status' => false, 'msg' => 'El Valor_Minimo debe ser numerico');
                    jsonResponse($response, 200);
                    die();
                }

                if (!isset($_PUT['Id_Sensor']) || !testEntero($_PUT['Id_Sensor'])) {
                    $response = array('status' => false, 'msg' => 'El Id_Sensor debe ser numerico');
                    jsonResponse($response, 200);
                    die();
                }

                $fecha = $_PUT['Fecha_Registro'];
                $max = $_PUT['Valor_Maximo'];
                $min = $_PUT['Valor_Minimo'];
                $sensor = $_PUT['Id_Sensor'];

                $request = $this->model->updateInformacionSensor($Id_Informacion_Sensor, $fecha, $max, $min, $sensor);

                if ($request > 0) {
                    $response = array("status" => true, "msg" => "Datos actualizados correctamente");
                } else {
                    $response = array("status" => false, "msg" => "No se realizaron cambios");
                }
                $code = 200;
            } else {
                $response = array("status" => false, "msg" => "Error en solicitud: $method. Use PUT");
                $code = 400;
            }
        } catch (Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function eliminarInformacionSensor($Id_Informacion_Sensor)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {

                $info = $this->model->getInformacion($Id_Informacion_Sensor);

                if ($info) {
                    $request = $this->model->deleteInformacionSensor($Id_Informacion_Sensor);

                    if ($request > 0) {
                        $response = array(
                            "status" => true,
                            "msg" => "Registro eliminado correctamente",
                            "data" => $info
                        );
                    } else {
                        $response = array("status" => false, "msg" => "Error al eliminar");
                    }
                } else {
                    $response = array("status" => false, "msg" => "Registro no encontrado");
                }
                $code = 200;
            } else {
                $response = array("status" => false, "msg" => "Error en solicitud: $method. Use DELETE");
                $code = 400;
            }
        } catch (Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function informacionSensorLista()
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $info = $this->model->getAllInformacion();

                if ($info) {
                    $response = array("status" => true, "data" => $info);
                } else {
                    $response = array("status" => false, "msg" => "No se encontraron registros");
                }
                $code = 200;
            } else {
                $response = array("status" => false, "msg" => "Error en solicitud: $method. Use GET");
                $code = 400;
            }
        } catch (Exception $e) {
            echo "Error en el proceso: " . $e->getMessage();
        }

        jsonResponse($response, $code);
    }
}
?>
