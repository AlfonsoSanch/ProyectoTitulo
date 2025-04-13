<?php
include("../template/cabecera-ad.php");
?>
<?php



$txtCategoriaID = (isset($_POST['txtCategoriaID'])) ? $_POST['txtCategoriaID'] : "";
$txtDescripcionCat = (isset($_POST['txtDescripcionCat'])) ? $_POST['txtDescripcionCat'] : "";
$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

include("../../../php/conexion_be.php");

switch ($accion) {
    case "Agregar":
        $sentenciaSQL = $conexion->prepare("INSERT INTO categoria(CategoriaID, descripcionCategoria)VALUES(:CategoriaID, :descripcionCategoria);");
        $sentenciaSQL->bindParam(":CategoriaID", $txtCategoriaID);
        $sentenciaSQL->bindParam(":descripcionCategoria", $txtDescripcionCat);
        $sentenciaSQL->execute();

        break;



    case "Modificar":
        $sentenciaSQL = $conexion->prepare("UPDATE categoria SET descripcionCategoria=:descripcionCategoria WHERE CategoriaID=:CategoriaID");
        $sentenciaSQL->bindParam("CategoriaID", $txtCategoriaID);
        $sentenciaSQL->bindParam("descripcionCategoria", $txtDescripcionCat);
        $sentenciaSQL->execute();

        break;



    case "Cancelar":
        break;

    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM categoria WHERE CategoriaID=:CategoriaID");
        $sentenciaSQL->bindParam(":CategoriaID", $txtCategoriaID);
        $sentenciaSQL->execute();
        $cat = $sentenciaSQL->fetch(PDO::FETCH_ASSOC);

        $txtDescripcionCat = $cat['descripcionCategoria'];
        break;

    case "Borrar":
        $sentenciaSQL = $conexion->prepare("DELETE FROM categoria WHERE CategoriaID=:CategoriaID");
        $sentenciaSQL->bindParam(":CategoriaID", $txtCategoriaID);
        $sentenciaSQL->execute();
        break;
}






$categoriaSQL = $conexion->prepare("SELECT * FROM categoria");
$categoriaSQL->execute();
$listCategorias = $categoriaSQL->fetchAll(PDO::FETCH_ASSOC);

?>

<section class="  bg-center bg-no-repeat bg-[url('https://www.partoo.co/wp-content/uploads/2022/08/categories-google-my-business-1.jpg')] bg-cover min-h-screen bg-blend-multiply">
    <div class=" w-full  py-8 px-4 mx-4 max-w-xl lg:py-16">
        <h2 class="mb-1 text-xl font-bold text-gray-700 dark:text-gray-800">Agrega una nueva Categoria</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <div class="sm:col-span-2">

                    <label for="txtCategoriaID" class=""></label>
                    <input type="hidden" name="txtCategoriaID" id="txtCategoriaID" class="" value="<?php echo $txtCategoriaID; ?>"
                        placeholder="">

                </div>

                <div class="w-full">

                    <label for="txtDescripcionCat" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre Categoria</label>
                    <input type="text" name="txtDescripcionCat" id="txtDescripcionCat" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg
                   focus:ring-primary-600 focus:border-primary-600 block w-64 p-2.5 dark:bg-gray-700 dark:border-gray-600
                    dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" value="<?php echo $txtDescripcionCat; ?>"
                        placeholder="Nombre Categoria..." required="">

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
                            CategoriaID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Descripcion Categoria
                        </th>
                        <th scope="col" class="px-20 py-3">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($listCategorias as $categoria) { ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td><?php echo $categoria["CategoriaID"]; ?></td>
                            <td><?php echo $categoria["descripcionCategoria"]; ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="txtCategoriaID" id="txtCategoriaID"
                                        value="<?php echo $categoria['CategoriaID']; ?>">
                                    <input type="submit" name="accion" value="Borrar" class="inline-flex items-center px-4 py-2.5 mt-2 sm:mt-6 text-sm font-medium text-center text-white bg-red-800 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800" />
                                    <input type="submit" name="accion" value="Seleccionar" class="inline-flex items-center px-4 py-2.5 mt-2 sm:mt-6 text-sm font-medium text-center text-white bg-blue-800 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800" />
                                </form>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</section>