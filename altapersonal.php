<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php'; // Incluir el archivo de conexión a la base de datos

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $usuario = $_POST['usuario'];
    $contraseña = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $cargo = $_POST['cargo'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $fecha_resgistro = $_POST['fecha-registro'];

    // Preparar y vincular
    $stmt = $conn->prepare("INSERT INTO personal (nombre, apellido, usuario, contraseña, cargo, telefono, correo, fecha_registro) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nombre, $apellidos, $usuario, $contraseña, $cargo, $telefono, $correo, $fecha_resgistro);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Nuevo personal registrado exitosamente";
    // Redirigir al usuario a otra página
    header("Location: ingresar.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
