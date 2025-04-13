<?php
include 'conexion_be.php'; // Asegúrate de que la conexión esté correctamente definida en este archivo

// Capturar los datos del formulario
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$direccion = $_POST['direccion'];
$correo = $_POST['correo'];
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Encriptar la contraseña
$contrasena = hash('sha512', $contrasena);

try {
    // Verificar si el correo ya está registrado
    $verificarCorreoQuery = "SELECT * FROM persona WHERE correo = :correo";
    $stmt = $conexion->prepare($verificarCorreoQuery);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo '
            <script>
                alert("Auch, Este correo ya esta en uso.");
                window.location = "../index.php";
            </script>
        ';
        exit();
    }

    // Verificar si el usuario ya está registrado
    $verificarUsuarioQuery = "SELECT * FROM persona WHERE usuario = :usuario";
    $stmt = $conexion->prepare($verificarUsuarioQuery);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        echo '
            <script>
                alert("Auch, Este usuario ya esta en uso.");
                window.location = "../index.php";
            </script>
        ';
        exit();
    }

    // Insertar el nuevo usuario en la base de datos
    $query = "INSERT INTO persona(nombre, apellido, direccion, correo, usuario, contraseña) 
              VALUES (:nombre, :apellido, :direccion, :correo, :usuario, :contrasena)";
    $stmt = $conexion->prepare($query);
    
    // Vincular los parámetros con los valores
    $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
    $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
    $stmt->bindParam(':direccion', $direccion, PDO::PARAM_STR);
    $stmt->bindParam(':correo', $correo, PDO::PARAM_STR);
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);
    
    // Ejecutar la consulta
    $stmt->execute();
    
    // Verificar si la inserción fue exitosa
    if ($stmt->rowCount() > 0) {
        echo '
            <script>
                alert("Te has registrado exitosamente!");
                window.location = "../index.php";
            </script>
        ';
    } else {
        echo '
            <script>
                alert("Auch, intentalo otra vez.");
                window.location = "../index.php";
            </script>
        ';
    }
} catch (PDOException $e) {
    // Manejo de errores de la base de datos
    echo '
        <script>
            alert("Error: ' . $e->getMessage() . '");
            window.location = "../index.php";
        </script>
    ';
}
?>
