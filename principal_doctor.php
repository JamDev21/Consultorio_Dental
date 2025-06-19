<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();

if (!isset($_SESSION['personal_id'])) {
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Principal</title>
</head>
<style>
    /* Estilos para el menu */
    .galeria {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    grid-gap: 20px;
    margin: 80px auto; /* Centra el div horizontalmente */
    width: fit-content; /* Ajusta el ancho al contenido */
}
.galeria2{
    display: grid;
    margin: 80px auto; /* Centra el div horizontalmente */
    width: fit-content; /* Ajusta el ancho al contenido */
}
.imgcarros {
    width: 450px;
    height: 325px;
    border-radius: 20px;
}
.carroIndividual {
    width: 1400px;
    height: 400px;
    border-radius: 20px;
    margin: -50px;
}

.imgcarros:hover {
    width: 550px;
    height: 425px;
    border-radius: 20px;
}

.carroIndividual:hover {
    width: 1500px;
    height: 500px;
    border-radius: 20px;
    margin: -50px;
}
    /* -------------------------- */
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

        footer{
            margin-top: 200px;
        }

        .logo {
            width: 200px;
            height: 100px;
            margin-left: 150px;
            margin-right: 1000px;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: rgba(47, 142, 229, 1);
            margin: 0;
            padding: 0;
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
</style>
<script>
        // Esta función se ejecutará cuando se haga clic en el botón
        function mostrarAlerta() {
            alert("¡Está función no esta disponible para ti!");
        }
    </script>
<body>
    <header>
    <div class="header-container">
        <img class="logo" src="img/logoDental.png" alt="logo clinica">
        <h1>Bienvenid@, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h1>
        <div class="nav-links">
            <a href="logout.php" class="logout-btn">Cerrar sesión</a>
        </div>
    </div>
    </header>
    <main>
    <div class = "galeria">
    <?php if ($_SESSION['cargo'] === 'doctor' || $_SESSION['cargo'] === 'administrador'|| $_SESSION['cargo'] === 'asistente'|| $_SESSION['cargo'] === 'enfermero'): ?>

        <div>
            <a href="ver-pacientes.php">
                <img class="imgcarros"  src="img\Ver.png" alt="Ver">
            </a>
        </div>
        <?php else: ?>
            <div>
            <a onclick="mostrarAlerta()">
                <img class="imgcarros"  src="img\Ver.png" alt="Ver">
            </a>
        </div>
        <?php endif; ?>
        <div>
            <img class="imgcarros" src="img\cirujano.webp" alt="cirujano">
        </div>
        
        <?php if ($_SESSION['cargo'] === 'doctor' || $_SESSION['cargo'] === 'administrador'|| $_SESSION['cargo'] === 'asistente'|| $_SESSION['cargo'] === 'enfermero'): ?>
            <div>
            <a href="agendar_cita_doctor.php">
                <img class="imgcarros" src="img\agendar_cita.png" alt="Agendar cita">
            </a>
            </div>
        <?php else: ?>
            <div>
            <a onclick="mostrarAlerta()">
                <img class="imgcarros" src="img\agendar_cita.png" alt="Agendar cita">
            </a>
            </div>
        <?php endif; ?>
        
        <div>
            <img class="imgcarros" src="img\buen-dentista.jpg" alt="Ferrari">
        </div>
        <?php if ($_SESSION['cargo'] === 'doctor' || $_SESSION['cargo'] === 'administrador'|| $_SESSION['cargo'] === 'asistente'|| $_SESSION['cargo'] === 'enfermero'): ?>
        <div>
            <a href="reagendar_cita_doctor.php">
                <img class="imgcarros" src="img\reagendar_cita.png" alt="reagendar_cita">
            </a>
        </div>
        <?php else: ?>
            <div>
            <a  onclick="mostrarAlerta()">
                <img class="imgcarros" src="img\reagendar_cita.png" alt="reagendar_cita">
            </a>
        </div>
        <?php endif; ?>
        <div>
            <img class="imgcarros" src="img\Dental.jpg" alt="Bmw">
        </div>
    </div>
    <div class="galeria2">
        <div>
            <img class="carroIndividual" src="img\dentista_ultimo.png" alt="Lotus">
        </div>
    </div>
    </main>
    
</body>
</html>