<?php
class Lote extends Controllers{

    public function __construct()
    {
        parent::__construct();
    }

    public function lote($idLote) 
    {
        echo "Hola desde lote, el id=".$idLote;
    }

    public function registrar()
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "POST") {

                $_POST = json_decode(file_get_contents("php://input"), true);

                if(empty($_POST['Longitud']))
                {
                    $response = array('status' => false, 'msg' => 'La longitud es obligatoria');
                    jsonResponse($response, 200);
                    die();
                }

                if(!testEntero($_POST['Localizacion']))
                {
                    $response = array('status' => false, 'msg' => 'Error en la localización');
                    jsonResponse($response, 200);
                    die();
                }

                if(empty($_POST['Nombre']))
                {
                    $response = array('status' => false, 'msg' => 'El nombre es obligatorio');
                    jsonResponse($response, 200);
                    die();
                }

                if(empty($_POST['Latitud']))
                {
                    $response = array('status' => false, 'msg' => 'La latitud es obligatoria');
                    jsonResponse($response, 200);
                    die();
                }

                if(empty($_POST['Area']))
                {
                    $response = array('status' => false, 'msg' => 'El área es obligatoria');
                    jsonResponse($response, 200);
                    die();
                }

                $decLongitud = $_POST['Longitud'];
                $intLocalizacion = $_POST['Localizacion'];
                $strNombre = $_POST['Nombre'];
                $decLatitud = $_POST['Latitud'];
                $decArea = $_POST['Area'];

                $request = $this->model->setLote(
                    $decLongitud,
                    $intLocalizacion,
                    $strNombre,
                    $decLatitud,
                    $decArea
                );

                if ($request > 0){
                    $arraLote = array(
                        'Longitud' => $decLongitud,
                        'Localizacion' => $intLocalizacion,
                        'Nombre' => $strNombre,
                        'Latitud' => $decLatitud,
                        'Area' => $decArea
                    );

                    $response = array(
                        "status" => true,
                        "msg" => "Datos registrados correctamente",
                        "data" => $arraLote
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

                $lotes = $this->model->getAllLotes();

                if ($lotes) {
                    $response = array(
                        "status" => true,
                        "data" => $lotes
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No hay lotes registrados"
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

    public function actualizar($idLote)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "PUT") {

                $_PUT = json_decode(file_get_contents("php://input"), true);

                $decLongitud = $_PUT['Longitud'];
                $intLocalizacion = $_PUT['Localizacion'];
                $strNombre = $_PUT['Nombre'];
                $decLatitud = $_PUT['Latitud'];
                $decArea = $_PUT['Area'];

                $request = $this->model->updateLote(
                    $idLote,
                    $decLongitud,
                    $intLocalizacion,
                    $strNombre,
                    $decLatitud,
                    $decArea
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

    public function eliminar($idLote)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {

                $request = $this->model->deleteLote($idLote);

                if ($request > 0){
                    $response = array(
                        "status" => true,
                        "msg" => "Lote eliminado correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al eliminar el lote"
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

    public function obtener($idLote)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $lote = $this->model->getLote($idLote);

                if ($lote){
                    $response = array(
                        "status" => true,
                        "data" => $lote
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Lote no encontrado"
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