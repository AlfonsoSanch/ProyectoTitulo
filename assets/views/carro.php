<?php
include "../template/cabecera.php";
include "../../php/conexion_be.php";
?>
<div class="pb-40"></div>
<?php




if (isset($_POST["productoID"], $_POST["cantidad"]) && is_numeric($_POST["productoID"]) && is_numeric($_POST["cantidad"])) {
  $productoID = (int)$_POST["productoID"];
  $cantidad = (int)$_POST["cantidad"];

  $selectProducto = $conexion->prepare("SELECT * FROM productos WHERE productoID = ?");
  $selectProducto->execute([$_POST["productoID"]]);
  $producto = $selectProducto->fetch(PDO::FETCH_ASSOC);

  if ($producto && $cantidad > 0) {
    if (isset($_SESSION["carro"]) && is_array($_SESSION["carro"])) {
      if (array_key_exists($productoID, $_SESSION["carro"])) {
        $_SESSION["carro"][$productoID] += $cantidad;
      } else {
        $_SESSION["carro"][$productoID] = $cantidad;
      }
    } else {
      $_SESSION["carro"] = array($productoID => $cantidad);
    }
  }
}

if (isset($_GET["remover"]) && is_numeric($_GET["remover"]) && isset($_SESSION["carro"]) && isset($_SESSION["carro"][$_GET["remover"]])) {
  unset($_SESSION["carro"][$_GET["remover"]]);
}

if (isset($_POST["actualizar"]) && isset($_SESSION["carro"])) {
  foreach ($_POST as $key => $value) {
    if (strpos($key, "cantidad") !== false && is_numeric($value)) {
      $idproducto = str_replace("cantidad-", "", $key);
      $cantidad = (int)$value;
      if (is_numeric($idproducto) && isset($_SESSION["carro"][$idproducto]) && $cantidad > 0) {
        $_SESSION["carro"][$idproducto] = $cantidad;
      }
    }
  }
  header("location: carro.php");
  exit;
}

if (isset($_POST["ponerpedido"]) && isset($_SESSION["carro"]) && !empty($_SESSION["carro"])) {

  $idses = session_id();
  $fechaDT = new DateTime('now');
  $fecha = $fechaDT->format('Y-m-d H:i:s');
  $IDpersona = $_SESSION['IDpersona'];

  $crearcarro = $conexion->prepare("INSERT INTO carro_compra(sesionID,personaID) VALUES(:sesid,:persID)");
  $crearcarro->bindParam(":sesid", $idses, PDO::PARAM_STR);
  $crearcarro->bindParam(":persID", $IDpersona, PDO::PARAM_INT);
  $crearcarro->execute();

  $tomaridcarro = $conexion->prepare("SELECT carroID FROM carro_compra WHERE sesionID = :sesid");
  $tomaridcarro->bindParam(":sesid", $idses, PDO::PARAM_STR);
  $tomaridcarro->execute();
  $identificarcarro = $tomaridcarro->fetchAll(PDO::FETCH_ASSOC);
  foreach ($identificarcarro as $v) {
    $idcarro = $v["carroID"];
    $_SESSION['idCarro'] = $v["carroID"];
  }

  $_SESSION['idVou'] = $_SESSION['idCarro'];

  foreach ($_POST as $id => $cant) {
    if (strpos($id, "cantidad") !== false && is_numeric($cant)) {

      $idproducto = str_replace("cantidad-", "", $id);
      $cantidad = (int)$cant;
      $cont = mt_rand();

      $precio = $conexion->prepare("SELECT * FROM productos WHERE productoID = :idprod");
      $precio->bindParam(":idprod", $idproducto, PDO::PARAM_INT);
      $precio->execute();
      $precioprod = $precio->fetchAll(PDO::FETCH_ASSOC);
      foreach ($precioprod as $k => $p) {
        $subtotalprod = (float)$p["precio"] * (int)$cantidad;
      }
      foreach ($precioprod as $id => $idk) {
        $nombreProd = (string)$idk["nombrePro"];
      }

      $selectorden = $conexion->prepare("INSERT INTO detallecompra(carroID,detalleID,productoID,cantidad,precioProd,precioTotal,fechaRegistro,fechaDecision,nombreProducto) VALUES(:idcarro,:cont,:idprod,:cantidad,:subtotalProd,:totalCompra,:fechaReg,:fechaDec,:nombreProd);");
      $selectorden->bindParam(":idcarro", $idcarro, PDO::PARAM_INT);
      $selectorden->bindParam(":cont", $cont, PDO::PARAM_INT);
      $selectorden->bindParam(":idprod", $idproducto, PDO::PARAM_INT);
      $selectorden->bindParam(":cantidad", $cantidad, PDO::PARAM_INT);
      $selectorden->bindParam(":subtotalProd", $subtotalprod, PDO::PARAM_INT);
      $selectorden->bindParam(":totalCompra", $_SESSION['pagoTotal'], PDO::PARAM_INT);
      $selectorden->bindParam(":fechaReg", $fecha, PDO::PARAM_STR);
      $selectorden->bindParam(":fechaDec", $fecha, PDO::PARAM_STR);
      $selectorden->bindParam(":nombreProd", $nombreProd, PDO::PARAM_STR);
      $selectorden->execute();

      $reducirStock = $conexion->prepare("UPDATE productos SET stock = stock - :compra WHERE productoID = :IDprod");
      $reducirStock->bindValue(':compra', $cantidad);
      $reducirStock->bindValue(':IDprod', $idproducto);
      $reducirStock->execute();
    }
  }
  header("location: tienda.php");
  exit;
}

