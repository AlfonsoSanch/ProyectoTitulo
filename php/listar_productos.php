<style>
    <?php include 'assets/css/estilos.css'; ?>
</style>

<?php

include 'conexion_be.php';

$sentenciaSQL = $conexion->prepare("SELECT * FROM categoria");
$sentenciaSQL->execute();
$categorias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$cantProductosSQL = "SELECT COUNT(*) FROM productos";
$infoProductosSQL = "SELECT * FROM productos ORDER BY productoID LIMIT :inicio, :limite";

$prodPorPagina = 12;

if(isset($_GET['pag']) && !empty($_GET['pag'])){
    $pagActiva = $_GET['pag'];
    }
else {
    $pagActiva = 1;
    }

$iniciarDe = ($pagActiva * $prodPorPagina) - $prodPorPagina;

$cantidadProductoSQL = $conexion->prepare($cantProductosSQL);
$cantidadProductoSQL->execute();
$totalProductos = $cantidadProductoSQL->fetchColumn();

$productoSQL = $conexion->prepare($infoProductosSQL);;
$productoSQL->bindValue(':inicio', (int) $iniciarDe, PDO::PARAM_INT);
$productoSQL->bindValue(':limite', (int) $prodPorPagina, PDO::PARAM_INT);
$productoSQL->execute();
$productosMostrados = $productoSQL->fetchAll(PDO::FETCH_ASSOC);

$pagFinal = ceil($totalProductos/$prodPorPagina);  
$pagPrimera = 1;
$pagSiguiente = $pagActiva + 1;
$pagSiguienteDoble = $pagActiva + 2;
$pagPrevia = $pagActiva - 1;
$pagPreviaDoble = $pagActiva - 2;
$pagPenultima = $pagFinal - 1;