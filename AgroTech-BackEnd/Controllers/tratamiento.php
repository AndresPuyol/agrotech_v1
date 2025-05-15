<?php
class tratamiento extends Controllers {
    public function __construct() {
        parent::__construct();
    }

    public function registrar() {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "POST") {
                $_POST = json_decode(file_get_contents("php://input"), true);
                $request = $this->model->setTratamiento(
                    $_POST['descripcion'], 
                    $_POST['fecha_inicio'], 
                    $_POST['fecha_final'], 
                    $_POST['Tipo_Tratamiento']
                );

                if ($request == -1) {
                    jsonResponse(['status' => false, 'msg' => 'Error: La fecha de inicio no puede ser mayor a la fecha final'], 400);
               return;
                }

                jsonResponse(['status' => $request > 0, 'msg' => $request > 0 ? 'Registro exitoso' : 'Error en el registro'], 200);
            }
        } catch (Exception $e) {
            jsonResponse(['status' => false, 'msg' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function actualizar($id) {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "PUT") {
                $_PUT = json_decode(file_get_contents("php://input"), true);
                $request = $this->model->updateTratamiento(
                    $id, 
                    $_PUT['descripcion'],
                    $_PUT['fecha_final'], 
                    $_PUT['fecha_inicio'], 
                    $_PUT['Tipo_Tratamiento']
                );

                if ($request == -1) {
                    jsonResponse(['status' => false, 'msg' => 'Error: La fecha de inicio no puede ser mayor a la fecha final'], 400);
                    return;
                }

                if ($request == 0) {
                    jsonResponse(['status' => false, 'msg' => 'Error: Tratamiento no encontrado'], 404);
                    return;
                }

                jsonResponse(['status' => true, 'msg' => 'Actualización exitosa'], 200);
            }
        } catch (Exception $e) {
            jsonResponse(['status' => false, 'msg' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function eliminar($id) {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "DELETE") {
                $request = $this->model->deleteTratamiento($id);

                if ($request == 0) {
                    jsonResponse(['status' => false, 'msg' => 'Error: Tratamiento no encontrado'], 404);
                    return;
                }

                jsonResponse(['status' => true, 'msg' => 'Eliminación exitosa'], 200);
            }
        } catch (Exception $e) {
            jsonResponse(['status' => false, 'msg' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function obtener($id) {
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {
                $data = $this->model->getTratamiento($id);
                
                if (!$data) {
                    jsonResponse(['status' => false, 'msg' => 'Error: Tratamiento no encontrado'], 404);
                    return;
                }

                jsonResponse(['status' => true, 'data' => $data], 200);
            }
        } catch (Exception $e) {
            jsonResponse(['status' => false, 'msg' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
?>
