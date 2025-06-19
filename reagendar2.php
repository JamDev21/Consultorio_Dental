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
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $tipo_tratamiento = $_POST['tipo_tratamiento'];
    $estado = $_POST['estado'];
   

    // Preparar la llamada a la función
    $sql = "SELECT actualizar_cita(?, ?, ?, ?, ?) AS resultado";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $id_paciente, $fecha, $hora, $tipo_tratamiento, $estado);

    // Ejecutar la consulta
    if ($stmt->execute()) {
        $result = $stmt->get_result(); // Obtener el resultado de la función
        $row = $result->fetch_assoc(); // Obtener la fila del resultado

        if ($row['resultado']) {
            echo "Cita actualizada correctamente.";
            // Redirigir o realizar otra acción
            header("Location: reagendar_cita_doctor.php");
        } else {
            echo "No se pudo actualizar la cita o no se encontró el paciente.";
        }
    } else {
        echo "Error al llamar a la función: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>