<?php
require_once "modelo/controlador.php";
switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $datos = JSON_decode(file_get_contents('php://input'));
        if($datos != null) {
            if(controlador::compra($datos->cedula,$datos->codigo,$datos->fecha)){
                http_response_code(200);
            } else {
                http_response_code(400);
            }
        }  
        else{
        http_response_code(405);
        }
        break;
    case 'GET':
        if(isset($_GET['id'])){
            echo json_encode(controlador::recibo($_GET['id']));
        }
        break;
    default:
    break;
}

?>