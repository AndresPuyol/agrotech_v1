<?php
class TipoSensor extends Controllers{

    public function __construct()
    {
        parent::__construct();
    }

    public function tipoSensor($idTipoSensor) 
    {
        echo "Hola desde tipo_sensor, el id=".$idTipoSensor;
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

                $strNombre = $_POST['Nombre'];

                $request = $this->model->setTipoSensor(
                    $strNombre
                );

                if ($request > 0){
                    $arraTipoSensor = array(
                        'Nombre' => $strNombre
                    );

                    $response = array(
                        "status" => true,
                        "msg" => "Datos registrados correctamente",
                        "data" => $arraTipoSensor
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

                $tiposSensores = $this->model->getAllTiposSensores();

                if ($tiposSensores) {
                    $response = array(
                        "status" => true,
                        "data" => $tiposSensores
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No hay tipos de sensores registrados"
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

    public function actualizar($idTipoSensor)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "PUT") {

                $_PUT = json_decode(file_get_contents("php://input"), true);

                $strNombre = $_PUT['Nombre'];

                $request = $this->model->updateTipoSensor(
                    $idTipoSensor,
                    $strNombre
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

    public function eliminar($idTipoSensor)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {

                $request = $this->model->deleteTipoSensor($idTipoSensor);

                if ($request > 0){
                    $response = array(
                        "status" => true,
                        "msg" => "Tipo de sensor eliminado correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al eliminar el tipo de sensor"
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

    public function obtener($idTipoSensor)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $tipoSensor = $this->model->getTipoSensor($idTipoSensor);

                if ($tipoSensor){
                    $response = array(
                        "status" => true,
                        "data" => $tipoSensor
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Tipo de sensor no encontrado"
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