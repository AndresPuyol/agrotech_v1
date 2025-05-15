<?php
class Surco extends Controllers{

    public function __construct()
    {
        parent::__construct();
    }

    public function surco($idSurco) 
    {
        echo "hola desde surco el id=".$idSurco;
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

                if(empty($_POST['Descripcion']))
                {
                    $response = array('status' => false, 'msg' => 'La descripcion es obligatoria');
                    jsonResponse($response, 200);
                    die();
                }

                if(!testEntero($_POST['Id_Lote']))
                {
                    $response = array('status' => false, 'msg' => 'Error en el id del lote');
                    jsonResponse($response, 200);
                    die();
                }

                if(!testEntero($_POST['Id_Cultivo']))
                {
                    $response = array('status' => false, 'msg' => 'Error en el id del cultivo');
                    jsonResponse($response, 200);
                    die();
                }

                $strNombre = $_POST['Nombre'];
                $strDescripcion = $_POST['Descripcion'];
                $intIdLote = $_POST['Id_Lote'];
                $intIdCultivo = $_POST['Id_Cultivo'];

                $request = $this->model->setSurco(
                    $strNombre,
                    $strDescripcion,
                    $intIdLote,
                    $intIdCultivo
                );

                if ($request > 0){
                    $arraSurco = array(
                        'Nombre' => $strNombre,
                        'Descripcion' => $strDescripcion,
                        'Id_Lote' => $intIdLote,
                        'Id_Cultivo' => $intIdCultivo
                    );

                    $response = array(
                        "status" => true,
                        "msg" => "Datos registrados correctamente",
                        "data" => $arraSurco
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
            echo "error en el proceso:".$e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function listar()
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $surcos = $this->model->getAllSurcos();

                if ($surcos) {
                    $response = array(
                        "status" => true,
                        "data" => $surcos
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No hay surcos registrados"
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
            echo "error en el proceso:" . $e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function actualizar($idSurco)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "PUT") {

                $_PUT = json_decode(file_get_contents("php://input"), true);

                $strNombre = $_PUT['Nombre'];
                $strDescripcion = $_PUT['Descripcion'];
                $intIdLote = $_PUT['Id_Lote'];
                $intIdCultivo = $_PUT['Id_Cultivo'];

                $request = $this->model->updateSurco(
                    $idSurco,
                    $strNombre,
                    $strDescripcion,
                    $intIdLote,
                    $intIdCultivo
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
            echo "error en el proceso:".$e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function eliminar($idSurco)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {

                $request = $this->model->deleteSurco($idSurco);

                if ($request > 0){
                    $response = array(
                        "status" => true,
                        "msg" => "Surco eliminado correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al eliminar el surco"
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
            echo "error en el proceso:".$e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function obtener($idSurco)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $surco = $this->model->getSurco($idSurco);

                if ($surco){
                    $response = array(
                        "status" => true,
                        "data" => $surco
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Surco no encontrado"
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
            echo "error en el proceso:".$e->getMessage();
        }

        jsonResponse($response, $code);
    }
}
?>