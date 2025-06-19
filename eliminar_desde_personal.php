<?php
include 'db_connect.php'; // Incluir el archivo de conexión a la base de datos
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['personal_id'])) {
    header("Location: ingresar.html");
    exit();
}

// Manejo de eliminación de paciente
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_paciente'])) {
    $id_paciente = $_POST['id_paciente'];

    // Preparar la llamada al procedimiento almacenado
    $sql = "CALL eliminarPaciente(?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_paciente);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Paciente eliminado correctamente.";
        header("Location: ver-pacientes.php");
    } else {
        echo "Error al eliminar el paciente: " . $stmt->error;
    }

    $stmt->close();
}