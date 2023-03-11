<?php
require_once "modelo/controlador.php";
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $datos = JSON_decode(file_get_contents('php://input'));
        if($datos != null) {
            if(controlador::registro_producto($datos->codigo,$datos->nombre,$datos->valor)){
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }  
        else{
        http_response_code(405);
        }
        break;
    default:
    break;
}

?>