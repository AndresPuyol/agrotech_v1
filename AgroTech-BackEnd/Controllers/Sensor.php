<?php
class Sensor extends Controllers{

    public function __construct()
    {
        parent::__construct();
    }

    public function sensor($idSensor) 
    {
        echo "Hola desde sensor, el id=".$idSensor;
    }

    public function registrar()
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "POST") {

                $_POST = json_decode(file_get_contents("php://input"), true);

                if(empty($_POST['Nombre']))
                {
                    $response = array('status' => false, 'msg' => 'El nombre es obligatorio');
                    jsonResponse($response, 200);
                    die();
                }

                if(!testEntero($_POST['Id_Surco']))
                {
                    $response = array('status' => false, 'msg' => 'Error en el id del surco');
                    jsonResponse($response, 200);
                    die();
                }

                if(!testEntero($_POST['Id_Tipo_Sensor']))
                {
                    $response = array('status' => false, 'msg' => 'Error en el id del tipo de sensor');
                    jsonResponse($response, 200);
                    die();
                }

                $strNombre = $_POST['Nombre'];
                $intIdSurco = $_POST['Id_Surco'];
                $intIdTipoSensor = $_POST['Id_Tipo_Sensor'];

                $request = $this->model->setSensor(
                    $strNombre,
                    $intIdSurco,
                    $intIdTipoSensor
                );

                if ($request > 0){
                    $arraSensor = array(
                        'Nombre' => $strNombre,
                        'Id_Surco' => $intIdSurco,
                        'Id_Tipo_Sensor' => $intIdTipoSensor
                    );

                    $response = array(
                        "status" => true,
                        "msg" => "Datos registrados correctamente",
                        "data" => $arraSensor
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al registrar los datos",
                    );
                }
                $code = 200;

            } else {
                $response = array(
                    "status" => false,
                    "msg" => "Los datos no se registraron, error en la solicitud: " . $method . " cambie a POST"
                );

                $code = 400;
            }

        } catch (\Exception $e) {
            echo "Error en el proceso:".$e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function listar()
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $sensores = $this->model->getAllSensores();

                if ($sensores) {
                    $response = array(
                        "status" => true,
                        "data" => $sensores
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No hay sensores registrados"
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

        } catch (\Exception $e) {
            echo "Error en el proceso:" . $e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function actualizar($idSensor)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "PUT") {

                $_PUT = json_decode(file_get_contents("php://input"), true);

                $strNombre = $_PUT['Nombre'];
                $intIdSurco = $_PUT['Id_Surco'];
                $intIdTipoSensor = $_PUT['Id_Tipo_Sensor'];

                $request = $this->model->updateSensor(
                    $idSensor,
                    $strNombre,
                    $intIdSurco,
                    $intIdTipoSensor
                );

                if ($request > 0){
                    $response = array(
                        "status" => true,
                        "msg" => "Datos actualizados correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al actualizar los datos"
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

        } catch (\Exception $e) {
            echo "Error en el proceso:".$e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function eliminar($idSensor)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {

                $request = $this->model->deleteSensor($idSensor);

                if ($request > 0){
                    $response = array(
                        "status" => true,
                        "msg" => "Sensor eliminado correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al eliminar el sensor"
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

        } catch (\Exception $e) {
            echo "Error en el proceso:".$e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function obtener($idSensor)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $sensor = $this->model->getSensor($idSensor);

                if ($sensor){
                    $response = array(
                        "status" => true,
                        "data" => $sensor
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Sensor no encontrado"
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

        } catch (\Exception $e) {
            echo "Error en el proceso:".$e->getMessage();
        }

        jsonResponse($response, $code);
    }
}
?>