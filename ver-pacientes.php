<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'db_connect.php'; // Incluir el archivo de conexión a la base de datos
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['personal_id'])) {
    header("Location: ingresar.html");
    exit();
}

// Consulta para obtener todos los pacientes
$sql = "SELECT * FROM pacientes";
$result = $conn->query($sql);

// Verificar si se obtuvieron resultados
if ($result->num_rows > 0) {
    // Guardar los pacientes en un array
    $pacientes = [];
    while ($row = $result->fetch_assoc()) {
        $pacientes[] = $row;
    }
} else {
    $pacientes = [];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pacientes</title>
    <style>
        
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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

        .div-buttons{
            display: flex;
            justify-content: center;
            margin-top: 20px;
            background-color: rgba(109, 179, 243, 1);
            border-radius: 20px;
            box-shadow: 25px 25px 50px 0 rgba(0, 0, 0, 0.5);
            border: none;
            align-items: center;
            padding: 10px;
            margin:25px
        }

        .div-buttons:hover{
            background-color: rgba(109, 179, 243, 0.5);
            cursor: pointer;
        }

        .img-botones{
            width: 100px;
            height: 100px;
            padding-right: 20px
        }
        .Buttonss{
            display: flex;
            justify-content: center;
        }
    </style>
    <script>
        // Esta función se ejecutará cuando se haga clic en el botón
        function mostrarAlerta() {
            alert("¡Está función no esta disponible para ti!");
        }
    </script>
</head>
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

<h1>Lista de Pacientes</h1>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Correo</th>
        <th>Teléfono</th>
        <th>Fecha de Nacimiento</th>
        <th>Sexo</th>
        <th>Contacto de emergencia</th>
    </tr>
    <?php foreach ($pacientes as $paciente): ?>
        <tr>
            <td><?php echo $paciente['id_paciente']; ?></td>
            <td><?php echo htmlspecialchars($paciente['nombre']); ?></td>
            <td><?php echo htmlspecialchars($paciente['apellidos']); ?></td>
            <td><?php echo htmlspecialchars($paciente['correo']); ?></td>
            <td><?php echo htmlspecialchars($paciente['telefono']); ?></td>
            <td><?php echo htmlspecialchars($paciente['fecha_nacimiento']); ?></td>
            <td><?php echo htmlspecialchars($paciente['sexo']); ?></td>
            <td><?php echo htmlspecialchars($paciente['contacto_emergencia']); ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<?php if ($_SESSION['cargo'] === 'doctor' || $_SESSION['cargo'] === 'administrador'): ?>
    <section class ="Buttonss">
        <a href="resgistrar_desde_personal.html">
            <button class="div-buttons">
            <img class="img-botones" src="img\crear.png" alt="Crear usuario">
            <h2>Crear</h2>
        </button>
        </a>
        <a href="actualizar.php">
            <button class="div-buttons">
                <img class="img-botones" src="img\actualizar.png" alt="Actualizar usuario">
                <h2>Actualizar</h2>
            </button>
        </a>
       <a href="eliminar.php">
            <button class="div-buttons">
                    <img class="img-botones" src="img\eliminar.png" alt="Eliminar usuario">
                    <h2>Eliminar</h2>
            </button>
       </a>
   
</section>
<?php elseif ($_SESSION['cargo'] === 'enfermero' || $_SESSION['cargo'] === 'asistente'): ?>
    <section class ="Buttonss">

        <a href="resgistrar_desde_personal.html">
            <button class="div-buttons">
            <img class="img-botones" src="img\crear.png" alt="Crear usuario">
            <h2>Crear</h2>
        </button>
        </a>

        <a href="actualizar.php">
            <button class="div-buttons">
                <img class="img-botones" src="img\actualizar.png" alt="Actualizar usuario">
                <h2>Actualizar</h2>
            </button>
        </a>
        
       
            <button onclick="mostrarAlerta()" class="div-buttons">
                    <img class="img-botones" src="img\eliminar.png" alt="Eliminar usuario">
                    <h2>Eliminar</h2>
            </button>
       
   
</section>

<?php else: ?>
    <section class ="Buttonss">

            <button onclick="mostrarAlerta()" class="div-buttons">
            <img class="img-botones" src="img\crear.png" alt="Crear usuario">
            <h2>Crear</h2>
        </button>
        
        
            <button onclick="mostrarAlerta()" class="div-buttons">
                <img class="img-botones" src="img\actualizar.png" alt="Actualizar usuario">
                <h2>Actualizar</h2>
            </button>
        
       
            <button onclick="mostrarAlerta()" class="div-buttons">
                    <img class="img-botones" src="img\eliminar.png" alt="Eliminar usuario">
                    <h2>Eliminar</h2>
            </button>
       
   
</section>
<?php endif; ?>


</body>
</html>