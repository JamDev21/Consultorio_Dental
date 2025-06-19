<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php'; // Incluir el archivo de conexión a la base de datos
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Obtener los datos del formulario
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consulta para verificar las credenciales del usuario
    $sql = "SELECT id, nombre, cargo, contraseña FROM personal WHERE usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Obtener el hash de la contraseña
        $row = $result->fetch_assoc();
        $hashed_password = $row['contraseña'];

        // Verificar la contraseña ingresada con el hash almacenado
        if (password_verify($password, $hashed_password)) {
            // Inicio de sesión exitoso
            $_SESSION['personal_id'] = $row['id'];
            $_SESSION['nombre'] = $row['nombre'];
            $_SESSION['cargo'] = $row['cargo'];
            echo "Login exitoso. Bienvenido!";
            // Redirigir al usuario a otra página
            header("Location: principal_doctor.php");
            exit();
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado
        echo "usuario no encontrado.";
    }

    $stmt->close();
}

$conn->close();
?>