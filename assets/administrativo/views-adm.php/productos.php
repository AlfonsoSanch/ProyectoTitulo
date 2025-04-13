<?php
include("../template/cabecera-ad.php");
//include ("../../../php/conexion_be.php");
?>
<?php

$txtproductoID = (isset($_POST['txtproductoID'])) ? $_POST['txtproductoID'] : "";
$txtNombrepro = (isset($_POST['txtNombrepro'])) ? $_POST['txtNombrepro'] : "";
$selCategoriaID = (isset($_POST['selCategoriaID'])) ? $_POST['selCategoriaID'] : "";
$txtPrecio = (isset($_POST['txtPrecio'])) ? $_POST['txtPrecio'] : "";
$txtstock = (isset($_POST['txtstock'])) ? $_POST['txtstock'] : "";
$txtdescripcion = (isset($_POST['txtdescripcion'])) ? $_POST['txtdescripcion'] : "";
$txtImagen = (isset($_FILES['txtImagen']['name'])) ? $_FILES['txtImagen']['name'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../../../php/conexion_be.php");


//INSERT INTO `productos`(`productoID`, `nombrePro`, `descripcion`, `stock`, `precio`, `img`, `categoriaID`) 
//VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')
switch ($accion) {
    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO productos(productoID, nombrePro, descripcion, stock, precio, img, categoriaID) VALUES (:productoID, :nombrePro, :descripcion, :stock, :precio, :img, :categoriaID);");
        $sentenciaSQL->bindParam(":productoID", $txtproductoID);
        $sentenciaSQL->bindParam(":nombrePro", $txtNombrepro);
        $sentenciaSQL->bindParam(":descripcion", $txtdescripcion);
        $sentenciaSQL->bindParam(":stock", $txtstock);
        $sentenciaSQL->bindParam(":precio", $txtPrecio);
        $sentenciaSQL->bindParam(":img", $txtImagen);
        $sentenciaSQL->bindParam(":categoriaID", $selCategoriaID);
        $sentenciaSQL->execute();

        //header("location:producto.php");
        //echo "precionando boton add";

        break;

    case "Modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE productos SET nombrePro=:nombrePro, descripcion=:descripcion, stock=:stock, precio=:precio, img=:img, categoriaID=:categoriaID WHERE productoID=:productoID  ");
        $sentenciaSQL->bindParam(":productoID", $txtproductoID);
        $sentenciaSQL->bindParam(":nombrePro", $txtNombrepro);
        $sentenciaSQL->bindParam(":descripcion", $txtdescripcion);
        $sentenciaSQL->bindParam(":stock", $txtstock);
        $sentenciaSQL->bindParam(":precio", $txtPrecio);
        $sentenciaSQL->bindParam(":img", $txtImagen);
        $sentenciaSQL->bindParam(":categoriaID", $selCategoriaID);
        $sentenciaSQL->execute();

        //header("location:producto.php");

        if ($txtImagen != "") {
            $sentenciaSQL = $conexion->prepare("UPDATE  productos SET img=:img WHERE productoID=:productoID");
            $sentenciaSQL->bindParam(":img", $txtImagen);
            $sentenciaSQL->bindParam(":productoID", $txtproductoID);
            $sentenciaSQL->execute();
        }
        //echo "precionando boton modi";
        break;


    case "Cancelar":
        header("location:productos.php");
        break;


    case "Seleccionar";
        $sentenciaSQL = $conexion->prepare("SELECT * FROM productos WHERE productoID=:productoID");
        $sentenciaSQL->bindParam(":productoID", $txtproductoID);
        $sentenciaSQL->execute();
        $product = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

        $txtNombrepro = $product['nombrePro'];
        $txtdescripcion = $product['descripcion'];
        $txtstock = $product['stock'];
        $txtPrecio = $product['precio'];
        $txtImagen = $product['img'];
        $selCategoriaID = $product['categoriaID'];
        //echo "precionando boton sele";
        break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("DELETE FROM productos WHERE productoID=:productoID");
        $sentenciaSQL->bindParam(":productoID", $txtproductoID);
        $sentenciaSQL->execute();
        break;
}


