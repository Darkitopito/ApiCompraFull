<?php
require_once "conexion/conexion.php";

class controlador {

    public static function registro_cliente($cedula, $nombre, $celular, $correo, $password) {
        $db = new Conexion();
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); 
        $query = "INSERT INTO clientes (cedula, nombre, celular, correo, password) 
        VALUES ('".$cedula."', '".$nombre."', '".$celular."', '".$correo."', '".$hashed_password."');";
        $db->query($query);
        if($db->affected_rows){
            return  TRUE;
        }
        return FALSE;
    }

    public static function login($cedula, $password) {
        $db = new Conexion();
        $query = "SELECT * FROM clientes WHERE cedula = '".$cedula."'";
        $resultado = $db->query($query);
        if($resultado->num_rows == 1) {
            $row = $resultado->fetch_assoc();
            if(password_verify($password, $row['password'])) {
                session_start();
                $_SESSION['cedula'] = $cedula;
                header('Location: factura.php?cedula='.$cedula);
                exit();
            } else {
                return "La contraseña es incorrecta";
            }
        } else {
            return "No se encontró un usuario con la cédula proporcionada";
        }
    } 

    public static function registro_producto($codigo,$nombre,$valor) {
        $db = new Conexion();
        $query = "INSERT INTO producto (codigo, nombre, valor) 
        VALUES ('".$codigo."', '".$nombre."','".$valor."');";
        $db->query($query);
        if($db->affected_rows){
            return  TRUE;
        }
         return FALSE;
    }

    public static function compra($cedula,$codigo,$fecha) {
        $db = new Conexion();
        $query = "INSERT INTO factura (codigo, cedula, fecha)
        VALUES ('".$codigo."', '".$cedula."', '".$fecha."');";
        $db->query($query);
        if($db->affected_rows){
            return TRUE;
        }
        return FALSE;
    }

    public static function recibo($id){
        $db = new Conexion();
        $query = "SELECT clientes.nombre,cliente.cedula,producto.* , factura.fecha, DAY(factura.fecha) as dia
        FROM factura
        INNER JOIN clientes  ON factura.cedula = clientes.cedula
        INNER JOIN producto  ON factura.codigo = producto.codigo
        WHERE producto.codigo = '".$id."' OR clientes.cedula = '".$id."'";
        $resultado = $db->query($query);
        $datos = []; //inicializo array datos
        $valorfinal = 0;
        if($resultado->num_rows){
            while($row = $resultado ->fetch_assoc()) {
                if($row['dia']=='15'){
                    $valorfinal = $row['valor'] - ($row['valor'] * 0.10);    
                    $descuento = '10%';
                } else {
                    if($row['dia']=='30'){
                        $valorfinal = $row['valor'] - ($row['valor'] * 0.20);    
                        $descuento = '20%';
                    }
                }
                $datos[] = [
                    'id' => $row['codigo'],
                    'codigo' => $row['codigo'],
                    'cedula' => $row['cedula'],
                    'fecha' => $row['fecha'],
                    'valor' => $row['valor'],
                    'Valor final' => $valorfinal,
                    'Descuento' => $descuento
                ];
            }
          return $datos;
        }
     return $datos;
    }
}
?>