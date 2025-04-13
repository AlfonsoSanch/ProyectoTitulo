 <?php include("../template/cabecera.php");  ?>
 <html lang="es">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>PictoChile - Inclusión Social</title>
     <script src="https://cdn.tailwindcss.com"></script>
 </head>

 <body class=" mt-0 ">
     <!-- Encabezado -->
     <header class="relative bg-cover bg-center h-[500px] mt-0" style="background-image: url('../img/reunion.jpg');">
         <div class="absolute inset-0 bg-black bg-opacity-50 flex flex-col justify-center items-center text-white text-center px-4">
             <h1 class="text-4xl md:text-5xl font-bold">Creando una sociedad más inclusiva</h1>
             <p class="mt-4 text-lg max-w-2xl">
                 PictoChile es una empresa con enfoque social que busca ser referente para la concientización e inclusión
                 social de niños, niñas y adolescentes con alguna condición o necesidad educativa especial.
             </p>
             <a href="tienda.php" class="mt-6 px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-md text-lg">
                 Ver Tienda
             </a>
         </div>
     </header>

     <!-- Sección de características -->
     <section class="bg-white py-16">
         <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">

             <!-- Historia -->

             <div class="flex flex-col items-center cursor-pointer hover:opacity-90">
                 <a href="nosotros.php" class="flex flex-col items-center cursor-pointer hover:opacity-100 hover:scale-150 hover:shadow-2xl transition-all duration-200 rounded-2xl">
                     <img src="../img/libro-de-historia.png" alt="Historia" class="w-12 h-12 mb-4 cursor-pointer hover:opacity-90">
                 </a>
                 <h3 class="text-lg font-semibold text-gray-800">Historia</h3>
                 <p class="mt-2 text-gray-600">Conoce más sobre nuestra trayectoria y misión.</p>
             </div>

             <!-- Educación Inclusiva -->
             <div class="flex flex-col items-center cursor-pointer hover:opacity-90">
                 <a href="educacion_inclusiva.php" class="flex flex-col items-center cursor-pointer hover:opacity-100 hover:scale-150 hover:shadow-2xl transition-all duration-200 rounded-2xl">
                     <img src="../img/exito.png" alt="Educación Inclusiva" class="w-12 h-12 mb-4">
                 </a>
                 <h3 class="text-lg font-semibold text-gray-800">Educación Inclusiva</h3>
                 <p class="mt-2 text-gray-600">Descubre nuestras herramientas para la inclusión.</p>
             </div>

             <!-- Galería PictoChile -->
             <div class="flex flex-col items-center cursor-pointer hover:opacity-90 ">
                 <a href="galeria.php" class="flex flex-col items-center cursor-pointer hover:opacity-100 hover:scale-150 hover:shadow-2xl transition-all duration-200 rounded-2xl">
                     <img src="../img/galeria.png" alt="Galería" class="w-12 h-12 mb-4">
                 </a>
                 <h3 class="text-lg font-semibold text-gray-800">Galería PictoChile</h3>
                 <p class="mt-2 text-gray-600">Explora nuestras soluciones visuales en acción.</p>
             </div>

         </div>
     </section>


     <div class="max-w-4xl mx-auto mt-10 grid grid-cols-1 md:grid-cols-2 gap-8 items-center px-6 bg-white shadow-lg rounded-lg ">

         <div>
             <img src="../img/pictogramas.jpg" alt="Fundadoras de PictoChile" class="rounded-lg shadow-lg">
         </div>

         <div>
             <h2 class="text-2xl font-semibold text-orange-500 mb-4">Impacto Medioanbiental</h2>
             <p class="text-justify mb-4">
                 En PictoChile somos ecoamigables. Nuestros productos son elaborados con papel mineral,
                 de bajo impacto ambiental. Elaborado sin celulosa, agua, cloro, plástico ni químicos
                 su uso es idóneo para niños y niñas.
             </p>
         </div>
     </div>






 </body>

 </html>

 <?php
    include '../template/pie.php'
    ?>