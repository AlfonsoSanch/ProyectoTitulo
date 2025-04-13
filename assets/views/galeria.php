<?php include("../template/cabecera.php");  ?>

<?php
//tuvimos que poner las 2 rutas la primera es donde se almacenan en el servidor de xampp y la segunda para poder mostrarlas en publico/sitioweb
$carpetaImagenes = 'C:/xampp/htdocs/project/assets/img/galeria';
$rutaWebImagenes = '/project/assets/img/galeria';

$imagenes = array_filter(scandir($carpetaImagenes), function ($arch) use ($carpetaImagenes) {
    $dire = $carpetaImagenes . '/' . $arch;
    return is_file($dire) && preg_match('/\.(jpg|jpeg|png|gif)$/i', $arch);
});
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galería de Fotos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-300 text-gray-800">
    <h1 class="mt-10 ">Galeria</h1>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-8">Galería de Fotos</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">


            <?php foreach ($imagenes as $index => $imagen): ?>
                <?php $rutaImagen = $rutaWebImagenes . '/' . $imagen; ?>
                <div class="relative group">

                    <a href="#lightbox-<?= $index ?>" class="block" onclick="mostrarLightbox(<?= $index ?>)">
                        <img
                            src="<?= $rutaImagen ?>"
                            alt="Imagen"
                            class="w-full h-48 object-cover rounded-lg shadow-md transition-transform duration-300 group-hover:scale-105">
                    </a>
                </div>

                <!-- necesita de flex y hidden para mostrar la imagen correctamente -->
                <div id="lightbox-<?= $index ?>" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center z-50 hidden">
                    <div class="relative">
                        <button onclick="cerrarLightbox(<?= $index ?>)" class="absolute top-2 right-2 text-white text-4xl font-bold">&times;</button>

                        <!-- imagen dentro del lightbox -->
                        <img src="<?= $rutaImagen ?>" alt="Imagen" class="max-w-3xl max-h-[80vh] rounded-lg shadow-lg">

                        <!-- controles para navegar -->
                        <button onclick="navegarLightbox(<?= $index ?>, 'prev')" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-4xl">←</button>
                        <button onclick="navegarLightbox(<?= $index ?>, 'next')" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-4xl">→</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        //mostrar, cerrar, navergar en la caja
        function mostrarLightbox(index) {
            const lightbox = document.getElementById(`lightbox-${index}`);
            lightbox.classList.remove('hidden');
        }


        function cerrarLightbox(index) {
            const lightbox = document.getElementById(`lightbox-${index}`);
            lightbox.classList.add('hidden');
        }


        function navegarLightbox(index, direccion) {
            const totalImagenes = <?= count($imagenes) ?>;
            let nuevoIndex = direccion === 'next' ? index + 1 : index - 1;


            if (nuevoIndex >= totalImagenes) nuevoIndex = 0;
            if (nuevoIndex < 0) nuevoIndex = totalImagenes - 1;


            cerrarLightbox(index);
            mostrarLightbox(nuevoIndex);
        }


        document.querySelectorAll('a[href^="#lightbox-"]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                target.classList.remove('hidden');
            });
        });
    </script>

</body>

</html>



<?php
include '../template/pie.php'
?>