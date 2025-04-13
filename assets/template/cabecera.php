<?php
session_start();
if (!isset($_SESSION['usuario'])) {
  header("Location:../../index.php");
  exit();
}

$usuario = $_SESSION['usuario'];
$rol = $_SESSION['rolID']

?>
<script src="https://cdn.tailwindcss.com"></script>

<nav class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <a href="bienvenida.php" class="flex items-center space-x-3 rtl:space-x-reverse">
      <img src="../img/logo.png" class="h-8" alt="PictoChile logo">
      <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">PictoChile</span>
    </a>


    <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">

      <span class="text-white dark:text-white p-3 ">Bienvenid@, <?php echo htmlspecialchars($usuario); ?>!</span>

      <a href="../../php/cerrar_sesion.php" class="text-white hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 
    rounded-lg px-3 py-2.5 ">Cerrar Sesión</a>

    </div>

    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
      <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 
    rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-green-700">


        <li>
          <a href="bienvenida.php" class="block py-2 px-3  text-white bg-blue-700 rounded md:bg-transparent  md:dark:hover:text-blue-500 md:p-0 "
            aria-current="page">Home</a>
        </li>

        <li>
          <a href="nosotros.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0
         md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent
          dark:border-gray-700">Nosotros</a>
        </li>

        <li>
          <a href="tienda.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0
         md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent
          dark:border-gray-700">Tienda</a>
        </li>

        <li>
          <a href="carro.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0
         md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent
          dark:border-gray-700">Carro</a>
        </li>

        <!-- Aquí está el botón que solo verá el administrador -->
        <?php if ($rol == '2') { ?>
          <li>
            <a href="../administrativo/views-adm.php/adminindex.php" class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Admin</a>
          </li>
        <?php } ?>

      </ul>
    </div>
  </div>
</nav>