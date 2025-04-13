<?php
$host = "localhost";
$bd = "proyecto";
$usuario = "root";
$contrasena = "";

try{
    $conexion = new PDO("mysql:host=$host;dbname=$bd", $usuario, $contrasena);
    //if($conexion){echo "conectado";}
} catch (Exception $e) {
    echo $e->getMessage();
}

    
?>