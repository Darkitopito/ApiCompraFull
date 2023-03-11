<?php
require_once "modelo/controlador.php";
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo 'funciono';
        break;
    default:
    break;
}

?>