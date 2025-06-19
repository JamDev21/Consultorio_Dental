<?php
include 'db_connect.php'; // Incluir el archivo de conexión a la base de datos
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['personal_id'])) {
    header("Location: ingresar.html");
    exit();
}

// Verificar si se han enviado los datos del paciente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_paciente'])) {
    $id_paciente = $_POST['id_paciente'];
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $correo = $_POST['email'];
    $telefono = $_POST['telefono'];
    $sexo = $_POST['sexo'];
    $fecha_nacimiento = $_POST['fecha-nacimiento'];
    $contacto_emergencia = $_POST['contacto_emergencia'];

    // Preparar la llamada al procedimiento almacenado
    $sql = "CALL actualizarPaciente(?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssssi", $id_paciente, $nombre, $apellidos, $correo, $telefono, $sexo, $fecha_nacimiento, $contacto_emergencia);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Datos actualizados correctamente.";
        // Redirigir a la lista de pacientes o a donde prefieras
        header("Location: ver-pacientes.php");
        exit();
    } else {
        echo "Error al actualizar los datos: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Datos no válidos.";
}

$conn->close();
?>