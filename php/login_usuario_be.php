<?php
session_start();
include 'conexion_be.php'; // Asegúrate de que la conexión esté correctamente definida en este archivo

// Capturar los datos del formulario de login
$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$contrasena = hash('sha512', $contrasena); // Encriptar la contraseña

try {
    // Usar una sentencia preparada para evitar inyecciones SQL
    $query = "SELECT * FROM persona WHERE usuario = :usuario AND contraseña = :contrasena";
    $stmt = $conexion->prepare($query);

    // Bindear los parámetros a la sentencia
    $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
    $stmt->bindParam(':contrasena', $contrasena, PDO::PARAM_STR);

    // Ejecutar la sentencia
    $stmt->execute();

    // Verificar si el usuario existe
    if ($stmt->rowCount() > 0) {
        // Obtener los datos del usuario (por ejemplo, el tipo de usuario)
        $usuario_data = $stmt->fetch(PDO::FETCH_ASSOC);

        // Guardar la información en la sesión (por ejemplo, tipo de usuario y nombre de usuario)
        $_SESSION['logged_in'] = true;
        $_SESSION['usuario'] = $usuario_data['usuario'];
        $_SESSION['IDpersona'] = $usuario_data['personaID'];
        $_SESSION['rolID'] = $usuario_data['rolID']; // Suponiendo que 'rolID' sea el campo que indica si es 'USER' o 'ADMIN'

        // Redirigir según el tipo de usuario
        if ($_SESSION['rolID'] === '2') {
            header("Location: ../assets/administrativo/adminindex.php"); // Página del administrador
        } else {
            header("Location: ../assets/views/bienvenida.php"); // Página para el usuario normal
        }
        exit();
    } else {
        // Si las credenciales son incorrectas
        echo '
            <script>
                alert("Usuario o contraseña incorrectos, por favor verifique los datos.");
                window.location = "../index.php";
            </script>
        ';
        exit();
    }
} catch (PDOException $e) {
    // Si hay un error en la ejecución de la consulta
    echo 'Error de conexión: ' . $e->getMessage();
    exit();
}
?>
