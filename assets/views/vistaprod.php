<?php
include "../template/cabecera.php";
include "../../php/conexion_be.php";


$tomarProd = $conexion->prepare('SELECT * FROM productos WHERE productoID = "' . $_GET['productoID'] . '"');
$tomarProd->execute();
$producto = $tomarProd->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="pb-32"></div>
<?php
foreach ($producto as $key => $p) {
?>

  <section class="py-8 bg-white md:py-16 dark:bg-gray-900 antialiased">
    <div class="max-w-screen-xl px-4 mx-auto 2xl:px-0">
      <div class="lg:grid lg:grid-cols-2 lg:gap-8 xl:gap-16">
        <div class="shrink-0 max-w-md lg:max-w-lg mx-auto">
          <img class="w-full max-h-80 dark:hidden" src="../img/productos/<?php echo $p["img"] ?>" alt="" />
          <img class="w-full max-h-80 hidden dark:block" src="../img/productos/<?php echo $p["img"] ?>" alt="" />
        </div>

        <div class="mt-6 sm:mt-8 lg:mt-0">
          <h1
            class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">
            <?php echo $p["nombrePro"] ?>
          </h1>
          <div class="mt-4 sm:items-center sm:gap-4 sm:flex">
            <p
              class="text-2xl font-extrabold text-gray-900 sm:text-3xl dark:text-white">
              &dollar;<?php echo number_format($p["precio"], decimals: 0, decimal_separator: ',', thousands_separator: '.'); ?>
            </p>
          </div>

          <div class="mt-6 sm:gap-4 sm:items-center sm:flex sm:mt-8">
            <form action="carro.php" method="POST">
              <label for="cantidad" class="mb-6 text-gray-500 dark:text-gray-400">Cantidad</label><br>
              <input type="number" name="cantidad" value="1" min="1" max="<?= $p["stock"] ?>" placeholder="Cantidad" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="90210" required><br>
              <input type="hidden" name="productoID" value="<?= $p["productoID"] ?>">
              <br>
              <input type="submit" name="submit" value="Añadir al carro" class="flex items-center justify-center py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
            </form>
          </div>

          <hr class="my-6 md:my-8 border-gray-200 dark:border-gray-800" />

          <p class="mb-6 text-gray-500 dark:text-gray-400">
            <?php echo $p["descripcion"] ?>
          </p>
        </div>
      </div>
    </div>
  </section>


<?php
}
?>


<?php
include '../template/pie.php'
?>