$sentenciaSQL = $conexion->prepare("
    SELECT p.*, c.descripcionCategoria 
    FROM productos p 
    INNER JOIN categoria c ON p.categoriaID = c.CategoriaID
");
$sentenciaSQL->execute();
$listaproductos = $sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


$categoriasSQL = $conexion->prepare("SELECT * FROM categoria");
$categoriasSQL->execute();
$listaCategorias = $categoriasSQL->fetchAll(PDO::FETCH_ASSOC);
?>



<section class="  bg-stone-400 ">
    <div class="  px-4 mx-4 max-w-xl lg:py-10">
        <h2 class="mb-4 text-xl font-bold text-gray-700 dark:text-gray-800">Agrega un nuevo producto</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-4">
                <div class="sm:col-span-2">

                    <label for="txtproductoID" class=""></label>
                    <input type="hidden" name="txtproductoID" id="txtproductoID" class="" value="<?php echo $txtproductoID; ?>"
                        placeholder="Nombre del producto">

                </div>

                <div class="w-full">

                    <label for="txtNombrepro" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre del producto</label>
                    <input type="text" name="txtNombrepro" id="txtNombrepro" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                   focus:ring-primary-600 focus:border-primary-600 block w-64 p-2.5 dark:bg-gray-700 dark:border-gray-600
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?php echo $txtNombrepro; ?>"
                        placeholder="Nombre del producto" required="">

                </div>

                <div>
                    <label for="selCategoriaID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Categoria</label>
                    <select id="selCategoriaID" name="selCategoriaID" class="custom-select bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500
                    focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                     dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                        <?php foreach ($listaCategorias as $categoria) {
                            echo "<option value='" . $categoria["CategoriaID"] . "'>" . $categoria["descripcionCategoria"] . "</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="w-full">
                    <label for="txtPrecio" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Precio</label>
                    <input type="number" name="txtPrecio" id="txtPrecio" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                   focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?php echo $txtPrecio; ?>"
                        placeholder="$1000" required="">

                </div>

                <div>
                    <label for="txtstock" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Stock</label>
                    <input type="number" name="txtstock" id="txtstock" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm
                   rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?php echo $txtstock; ?>"
                        placeholder="12" required="">
                </div>

                <div class="sm:col-span-2">
                    <label for="txtdescripcion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Descripcion del producto</label>
                    <input type="text" id="txtdescripcion" name="txtdescripcion" class="block p-2.5 w-full h-20 text-sm text-gray-900 bg-gray-50 rounded-lg border
                   border-gray-300 focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?php echo $txtdescripcion; ?>"
                        placeholder="Describe el producto">
                </div>

                <div class="sm:col-span-2">
                    <label for="txtImagen" class="block mb-2 txt-sm font-medium text-gray-900 dark:text-white">Imagen </label>
                    <input type="file" class="bg-gray-50 border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600
                 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400
                dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?php echo $txtImagen; ?>"
                        name="txtImagen" id="txtImagen" placeholder="Imagen">
                </div>
            </div>


            <div class="btn-group" role="group" aria-label="">

                <button type="submit" name="accion" value="Agregar" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-green-800 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Agregar
                </button>

                <button type="submit" name="accion" value="Modificar" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-yellow-600 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Modificar
                </button>

                <button type="submit" name="accion" value="Cancelar" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-blue-800 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Cancelar
                </button>

            </div>
        </form>

        <div class=" ">
            <table class=" text-sm text-center rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ProductoID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nombre del Producto
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Descripcion
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Stock
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Precio
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Categoria
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Imagen
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Accion
                        </th>


                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listaproductos as $producto) { ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td><?php echo $producto["productoID"]; ?></td>
                            <td><?php echo $producto["nombrePro"]; ?></td>
                            <td><?php echo $producto["descripcion"]; ?></td>
                            <td><?php echo $producto["stock"]; ?></td>
                            <td><?php echo $producto["precio"]; ?></td>
                            <td><?php echo $producto["descripcionCategoria"]; ?></td>
                            <td><?php echo $producto["img"]; ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="txtproductoID" id="txtproductoID"
                                        value="<?php echo $producto['productoID']; ?>">
                                    <input type="submit" name="accion" value="Borrar" class="inline-flex items-center px-5 py-2.5 mt-2 sm:mt-6 text-sm font-medium text-center text-white bg-red-800 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800" />
                                    <input type="submit" name="accion" value="Seleccionar" class="inline-flex items-center px-2.5 py-2.5 mt-2 sm:mt-6 text-sm font-medium text-center text-white bg-blue-800 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800" />
                                </form>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</section>