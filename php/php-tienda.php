<?php
$sentenciaSQL = $conexion->prepare("SELECT * FROM categoria");
$sentenciaSQL->execute();
$categorias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
