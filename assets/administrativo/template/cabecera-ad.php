<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location:../../../index.php");
  exit();
}

$usuario = $_SESSION['usuario'];

?>

<script src="https://cdn.tailwindcss.com"></script>

<nav class="bg-white border-gray-200 dark:bg-gray-900">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="../adminindex.php" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="../../img/logo.png" class="h-8" alt="PictoChile-Logo" />
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">PictoChile Administrador</span>
    </a>
    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
      <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row
       md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
        <li>
          <a href="adminindex.php" class="block py-2 px-3 text-white bg-blue-700 rounded md:bg-transparent md:text-blue-700 md:p-0
           dark:text-white md:dark:text-blue-500" aria-current="page">Home</a>
        </li>
        <li>
          <a href="./productos.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0
           md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700
            dark:hover:text-white md:dark:hover:bg-transparent">Productos</a>
        </li>
        <li>
          <a href="../views-adm.php/categorias.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0
           md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700
            dark:hover:text-white md:dark:hover:bg-transparent">Categorias</a>
        </li>
        <!-- <li>
          <a href="#" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0
           md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700
            dark:hover:text-white md:dark:hover:bg-transparent">Pricing</a>
        </li> -->
        <li>
          <a href="../../views/bienvenida.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent
           md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700
            dark:hover:text-white md:dark:hover:bg-transparent">Pagina Web</a>
        </li>

        <span class="text-white dark:text-white  ">Bienvenid@ Administrador, <?php echo htmlspecialchars($usuario); ?>!</span>

      </ul>
    </div>
  </div>
</nav>