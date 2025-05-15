<?php
class ActividadesMaterial extends Controllers
{
    public function registrar()
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "POST") {
                $_POST = json_decode(file_get_contents("php://input"), true);

                $Cantidad_Uso = $_POST['Cantidad_Uso'];
                $Id_Actividad = $_POST['Id_Actividad'];
                $Id_Material = $_POST['Id_Material'];

                $request = $this->model->setActividadMaterial($Id_Actividad, $Id_Material, $Cantidad_Uso);

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "Actividad-Material registrada correctamente",
                        "data" => array(
                            'Cantidad_Uso' => $Cantidad_Uso,
                            'Id_Actividad' => $Id_Actividad,
                            'Id_Material' => $Id_Material
                        )
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al registrar la actividad-material"
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
        } catch (Exception $e) {
            $response = array(
                "status" => false,
                "msg" => "Error en el proceso: " . $e->getMessage()
            );
            $code = 500;
        }

        jsonResponse($response, $code);
    }

    public function obtener($Id_Actividad_Material)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $actividadMaterial = $this->model->getActividadMaterial($Id_Actividad_Material);

                if ($actividadMaterial) {
                    $response = array(
                        "status" => true,
                        "data" => $actividadMaterial
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No se encontraron registros de la actividad-material con id: " . $Id_Actividad_Material
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
            echo "error en el proceso" . $e->getMessage();
        }
        jsonResponse($response, $code);
    }

    public function actualizar($Id_Actividad_Material)
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "PUT") {

                $_PUT = json_decode(file_get_contents("php://input"), true);

                if (!isset($_PUT['Cantidad_Uso']) || !is_numeric($_PUT['Cantidad_Uso'])) {
                    $response = array('status' => false, 'msg' => 'La cantidad de uso debe ser un número');
                    jsonResponse($response, 200);
                    die();
                }

                if (!isset($_PUT['Id_Actividad']) || !is_numeric($_PUT['Id_Actividad'])) {
                    $response = array('status' => false, 'msg' => 'El id de la actividad debe ser un número');
                    jsonResponse($response, 200);
                    die();
                }

                if (!isset($_PUT['Id_Material']) || !is_numeric($_PUT['Id_Material'])) {
                    $response = array('status' => false, 'msg' => 'El id del material debe ser un número');
                    jsonResponse($response, 200);
                    die();
                }

                $Cantidad_Uso = $_PUT['Cantidad_Uso'];
                $Id_Actividad = $_PUT['Id_Actividad'];
                $Id_Material = $_PUT['Id_Material'];

                $request = $this->model->updateActividadMaterial(
                    $Id_Actividad_Material,
                    $Cantidad_Uso,
                    $Id_Actividad,
                    $Id_Material
                );

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "Datos de la actividad-material actualizados correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al actualizar la actividad-material"
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
            echo "error en el proceso" . $e->getMessage();
        }
        jsonResponse($response, $code);
    }

    public function eliminar($Id_Actividad_Material)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {

                $actividadMaterial = $this->model->getActividadMaterial($Id_Actividad_Material);

                if ($actividadMaterial) {
                    $request = $this->model->deleteActividadMaterial($Id_Actividad_Material);

                    if ($request > 0) {
                        $response = array(
                            "status" => true,
                            "msg" => "Actividad-Material eliminado correctamente",
                            "data" => $actividadMaterial
                        );
                    } else {
                        $response = array(
                            "status" => false,
                            "msg" => "Error al eliminar la actividad-material"
                        );
                    }
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Actividad-Material no encontrado"
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
            echo "error en el proceso" . $e->getMessage();
        }
        jsonResponse($response, $code);
    }

    public function InformacionMatAct()
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $actividadMateriales = $this->model->getAllActividadMaterial();

                if ($actividadMateriales) {
                    $response = array(
                        "status" => true,
                        "data" => $actividadMateriales
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No se encontraron registros de actividades-materiales"
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
            echo "error en el proceso" . $e->getMessage();
        }
        jsonResponse($response, $code);
    }
}
