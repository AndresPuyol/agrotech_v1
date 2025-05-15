<?php
    class Materiales extends Controllers
    {

        public function materiales($IdMaterial)
        {
            echo "hola desde materiales" . $IdMaterial;
        }

        public function registrarMaterial()
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

                    if (!testEntero($_POST['Precio'])) {
                        $response = array('status' => false, 'msg' => 'El precio debe ser un numero');
                        jsonResponse($response, 200);
                        die();
                    }

                    if (!testString($_POST['Descripcion'])) {
                        $response = array('status' => false, 'msg' => 'La descripcion debe ser un texto');
                        jsonResponse($response, 200);
                        die();
                    }

                    if (!testEntero($_POST['Cantidad'])) {
                        $response = array('status' => false, 'msg' => 'La cantidad debe ser un numero');
                        jsonResponse($response, 200);
                        die();
                    }

                    $Nombre = ucwords(strtolower($_POST['Nombre']));
                    $Precio = $_POST['Precio'];
                    $Descripcion = ucwords(strtolower($_POST['Descripcion']));
                    $Tipo_Material = isset($_POST['TipoM']) ? $_POST['TipoM'] : null;
                    $Tipo_Medida_Material = isset($_POST['TipoMM']) ? $_POST['TipoMM'] : null;
                    $Cantidad = $_POST['Cantidad'];

                    $request = $this->model->setMaterial(
                        $Nombre,
                        $Precio,
                        $Descripcion,
                        $Tipo_Material,
                        $Tipo_Medida_Material,
                        $Cantidad
                    );

                    if ($request > 0) {
                        $arraMaterial = array(
                            'Nombre' => $Nombre,
                            'Precio' => $Precio,
                            'Descripcion' => $Descripcion,
                            'tipo_Material' => $Tipo_Material,
                            'Tipo_Medida_Material' => $Tipo_Medida_Material,
                            'Cantidad' => $Cantidad
                        );
                        $response = array(
                            "status" => true,
                            "msg" => "Datos del material registrados correctamente",
                            "data" => $arraMaterial
                        );

                    } else {
                        $response = array(
                            "status" => false,
                            "msg" => "Error al registrar material, ya esta registrado"
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

        public function obtenerMaterial($Id_Material) {
            $response = [];

            try {
                $method = $_SERVER['REQUEST_METHOD'];
                if ($method == "GET") {

                    $material = $this->model->getMaterial($Id_Material);

                    if($material) {
                        $response = array(
                            "status" => true,
                            "data" => $material
                        );
                    }else{
                        $response = array(
                            "status" => false,
                            "msg" => "No se encontraron registros del material con id: " . $Id_Material
                        );
                    }
                    $code = 200;
                }else{
                    $response = array(
                        "status" => false,
                        "msg" => "Error en la solicitud: " . $method . " cambie a GET"
                    );
                    $code = 400;
                }
            }catch (Exception $e) {
                echo "error en el proceso" . $e->getMessage();
            }
            jsonResponse($response, $code);
        }


        public function actualizarMaterial($Id_Material)
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

                    if (!isset($_PUT['Precio']) || !testEntero($_PUT['Precio'])) {
                        $response = array('status' => false, 'msg' => 'El precio debe ser un numero');
                        jsonResponse($response, 200);
                        die();
                    }

                    if (!isset($_PUT['Descripcion']) || !testString($_PUT['Descripcion'])) {
                        $response = array('status' => false, 'msg' => 'La descripcion debe ser un texto');
                        jsonResponse($response, 200);
                        die();
                    }

                    if (!isset($_PUT['Cantidad']) || !testEntero($_PUT['Cantidad'])) {
                        $response = array('status' => false, 'msg' => 'La cantidad debe ser un numero');
                        jsonResponse($response, 200);
                        die();
                    }

                    $Nombre = ucwords(strtolower($_PUT['Nombre']));
                    $Precio = $_PUT['Precio'];
                    $Descripcion = ucwords(strtolower($_PUT['Descripcion']));
                    $Tipo_Material = isset($_PUT['TipoM']) ? $_PUT['TipoM'] : null;
                    $Tipo_Medida_Material = isset($_PUT['TipoMM']) ? $_PUT['TipoMM'] : null;
                    $Cantidad = $_PUT['Cantidad'];

                    $request = $this->model->updateMaterial(
                        $Id_Material,
                        $Nombre,
                        $Precio,
                        $Descripcion,
                        $Tipo_Material,
                        $Tipo_Medida_Material,
                        $Cantidad
                    );

                    if ($request > 0) {
                        $response = array(
                            "status" => true,
                            "msg" => "Datos del material actualizados correctamente"
                        );

                    } else {
                        $response = array(
                            "status" => false,
                            "msg" => "Error al actualizar material, Los datos a actualizar ya estan actualizados"
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


        public function eliminarMaterial($Id_Material)
        {
            $response = [];

            try {
                $method = $_SERVER['REQUEST_METHOD'];
                if ($method == "DELETE") {

                    
                    $material = $this->model->getMaterial($Id_Material);

                    if ($material) {
                        $request = $this->model->deleteMaterial($Id_Material);

                        if ($request > 0) {
                            $response = array(
                                "status" => true,
                                "msg" => "Material eliminado correctamente",
                                "data" => $material
                            );
                        } else {
                            $response = array(
                                "status" => false,
                                "msg" => "Error al eliminar material"
                            );
                        }
                    } else {
                        $response = array(
                            "status" => false,
                            "msg" => "Material no encontrado"
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

        public function InformacionMaterial()
        {
            $response = [];

            try {
                $method = $_SERVER['REQUEST_METHOD'];
                if ($method == "GET") {

                    $materiales = $this->model->GetAllMaterial();

                    if($materiales) {
                        $response = array(
                            "status" => true,
                            "data" => $materiales
                        );
                    }else{
                        $response = array(
                            "status" => false,
                            "msg" => "No se encontraron registros de materiales"
                        );
                    }
                    $code = 200;
                }else{
                    $response = array(
                        "status" => false,
                        "msg" => "Error en la solicitud: " . $method . " cambie a GET"
                    );
                    $code = 400;
                }
            }catch (Exception $e) {
                echo "error en el proceso" . $e->getMessage();
            }
            jsonResponse($response, $code);
            
        }
        









    }

?>