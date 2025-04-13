
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/estilos.css" />
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>

    <main>
        <div class="contenedor__todo">
            <div class="caja__trasera bg-teal-900 bg-opacity-20">
                <div class=" caja__trasera-login">
                    <h3>¿Ya tienes cuenta?</h3>
                    <p>Inicia sesión para entrar a la página</p>
                    <button id="btn__iniciar-sesion">Iniciar Sesión</button>
                </div>
                <div class="caja__trasera-register">
                    <h3>¿Aun no tienes cuenta?</h3>
                    <p>Registrate para que puedas iniciar sesión</p>
                    <button id="btn__registrarse">Registrarse</button>
                </div>
            </div>
            <!--login y registro-->
            <div class="contenedor__login-register">

                <form action="php/login_usuario_be.php" method="POST"  class="formulario__login">

                    <h2>Iniciar Sesión</h2>
                    <input type="text" placeholder="Nombre de Usuario" name="usuario" required>
                    <input type="password" placeholder="Contraseña" name="contrasena" required>
                    <button class="py-3 px-10 mt-5 text-sm bg-[#46A2FD] text-white cursor-pointer">Entrar</button>
                </form>
                <!--Registro-->
                <form action="php/registro_usuario.php" method="POST" class="formulario__register">
                    <h2>Registrarse</h2>
                    <input type="text" placeholder="Nombre" name="nombre" required>
                    <input type="text" placeholder="Apellido" name="apellido" required>
                    <input type="text" placeholder="Direccion" name="direccion" required>
                    <input type="text" placeholder="Correo" name="correo" required>
                    <input type="text" placeholder="Usuario" name="usuario" required>
                    <input type="password" placeholder="Contraseña" name="contrasena" required>
                    <button class="py-3 px-10 mt-5 text-sm bg-[#46A2FD] text-white cursor-pointer">Registrarse</button>
                </form>
            </div>
        </div>
    </main> 
    <script src="assets/js/script.js"></script>
</body>

</html>

