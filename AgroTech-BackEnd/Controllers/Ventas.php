<?php
class Ventas extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    // Registrar una nueva venta
public function registrar()
{
    $response = [];
    try {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method == "POST") {
            $_POST = json_decode(file_get_contents("php://input"), true);

            // Validaciones
            $Fecha = strClean($_POST['Fecha']);
            $Precio_Unitario = strClean($_POST['Precio_Unitario']);
            $Cantidad_Venta = strClean($_POST['Cantidad_Venta']);
            $Id_Produccion = strClean($_POST['Id_Produccion']);

            if (!testFecha($Fecha)) {
                jsonResponse(['status' => false, 'msg' => 'La fecha debe estar en formato YYYY-MM-DD HH:mm:ss'], 400);
                die();
            }
            if (!testEntero($Precio_Unitario) || $Precio_Unitario <= 0) {
                jsonResponse(['status' => false, 'msg' => 'El precio unitario debe ser un número entero positivo'], 400);
                die();
            }
            if (!testEntero($Cantidad_Venta) || $Cantidad_Venta <= 0) {
                jsonResponse(['status' => false, 'msg' => 'La cantidad de venta debe ser un número entero positivo'], 400);
                die();
            }
            if (!testEntero($Id_Produccion)) {
                jsonResponse(['status' => false, 'msg' => 'El ID de producción debe ser un número entero válido'], 400);
                die();
            }

            // Calcular Valor Total de Venta
            $Valor_Total_Venta = $Cantidad_Venta * $Precio_Unitario;

            // Verificar si la producción existe
            if (!$this->model->verificarProduccion($Id_Produccion)) {
                jsonResponse(['status' => false, 'msg' => 'La producción especificada no existe'], 400);
                die();
            }

            // Registrar la venta
            $request = $this->model->crearVenta($Fecha, $Precio_Unitario, $Cantidad_Venta, $Valor_Total_Venta, $Id_Produccion);

            if ($request > 0) {
                jsonResponse(['status' => true, 'msg' => 'Venta registrada correctamente', 'Id_Venta' => $request], 200);
            } else {
                jsonResponse(['status' => false, 'msg' => 'Error al registrar la venta'], 400);
            }
        } else {
            jsonResponse(['status' => false, 'msg' => 'Método no permitido. Usa POST'], 405);
        }
    } catch (\Exception $e) {
        jsonResponse(['status' => false, 'msg' => 'Error en el proceso: ' . $e->getMessage()], 500);
    }
}

    // Obtener todas las ventas
    public function obtenerVentas()
    {
        $response = [];
        try {
            $method = $_SERVER['REQUEST_METHOD'];
            if ($method == "GET") {
                $ventas = $this->model->obtenerVentas();
                if ($ventas) {
                    jsonResponse(['status' => true, 'data' => $ventas], 200);
                } else {
                    jsonResponse(['status' => false, 'msg' => 'No se encontraron ventas'], 404);
                }
            } else {
                jsonResponse(['status' => false, 'msg' => 'Método no permitido. Usa GET'], 405);
            }
        } catch (\Exception $e) {
            jsonResponse(['status' => false, 'msg' => 'Error en el proceso: ' . $e->getMessage()], 500);
        }
    }

    // Obtener una venta por ID
    public function obtener($idVenta)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == "GET") {
                $venta = $this->model->obtenerVenta($idVenta);
                if ($venta) {
                    jsonResponse(['status' => true, 'data' => $venta], 200);
                } else {
                    jsonResponse(['status' => false, 'msg' => 'Venta no encontrada'], 404);
                }
            } else {
                jsonResponse(['status' => false, 'msg' => 'Método no permitido. Usa GET'], 405);
            }
        } catch (\Exception $e) {
            jsonResponse(['status' => false, 'msg' => 'Error en el proceso: ' . $e->getMessage()], 500);
        }
    }

    // Actualizar una venta
    public function actualizar($idVenta)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == "PUT") {
                $_PUT = json_decode(file_get_contents("php://input"), true);

                // Validaciones
                $Fecha = strClean($_PUT['Fecha']);
                $Precio_Unitario = strClean($_PUT['Precio_Unitario']);
                $Cantidad_Venta = strClean($_PUT['Cantidad_Venta']);
                $Valor_Total_Venta = strClean($_PUT['Valor_Total_Venta']);
                $Id_Produccion = strClean($_PUT['Id_Produccion']);

                if (!testFecha($Fecha)) {
                    jsonResponse(['status' => false, 'msg' => 'La fecha debe estar en formato válido'], 400);
                    die();
                }
                if (!testEntero($Precio_Unitario) || $Precio_Unitario <= 0) {
                    jsonResponse(['status' => false, 'msg' => 'El precio unitario debe ser un número entero positivo'], 400);
                    die();
                }
                if (!testEntero($Cantidad_Venta) || $Cantidad_Venta <= 0) {
                    jsonResponse(['status' => false, 'msg' => 'La cantidad de venta debe ser un número entero positivo'], 400);
                    die();
                }
                if (!testEntero($Valor_Total_Venta) || $Valor_Total_Venta <= 0) {
                    jsonResponse(['status' => false, 'msg' => 'El valor total de la venta debe ser un número entero positivo'], 400);
                    die();
                }
                if (!testEntero($Id_Produccion)) {
                    jsonResponse(['status' => false, 'msg' => 'El ID de producción debe ser válido'], 400);
                    die();
                }

                // Actualizar la venta
                $request = $this->model->actualizarVenta($idVenta, $Fecha, $Precio_Unitario, $Cantidad_Venta, $Valor_Total_Venta, $Id_Produccion);
                if ($request) {
                    jsonResponse(['status' => true, 'msg' => 'Venta actualizada correctamente'], 200);
                } else {
                    jsonResponse(['status' => false, 'msg' => 'Error al actualizar la venta'], 400);
                }
            } else {
                jsonResponse(['status' => false, 'msg' => 'Método no permitido. Usa PUT'], 405);
            }
        } catch (\Exception $e) {
            jsonResponse(['status' => false, 'msg' => 'Error en el proceso: ' . $e->getMessage()], 500);
        }
    }

    // Eliminar una venta
    public function eliminar($idVenta)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == "DELETE") {
                $request = $this->model->eliminarVenta($idVenta);
                if ($request) {
                    jsonResponse(['status' => true, 'msg' => 'Venta eliminada correctamente'], 200);
                } else {
                    jsonResponse(['status' => false, 'msg' => 'Error al eliminar la venta'], 400);
                }
            } else {
                jsonResponse(['status' => false, 'msg' => 'Método no permitido. Usa DELETE'], 405);
            }
        } catch (\Exception $e) {
            jsonResponse(['status' => false, 'msg' => 'Error en el proceso: ' . $e->getMessage()], 500);
        }
    }
}
?>
