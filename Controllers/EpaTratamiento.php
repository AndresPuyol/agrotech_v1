<?php
class EpaTratamiento extends Controllers
{
    public function registrar()
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "POST") {

                $_POST = json_decode(file_get_contents("php://input"), true);

                if (!isset($_POST['Id_Tratamiento']) || !is_numeric($_POST['Id_Tratamiento'])) {
                    $response = array('status' => false, 'msg' => 'El Id_Tratamiento debe ser numérico');
                    jsonResponse($response, 200);
                    die();
                }

                if (!isset($_POST['Id_Epa']) || !is_numeric($_POST['Id_Epa'])) {
                    $response = array('status' => false, 'msg' => 'El Id_Epa debe ser numérico');
                    jsonResponse($response, 200);
                    die();
                }

                $Id_Tratamiento = intval($_POST['Id_Tratamiento']);
                $Id_Epa = intval($_POST['Id_Epa']);

                $request = $this->model->setEpaTratamiento($Id_Tratamiento, $Id_Epa);

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "EpaTratamiento registrado correctamente",
                        "data" => array(
                            "Id_Tratamiento" => $Id_Tratamiento,
                            "Id_Epa" => $Id_Epa
                        )
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al registrar EpaTratamiento, ya está registrado"
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
            $response = array("status" => false, "msg" => "Error en el proceso: " . $e->getMessage());
            $code = 500;
        }

        jsonResponse($response, $code);
    }

    public function obtenertodo($Id_EpaTratamiento)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $epaTratamiento = $this->model->getEpaTratamiento($Id_EpaTratamiento);

                if ($epaTratamiento) {
                    $response = array(
                        "status" => true,
                        "data" => $epaTratamiento
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No se encontraron registros del EpaTratamiento con id: " . $Id_EpaTratamiento
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
            $response = array("status" => false, "msg" => "Error en el proceso: " . $e->getMessage());
            $code = 500;
        }

        jsonResponse($response, $code);
    }

    public function eliminar($Id_EpaTratamiento)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {

                $epaTratamiento = $this->model->getEpaTratamiento($Id_EpaTratamiento);

                if ($epaTratamiento) {
                    $request = $this->model->deleteEpaTratamiento($Id_EpaTratamiento);

                    if ($request > 0) {
                        $response = array(
                            "status" => true,
                            "msg" => "EpaTratamiento eliminado correctamente",
                            "data" => $epaTratamiento
                        );
                    } else {
                        $response = array(
                            "status" => false,
                            "msg" => "Error al eliminar EpaTratamiento"
                        );
                    }
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "EpaTratamiento no encontrado"
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
            $response = array("status" => false, "msg" => "Error en el proceso: " . $e->getMessage());
            $code = 500;
        }

        jsonResponse($response, $code);
    }
}
?>
