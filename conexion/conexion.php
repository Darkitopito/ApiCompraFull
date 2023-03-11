<?php

class Conexion extends Mysqli {
    function __construct() {
        parent::__construct('localhost', 'root', '', 'venta');
        $this->set_charset('utf8');
        $this -> connect_error == null ? 'conexion exitosa': die('error conexion');       
    }
}
?>