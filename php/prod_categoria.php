<style>
    <?php include 'assets/css/estilos.css'; ?>
</style>

<?php 
include 'conexion_be.php';

$catID = $_GET['categoriaID'];
if (!(isset($catID))) {
    $catID = 1;
}

$IDcategoria = isset($_SESSION['categoriaID']) && is_numeric($_SESSION['categoriaID']) ? $_SESSION['categoriaID'] : 0;
$_SESSION['categoriaID'] = $IDcategoria;

$sentenciaSQL = $conexion->prepare("SELECT * FROM categoria");
$sentenciaSQL->execute();
$categorias = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$sentenciaSQL = $conexion->prepare("SELECT * FROM categoria WHERE categoriaID = :catID");
$sentenciaSQL->bindParam(':catID', $catID);
$sentenciaSQL->execute();
$catSeleccionada = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);

$prodPorPagina = 12;

if(isset($_GET['pag']) && !empty($_GET['pag'])){
    $pagActiva = $_GET['pag'];
    }
else {
    $pagActiva = 1;
    }

$iniciarDe = ($pagActiva * $prodPorPagina) - $prodPorPagina;

$cantProductosSQL = $conexion->prepare("SELECT COUNT(*) FROM productos WHERE categoriaID = :catID");
$cantProductosSQL->bindParam(":catID", $catID, PDO::PARAM_STR);
$cantProductosSQL->execute();
$totalProductos = $cantProductosSQL->fetchColumn();
$infoProductos = $cantProductosSQL->fetchAll(PDO::FETCH_ASSOC);

$productoSQL = $conexion->prepare("SELECT * FROM productos WHERE categoriaID = :catID ORDER BY productoID LIMIT :inicio, :limite");
$productoSQL->bindParam(':catID', $catID, PDO::PARAM_STR);
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

?>