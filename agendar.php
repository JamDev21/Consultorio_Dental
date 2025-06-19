<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php'; // Incluir el archivo de conexión a la base de datos

// Verificar si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_paciente = $_POST['id_paciente'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $tipo_tratamiento = $_POST['tipo_tratamiento'];
    $estado = $_POST['estado'];
    

    // Preparar y vincular
    $stmt = $conn->prepare("INSERT INTO citas (id_paciente, fecha, hora, tipo_tratamiento, estado) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $id_paciente, $fecha, $hora, $tipo_tratamiento, $estado);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Nuevo cita registrada exitosamente";
    // Redirigir al usuario a otra página
    header("Location: agendar_cita_doctor.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Cerrar la declaración y la conexión
    $stmt->close();
    $conn->close();
}
?>
