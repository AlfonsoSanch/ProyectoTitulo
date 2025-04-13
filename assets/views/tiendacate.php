<?php include "../template/cabecera.php"; ?>
<?php include "../../php/prod_categoria.php"; ?>

<div class="pb-40"></div>

<aside class="absolute top-44 left-4 z-40 w-72 h-auto transition-transform -translate-x-full sm:translate-x-0">
    <div class="h-full px-3 py-4 overflow-y-auto text-white bg-blue-700 border-b border-gray-200 cursor-pointer dark:bg-gray-800 dark:border-gray-600 rounded-lg">
        <h3 class="block font-bold text-xl rounded-lg w-full px-4 py-2 text-white bg-blue-700 border-b border-gray-200 cursor-pointer dark:bg-gray-800 dark:border-gray-600">Categorias</h3>
        <ul class="space-y-2 font-medium">
            <?php
            foreach ($categorias as $c) {
                $idCat = $c["CategoriaID"];
                echo "<li>";
                echo "<a href='/project/assets/views/tiendacate.php?pag=1&categoriaID=$idCat' class='flex items-center p-2 text-white bg-blue-700 border-b border-gray-200 cursor-pointer dark:bg-gray-800 dark:border-gray-600'>";
                echo $c['descripcionCategoria'];
                echo "</a>";
                echo "</li>";
            } ?>
        </ul>
    </div>
</aside>



<div class="pl-80 mb-4 grid gap-4 sm:grid-cols-2 md:mb-8 lg:grid-cols-3 xl:grid-cols-4">
    <h3 class="absolute justify-center block rounded-lg border-gray-600 bg-gray-800 top-24 left-80 w-40 h-12 mb-4 pl-2 pt-1 font-bold text-3xl  text-white">Productos</h3>

    <?php
    foreach ($productosMostrados as $pd => $value) {
    ?>
        <a class="p-4 max-w-sm" href="vistaprod.php?productoID=<?= $value['productoID'] ?>">
            <div class="flex rounded-lg h-full dark:bg-gray-800 bg-teal-400 p-8 flex-col">
                <img class="h-48 w-full object-cover object-center" src="../img/productos/<?php echo $value["img"] ?>" alt="Imagen Producto" />
                <div class="flex items-center mb-3">
                    <div class="w-8 h-8 mr-3 inline-flex items-center justify-center rounded-full dark:bg-indigo-500 bg-indigo-500 text-white flex-shrink-0">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                            <path d="M22 12H-4l-3 9L9 3l-3 9H2"></path>
                        </svg>
                    </div>
                    <div class="pt-4">
                        <h2 class="text-white dark:text-white text-lg font-medium"><?php echo $value["nombrePro"] ?></h2>
                        <div class="flex items-center">
                            <p class="mr-2 text-lg font-semibold text-gray-900 dark:text-white">&dollar;<?php echo number_format(num: $value["precio"], decimals: 0, decimal_separator: ',', thousands_separator: '.'); ?></p>
                        </div>
                    </div>


                </div>
            </div>
        </a>



    <?php } ?>
</div>




<div class="flex justify-center pl-72 space-x-1">
    <?php if ($pagActiva > $pagPrimera) { ?>
        <a href="?pag=<?php echo $pagPrevia ?>&categoriaID=<?php echo $catID ?>" class="min-w-9 min-h-9 font-bold rounded-md border bg-gray-800 text-white border-gray-600 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg hover:text-gray-600 hover:bg-white hover:border-gray-600 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
            <
                </a>
            <?php } ?>

            <?php if ($pagActiva >= 3) { ?>
                <a href="?pag=<?php echo $pagPreviaDoble ?>&categoriaID=<?php echo $catID ?>" class="min-w-9 min-h-9 rounded-md border bg-gray-800 text-white border-gray-600 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg hover:text-gray-600 hover:bg-white hover:border-gray-600 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                    <?php echo $pagPreviaDoble ?>
                </a>
            <?php } ?>

            <?php if ($pagActiva >= 2) { ?>
                <a href="tiendacate.php?pag=<?php echo $pagPrevia ?>&categoriaID=<?php echo $catID ?>" class="min-w-9 min-h-9 rounded-md border bg-gray-800 text-white border-gray-600 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg hover:text-gray-600 hover:bg-white hover:border-gray-600 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                    <?php echo $pagPrevia ?>
                </a>
            <?php } ?>

            <a href="?pag=<?php echo $pagActiva ?>&categoriaID=<?php echo $catID ?>" class="min-w-9 min-h-9 rounded-md border bg-white text-gray-600 border-gray-600 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg hover:text-gray-600 hover:bg-white hover:border-gray-600 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                <?php echo $pagActiva ?>
            </a>

            <?php if ($pagActiva < $pagFinal) { ?>
                <a href="?pag=<?php echo $pagSiguiente ?>&categoriaID=<?php echo $catID ?>" class="min-w-9 min-h-9 rounded-md border bg-gray-800 text-white border-gray-600 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg hover:text-gray-600 hover:bg-white hover:border-gray-600 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                    <?php echo $pagSiguiente ?>
                </a>
            <?php } ?>

            <?php if ($pagActiva < $pagPenultima) { ?>
                <a href="?pag=<?php echo $pagSiguienteDoble ?>&categoriaID=<?php echo $catID ?>" class="min-w-9 min-h-9 rounded-md border bg-gray-800 text-white border-gray-600 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg hover:text-gray-600 hover:bg-white hover:border-gray-600 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                    <?php echo $pagSiguienteDoble ?>
                </a>
            <?php } ?>

            <?php if ($pagActiva < $pagFinal) { ?>
                <a href="?pag=<?php echo $pagSiguiente ?>&categoriaID=<?php echo $catID ?>" class="min-w-9 min-h-9 font-bold rounded-md border bg-gray-800 text-white border-gray-600 py-2 px-3 text-center text-sm transition-all shadow-sm hover:shadow-lg hover:text-gray-600 hover:bg-white hover:border-gray-600 focus:text-white focus:bg-slate-800 focus:border-slate-800 active:border-slate-800 active:text-white active:bg-slate-800 disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none ml-2">
                    >
                </a>
            <?php } ?>

</div>




<?php
include '../template/pie.php'
?>

</body>