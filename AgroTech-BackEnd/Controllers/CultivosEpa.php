<?php
    class CultivosEpa extends Controllers
    {

        public function cultivoepa($Id_CultivoEpa)
        {
            echo "hola desde cultivoepa " . $Id_CultivoEpa;
        }

        public function registrarCultivoEpa()
        {
            $response = [];

            try {
                $method = $_SERVER['REQUEST_METHOD'];
                if ($method == "POST") {

                    $_POST = json_decode(file_get_contents("php://input"), true);

                    if (!isset($_POST['Id_Cultivo']) || !testEntero($_POST['Id_Cultivo'])) {
                        $response = array('status' => false, 'msg' => 'El Id_Cultivo debe ser un numero');
                        jsonResponse($response, 200);
                        die();
                    }

                    if (!isset($_POST['Id_Epa']) || !testEntero($_POST['Id_Epa'])) {
                        $response = array('status' => false, 'msg' => 'El Id_Epa debe ser un numero');
                        jsonResponse($response, 200);
                        die();
                    }

                    $Id_Cultivo = $_POST['Id_Cultivo'];
                    $Id_Epa = $_POST['Id_Epa'];

                    $request = $this->model->setCultivoEpa($Id_Cultivo, $Id_Epa);

                    if ($request > 0) {
                        $response = array(
                            "status" => true,
                            "msg" => "Datos registrados correctamente",
                            "data" => array(
                                "Id_Cultivo" => $Id_Cultivo,
                                "Id_Epa" => $Id_Epa
                            )
                        );
                    } else {
                        $response = array(
                            "status" => false,
                            "msg" => "Error al registrar, ya existe el registro"
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
                echo "error en el proceso " . $e->getMessage();
            }

            jsonResponse($response, $code);
        }

        public function 1($Id_CultivoEpa)
        {
            $response = [];

            try {
                $method = $_SERVER['REQUEST_METHOD'];
                if ($method == "GET") {

                    $cultivoepa = $this->model->getCultivoEpa($Id_CultivoEpa);

                    if ($cultivoepa) {
                        $response = array(
                            "status" => true,
                            "data" => $cultivoepa
                        );
                    } else {
                        $response = array(
                            "status" => false,
                            "msg" => "No se encontraron registros del cultivo epa con id: " . $Id_CultivoEpa
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
                echo "error en el proceso " . $e->getMessage();
            }

            jsonResponse($response, $code);
        }

        public function actualizarCultivoEpa($Id_CultivoEpa)
        {
            $response = [];

            try {
                $method = $_SERVER['REQUEST_METHOD'];
                if ($method == "PUT") {

                    $_PUT = json_decode(file_get_contents("php://input"), true);

                    if (!isset($_PUT['Id_Cultivo']) || !testEntero($_PUT['Id_Cultivo'])) {
                        $response = array('status' => false, 'msg' => 'El Id_Cultivo debe ser un numero');
                        jsonResponse($response, 200);
                        die();
                    }

                    if (!isset($_PUT['Id_Epa']) || !testEntero($_PUT['Id_Epa'])) {
                        $response = array('status' => false, 'msg' => 'El Id_Epa debe ser un numero');
                        jsonResponse($response, 200);
                        die();
                    }

                    $Id_Cultivo = $_PUT['Id_Cultivo'];
                    $Id_Epa = $_PUT['Id_Epa'];

                    $request = $this->model->updateCultivoEpa($Id_CultivoEpa, $Id_Cultivo, $Id_Epa);

                    if ($request > 0) {
                        $response = array(
                            "status" => true,
                            "msg" => "Datos actualizados correctamente"
                        );
                    } else {
                        $response = array(
                            "status" => false,
                            "msg" => "Error al actualizar, no se realizaron cambios"
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
                echo "error en el proceso " . $e->getMessage();
            }

            jsonResponse($response, $code);
        }

        public function eliminarCultivoEpa($Id_CultivoEpa)
        {
            $response = [];

            try {
                $method = $_SERVER['REQUEST_METHOD'];
                if ($method == "DELETE") {

                    $cultivoepa = $this->model->getCultivoEpa($Id_CultivoEpa);

                    if ($cultivoepa) {
                        $request = $this->model->deleteCultivoEpa($Id_CultivoEpa);

                        if ($request > 0) {
                            $response = array(
                                "status" => true,
                                "msg" => "Registro eliminado correctamente",
                                "data" => $cultivoepa
                            );
                        } else {
                            $response = array(
                                "status" => false,
                                "msg" => "Error al eliminar"
                            );
                        }
                    } else {
                        $response = array(
                            "status" => false,
                            "msg" => "Registro no encontrado"
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
                echo "error en el proceso " . $e->getMessage();
            }

            jsonResponse($response, $code);
        }

        public function informacionCultivoEpa()
        {
            $response = [];

            try {
                $method = $_SERVER['REQUEST_METHOD'];
                if ($method == "GET") {

                    $cultivosepa = $this->model->getAllCultivoEpa();

                    if ($cultivosepa) {
                        $response = array(
                            "status" => true,
                            "data" => $cultivosepa
                        );
                    } else {
                        $response = array(
                            "status" => false,
                            "msg" => "No se encontraron registros"
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
                echo "error en el proceso " . $e->getMessage();
            }

            jsonResponse($response, $code);
        }

    }
?>
