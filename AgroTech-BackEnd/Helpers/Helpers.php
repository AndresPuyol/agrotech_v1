<?php

// Retorna la url del proyecto
function base_url()
{
    return BASE_URL;
}

function media()
{
    return BASE_URL . "Assets";
}

// Muestra información formateada
function dep($data)
{
    $format  = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}

// Elimina exceso de espacios entre palabras
function strClean($strCadena)
{
    $string = preg_replace(['/\s+/', '/^\s|\s$/'], [' ', ''], $strCadena);
    $string = trim($string); // Elimina espacios en blanco al inicio y al final
    $string = stripslashes($string); // Elimina las \ invertidas
    $string = str_ireplace("<script>", "", $string);
    $string = str_ireplace("</script>", "", $string);
    $string = str_ireplace("<script src>", "", $string);
    $string = str_ireplace("<script type=>", "", $string);
    $string = str_ireplace("SELECT * FROM", "", $string);
    $string = str_ireplace("DELETE FROM", "", $string);
    $string = str_ireplace("INSERT INTO", "", $string);
    $string = str_ireplace("SELECT COUNT(*) FROM", "", $string);
    $string = str_ireplace("DROP TABLE", "", $string);
    $string = str_ireplace("OR '1'='1", "", $string);
    $string = str_ireplace('OR "1"="1"', "", $string);
    $string = str_ireplace('OR ´1´=´1´', "", $string);
    $string = str_ireplace("is NULL; --", "", $string);
    $string = str_ireplace("LIKE '", "", $string);
    $string = str_ireplace('LIKE "', "", $string);
    $string = str_ireplace("LIKE ´", "", $string);
    $string = str_ireplace("OR 'a'='a", "", $string);
    $string = str_ireplace('OR "a"="a"', "", $string);
    $string = str_ireplace("OR ´a´=´a", "", $string);
    $string = str_ireplace("--", "", $string);
    $string = str_ireplace("^", "", $string);
    $string = str_ireplace("[", "", $string);
    $string = str_ireplace("]", "", $string);
    $string = str_ireplace("==", "", $string);
    return $string;
}

// Respuesta JSON
function jsonResponse(array $arrData, int $code)
{
    if (is_array($arrData)) {
        header("HTTP/1.1 $code");
        header('Content-Type: application/json');
        echo json_encode($arrData, true);
    }
}


// Validar string
function testString(string $data)
{
 
    $re = '/[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/m';

    $re = '/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s.,;:!?()\'"-]+$/m';

    if (preg_match($re, $data)) {
        return true;
    } else {
        return false;
    }
}

// Validar entero
function testEntero($numero)
{
    $re = '/[0-9]+$/m';
    if (preg_match($re, $numero)) {
        return true;
    } else {
        return false;
    }
}

// Validar email
function testEmail(string $email)
{
    $re = '/[a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[a-zA-Z0-9-]+(\.[a-zA-Z0-9-]+)*(\.[a-zA-Z]{2,3})$/m';
    if (preg_match($re, $email)) {
        return true;
    } else {
        return false;
    }
}

// Validar si un campo está vacío
function isEmpty($data)
{
    return empty(trim($data));
}

// Validar si un campo es numérico
function isNumeric($data)
{
    return is_numeric($data);
}

// Validar longitud de un string
function validateLength($data, $min, $max)
{
    $length = strlen($data);
    return ($length >= $min && $length <= $max);
}
// Validar seguridad de la contraseña
function validatePassword(string $password)
{
    $re = '/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
    return preg_match($re, $password);
}


// Validar el formato de una fecha (YYYY-MM-DD HH:mm:ss)
function testFecha($fecha)
{
    $formato = 'Y-m-d H:i:s';
    $d = DateTime::createFromFormat($formato, $fecha);
    return $d && $d->format($formato) === $fecha;
}


function validateDate($date, $format = 'Y-m-d')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) === $date;
}

function verifyUserCredentials(string $correo, string $password)
{
    $userModel = new UsuariosModel(); 
    $usuario = $userModel->obtenerPorCorreo($correo); 
    if (!$usuario) {
        return ["status" => false, "msg" => "Usuario no encontrado"];
    }

    if (!password_verify($password, $usuario['Password_Hash'])) {
        return ["status" => false, "msg" => "Contraseña incorrecta"];
    }

    return [
        "status" => true,
        "msg" => "Credenciales válidas",
        "usuario" => [
            "PK_identificacion" => $usuario['PK_identificacion'],
            "nombre" => $usuario['nombre'],
            "apellidos" => $usuario['apellidos'],
            "telefono" => $usuario['telefono'],
            "correo" => $usuario['correo'],
            "FK_id_tipo_usuario" => $usuario['FK_id_tipo_usuario']
        ]
    ];
}
?>

