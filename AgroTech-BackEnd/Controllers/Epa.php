<?php
class Epa extends Controllers
{
    public function epa($IdEpa)
    {
        echo "hola desde epa " . $IdEpa;
    }

    public function registrarEpa()
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

                if (!testString($_POST['Descripcion'])) {
                    $response = array('status' => false, 'msg' => 'La descripcion debe ser un texto');
                    jsonResponse($response, 200);
                    die();
                }

                if (!validateDate($_POST['Fecha_Encuentro'])) {
                    $response = array('status' => false, 'msg' => 'La fecha de encuentro no es valida');
                    jsonResponse($response, 200);
                    die();
                }

                $Fecha_Encuentro = $_POST['Fecha_Encuentro'];
                $Nombre = ucwords(strtolower($_POST['Nombre']));
                $Descripcion = ucwords(strtolower($_POST['Descripcion']));
                $Tipo_Enfermedad = isset($_POST['Tipo_Enfermedad']) ? $_POST['Tipo_Enfermedad'] : null;
                $Deficiencias = isset($_POST['Deficiencias']) ? $_POST['Deficiencias'] : null;
                $Img = isset($_POST['Img']) ? $_POST['Img'] : null;
                $Complicaciones = isset($_POST['Complicaciones']) ? $_POST['Complicaciones'] : null;

                $request = $this->model->setEpa(
                    $Fecha_Encuentro,
                    $Nombre,
                    $Descripcion,
                    $Tipo_Enfermedad,
                    $Deficiencias,
                    $Img,
                    $Complicaciones
                );

                if ($request > 0) {
                    $arrayEpa = array(
                        'Fecha_Encuentro' => $Fecha_Encuentro,
                        'Nombre' => $Nombre,
                        'Descripcion' => $Descripcion,
                        'Tipo_Enfermedad' => $Tipo_Enfermedad,
                        'Deficiencias' => $Deficiencias,
                        'Img' => $Img,
                        'Complicaciones' => $Complicaciones
                    );
                    $response = array(
                        "status" => true,
                        "msg" => "Datos del epa registrados correctamente",
                        "data" => $arrayEpa
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al registrar epa, ya esta registrado"
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
            echo "error en el proceso" . $e->getMessage();
        }

        jsonResponse($response, $code);
    }

    public function obtenerEpa($Id_Epa)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $epa = $this->model->getEpa($Id_Epa);

                if ($epa) {
                    $response = array(
                        "status" => true,
                        "data" => $epa
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No se encontraron registros del epa con id: " . $Id_Epa
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

    public function actualizarEpa($Id_Epa)
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "PUT") {

                $_PUT = json_decode(file_get_contents("php://input"), true);

                if (!isset($_PUT['Nombre']) || !testString($_PUT['Nombre'])) {
                    $response = array('status' => false, 'msg' => 'El nombre debe ser un texto');
                    jsonResponse($response, 200);
                    die();
                }

                if (!isset($_PUT['Descripcion']) || !testString($_PUT['Descripcion'])) {
                    $response = array('status' => false, 'msg' => 'La descripcion debe ser un texto');
                    jsonResponse($response, 200);
                    die();
                }

                $Fecha_Encuentro = $_PUT['Fecha_Encuentro'];
                $Nombre = ucwords(strtolower($_PUT['Nombre']));
                $Descripcion = ucwords(strtolower($_PUT['Descripcion']));
                $Tipo_Enfermedad = isset($_PUT['Tipo_Enfermedad']) ? $_PUT['Tipo_Enfermedad'] : null;
                $Deficiencias = isset($_PUT['Deficiencias']) ? $_PUT['Deficiencias'] : null;
                $Img = isset($_PUT['Img']) ? $_PUT['Img'] : null;
                $Complicaciones = isset($_PUT['Complicaciones']) ? $_PUT['Complicaciones'] : null;

                $request = $this->model->updateEpa(
                    $Id_Epa,
                    $Fecha_Encuentro,
                    $Nombre,
                    $Descripcion,
                    $Tipo_Enfermedad,
                    $Deficiencias,
                    $Img,
                    $Complicaciones
                );

                if ($request > 0) {
                    $response = array(
                        "status" => true,
                        "msg" => "Datos del epa actualizados correctamente"
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Error al actualizar epa"
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

    public function eliminarEpa($Id_Epa)
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {

                $epa = $this->model->getEpa($Id_Epa);

                if ($epa) {
                    $request = $this->model->deleteEpa($Id_Epa);

                    if ($request > 0) {
                        $response = array(
                            "status" => true,
                            "msg" => "Epa eliminado correctamente",
                            "data" => $epa
                        );
                    } else {
                        $response = array(
                            "status" => false,
                            "msg" => "Error al eliminar epa"
                        );
                    }
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "Epa no encontrado"
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

    public function informacionEpa()
    {
        $response = [];

        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {

                $epas = $this->model->getAllEpa();

                if ($epas) {
                    $response = array(
                        "status" => true,
                        "data" => $epas
                    );
                } else {
                    $response = array(
                        "status" => false,
                        "msg" => "No se encontraron registros de epas"
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