$productoscarro = isset($_SESSION["carro"]) ? $_SESSION["carro"] : array();
$productos = array();
$subtotal = 0.00;

if ($productoscarro) {
  $_SESSION['pagoTotal'] = 0.00;
  $llenararray = implode(",", array_fill(0, count($productoscarro), "?"));
  $prodcarroSQL = $conexion->prepare('SELECT * FROM productos WHERE productoID IN (' . $llenararray . ')');
  $prodcarroSQL->execute(array_keys($productoscarro));
  $productos = $prodcarroSQL->fetchAll(PDO::FETCH_ASSOC);
  foreach ($productos as $p) {
    $subtotal += (float)$p["precio"] * (int)$productoscarro[$p["productoID"]];
    $_SESSION['pagoTotal'] = $subtotal;
  }
}

?>









<section class="bg-white py-8 antialiased dark:bg-gray-900 md:py-16">
  <div class="mx-auto max-w-screen-xl px-4 2xl:px-0">
    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white sm:text-2xl">Carro de compra</h2>
    <form action="carro.php" method="POST">


      <div class="mt-6 sm:mt-8 md:gap-6 lg:flex lg:items-start xl:gap-8">
        <div class="mx-auto w-full flex-none lg:max-w-2xl xl:max-w-4xl">
          <?php if (empty($productos)): ?>
            <h2 class="text-xl text-center font-semibold text-gray-900 dark:text-white sm:text-2xl">No hay productos en su carro</h2>
          <?php else: ?>
            <input type="submit" name="actualizar" value="Actualizar monto de productos" class="flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
            <br>

            <?php foreach ($productos as $p): ?>
              <div class="space-y-6">
                <div class="rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 md:p-6">
                  <div class="space-y-4 md:flex md:items-center md:justify-between md:gap-6 md:space-y-0">
                    <a href="carro.php?pag=producto&id=<?= $p["productoID"] ?>" class="shrink-0 md:order-1">
                      <img class="h-20 w-20 dark:hidden" src="../img/productos/<?= $p["img"] ?>" alt="<?= $p["nombrePro"] ?>" />
                      <img class="hidden h-20 w-20 dark:block" src="../img/productos/<?= $p["img"] ?>" alt="<?= $p["nombrePro"] ?>" />
                    </a>

                    <label for="contador" class="sr-only">Cantidad:</label>
                    <div class="flex items-center justify-between md:order-3 md:justify-end">
                      <div class="flex items-center">
                        <input type="number" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="cantidad-<?= $p["productoID"] ?>" value="<?= $productoscarro[$p["productoID"]] ?>" min="1" max="<?= $p["stock"] ?>" placeholder="Cantidad" required />

                      </div>
                      <div class="text-end md:order-4 md:w-32">
                        <p class="text-base font-bold text-gray-900 dark:text-white">&dollar;<?php echo number_format($p["precio"] * $productoscarro[$p["productoID"]], decimals: 0, decimal_separator: ',', thousands_separator: '.'); ?></p>
                      </div>
                    </div>

                    <div class="w-full min-w-0 flex-1 space-y-4 md:order-2 md:max-w-md">
                      <a href="carro.php?pag=product&id=<?= $p['productoID'] ?>" class="text-base font-medium text-gray-900 hover:underline dark:text-white"><?= $p["nombrePro"] ?></a>

                      <div class="flex items-center gap-4">
                        <a href="carro.php?pag=product&remover=<?= $p['productoID'] ?>" class="remover">
                          <button type="button" class="inline-flex items-center text-sm font-medium text-red-600 hover:underline dark:text-red-500" href="carro.php?pag=product&remover=<?= $p['productoID'] ?>">
                            <svg class="me-1.5 h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18 17.94 6M18 18 6.06 6" />
                            </svg>
                            Remover del carro
                          </button>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <br>
            <?php endforeach; ?>
        </div>
        <div class="mx-auto mt-6 max-w-4xl flex-1 space-y-6 lg:mt-0 lg:w-full">
          <div class="space-y-4 rounded-lg border border-gray-200 bg-white p-4 shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <p class="text-xl font-semibold text-gray-900 dark:text-white">Resumen compra</p>

            <div class="space-y-4">
              <dl class="flex items-center justify-between gap-4 border-t border-gray-200 pt-2 dark:border-gray-700">
                <dt class="text-base font-bold text-gray-900 dark:text-white">Total</dt>
                <dd class="text-base font-bold text-gray-900 dark:text-white">&dollar;<?php echo number_format($subtotal, decimals: 0, decimal_separator: ',', thousands_separator: '.'); ?></dd>
              </dl>
            </div>

            <div class="flex items-center justify-center">
              <input type="submit" name="ponerpedido" value="Reservar compra" class="flex items-center justify-center py-2.5 px-5 text-base font-medium text-white focus:outline-none rounded-lg hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 underline hover:no-underline">
            </div>

            <div class="flex items-center justify-center gap-2">
              <span class="text-sm font-normal text-gray-500 dark:text-gray-400"> o </span>
              <a href="../views/tienda.php" title="" class="inline-flex items-center gap-2 text-sm underline hover:no-underline font-semibold text-gray-900 dark:text-white">
                Seguir comprando
                <svg class="h-5 w-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 12H5m14 0-4 4m4-4-4-4" />
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>

    </form>
  </div>
</section>




<?php
include '../template/pie.php'
?>

</body>