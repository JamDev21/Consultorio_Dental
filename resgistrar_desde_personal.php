<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php'; // Incluir el archivo de conexión a la base de datos

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $contraseña = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha-nacimiento'];
    $sexo = $_POST['sexo'];
    $contacto_emergencia = $_POST['contacto_emergencia'];

    // Preparar y vincular
    $stmt = $conn->prepare("INSERT INTO pacientes (nombre, apellidos, correo, contraseña, telefono, fecha_nacimiento, sexo, contacto_emergencia) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nombre, $apellidos, $email, $contraseña, $telefono, $fecha_nacimiento, $sexo, $contacto_emergencia);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Nuevo paciente registrado exitosamente";
    // Redirigir al usuario a otra página
    header("Location: ver-pacientes.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
