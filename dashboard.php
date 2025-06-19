<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php'; // Incluir el archivo de conexión a la base de datos
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header("Location: index.html");
    exit();
}

// Obtener el id_paciente de la sesión
$id_paciente = $_SESSION['usuario_id'];

// Consulta para obtener citas futuras (pendientes)
$stmt_futuras = $conn->prepare("SELECT * FROM citas WHERE id_paciente = ? AND estado = 'Pendiente' AND fecha >= CURDATE() ORDER BY fecha, hora");
$stmt_futuras->bind_param("i", $id_paciente);
$stmt_futuras->execute();
$result_futuras = $stmt_futuras->get_result();

// Consulta para obtener citas pasadas
$stmt_pasadas = $conn->prepare("SELECT * FROM citas WHERE id_paciente = ? AND estado = 'Realizada' AND fecha < CURDATE() ORDER BY fecha DESC");
$stmt_pasadas->bind_param("i", $id_paciente);
$stmt_pasadas->execute();
$result_pasadas = $stmt_pasadas->get_result();

// Cerrar las declaraciones
$stmt_futuras->close();
$stmt_pasadas->close();
$conn->close();

// Contar el número de citas
$num_futuras = $result_futuras->num_rows;
$num_pasadas = $result_pasadas->num_rows;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard del Paciente</title>
    <style>
        /* Estilos existentes... */
        body {
            font-family: Arial, sans-serif;
            background-color: rgba(47, 142, 229, 1);
            margin: 0;
            padding: 0;
        }

        .logo {
            width: 200px;
            height: 100px;
            margin-left: 150px;
            margin-right: 1000px;
        }

        .header-container {
            background-color: rgba(109, 179, 243, 1);
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            text-align: center;
            border-radius: 64px;
        }

        .header-container h1 {
            margin: 0;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 20px;
            font-weight: bold;
            margin-left: 800px;
        }

        .dashboard-container {
            display: flex;
            justify-content: center;
            justify-content: space-around;
            padding: 20px;
            margin-top: 20px;
        }

        .section {
            background-color: rgba(255, 255, 255, 20);
            box-shadow: 0 20px 20px rgba(25, 0, 0, 1); /* Sombra */
            border-radius: 8px;
            width: 700px;
            padding: 20px;
        }

        p {
            font-size: 40px;
        }

        .h1-tiyulo {
            font-size: 60px;
            text-align: center;
        }

        .section h2 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .list-items {
            list-style-type: none;
            padding: 0;
        }

        .list-item {
            border-bottom: 1px solid #eee;
            padding: 10px 0;
        }

        .list-item p {
            margin: 5px 0;
        }

        .list-item p strong {
            font-weight: bold;
        }

        .list-item:last-child {
            border-bottom: none;
        }

        .logout-btn {
            background-color: #ff0000;
            padding: 10px 20px;
            color: white;
            text-decoration: none;
            border-radius: 30px;
            margin-top: 10px;
        }

        .logout-btn:hover {
            background-color: #d10000;
        }

         /* Estilos para los botones de contacto */
         .contact-buttons {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .contact-button {
            background-color: #25D366; /* Color de WhatsApp */
            color: white;
            padding: 15px 25px;
            border-radius: 30px;
            text-decoration: none;
            margin: 0 10px;
            font-size: 18px;
            transition: background-color 0.3s;
        }

        .contact-button.phone {
            background-color: #007BFF; /* Color de llamada */
        }

        .contact-button.help {
            background-color: #FF9800; /* Color de ayuda */
        }

        .contact-button:hover {
            opacity: 0.9;
        }

        footer{
            margin-top: 200px;
        }
    </style>
</head>
<body>
    
    <div class="header-container">
        <img class="logo" src="img/logoDental.png" alt="logo clinica">
        <h1>Bienvenid@, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h1>
        <div class="nav-links">
            <a href="logout.php" class="logout-btn">Cerrar sesión</a>
        </div>
    </div>

    <div class="dashboard-container">
        <section class="section citas-futuras">
            <h1 class="h1-tiyulo">Próximas citas  (<?php echo $num_futuras; ?>)</h1>
            <?php if ($num_futuras > 0): ?>
                <ul class="list-items">
                    <?php while ($cita = $result_futuras->fetch_assoc()): ?>
                        <li class="list-item">
                            <p><strong>Fecha:</strong> <?php echo $cita['fecha']; ?></p>
                            <p><strong>Hora:</strong> <?php echo $cita['hora']; ?></p>
                            <p><strong>Tratamiento:</strong> <?php echo $cita['tipo_tratamiento']; ?></p>
                            <p><strong>Estado:</strong> <?php echo $cita['estado']; ?></p>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No tienes citas futuras.</p>
            <?php endif; ?>
        </section>

        <section class="section citas-pasadas">
            <h1 class="h1-tiyulo">Citas Anteriores (<?php echo $num_pasadas; ?>)</h1>
            <?php if ($num_pasadas > 0): ?>
                <ul class="list-items">
                    <?php while ($cita = $result_pasadas->fetch_assoc()): ?>
                        <li class="list-item">
                            <p><strong>Fecha:</strong> <?php echo $cita['fecha']; ?></p>
                            <p><strong>Hora:</strong> <?php echo $cita['hora']; ?></p>
                            <p><strong>Tratamiento:</strong> <?php echo $cita['tipo_tratamiento']; ?></p>
                            <p><strong>Estado:</strong> <?php echo $cita['estado']; ?></p>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p>No tienes citas pasadas.</p>
            <?php endif; ?>
        </section>
    </div>
    <footer>
    <div class="contact-buttons">
        <a href="https://wa.me/5615045665" class="contact-button" target="_blank">WhatsApp</a> <!-- Reemplaza con tu número -->
        <a href="tel:+525615045665" class="contact-button phone">Llamar</a> <!-- Reemplaza con tu número -->
        <a href="mailto:angelez.jona88@gmail.com" class="contact-button help">Ayuda</a> <!-- Reemplaza con tu email -->
    </div>
    </footer>

</body>
</html>