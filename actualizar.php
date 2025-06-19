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
            padding: 10px;
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

        .bodyLoging{
    display: flex;
    justify-content: center; /* Centra horizontalmente */
    align-items: center; /* Centra verticalmente */
    height: 100vh; /* Asegura que el contenedor ocupe toda la altura de la ventana */
    margin: 0; /* Elimina el margen por defecto del body */
}

.divregistro{
    display: flex;
    flex-direction: column;
    align-items: center;
    background-color: rgb(255, 255, 255,0.4);
    border-radius: 40px;
    width: 1500px;
    height: 650px;
    align-items: center;
    display: inline-block;
    box-shadow: 0 88px 88px rgba(0, 0, 0, 0.1); /* Sombra opcional para mejor apariencia */
    margin-top: -300px;
}
.footer-Div{
    background-color: rgba(39, 3, 243, 0.795);
    border-radius: 40px;
    margin: 0px;
    margin-top: -40px;
}
.title-text-loging{
    font-size: 40px;
    font-family: "Sriracha", cursive;
    font-weight: 400;
    font-style: normal;
    color: rgb(255, 255, 255);
    text-align: center;
}
.img-perfil-registro{
    width: 250px;
    height: 270px;
    margin-left: 650px;
    margin-bottom: 20px; /* Espacio opcional debajo de la imagen */
}
.title-text-div{
    font-family: Arial, Helvetica, sans-serif;
    font-size: 30px;
    font-style: normal;
    color: white;
    margin-left: 50px;
}
input{
    width: 300px ;
    height: 20px ;
    font-size: 25px;
}
.btn-div-registro{
    background-color: rgba(254, 70, 70, 1);
    border-radius: 8px;
    font-style: normal;
    color: white;
    font-size: 18px;
    padding: 20px;
    width: 200px;
    margin-left: 700px;
    margin-top: 30px;
    text-align: center; /* Centra el texto horizontalmente */
    display: flex; /* Usa flexbox para centrar verticalmente */
    justify-content: center; /* Centra el contenido horizontalmente */
    align-items: center; /* Centra el contenido verticalmente */
    font-size: 20px;
    align-content: center;
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
        <th>Acciones</th> <!-- Nueva columna para acciones -->
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
            <td>
                <form action="actualizar2.php" method="POST">
                    <input type="hidden" name="id_paciente" value="<?php echo $paciente['id_paciente']; ?>">
                    <button type="submit">Actualizar</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>


</body>
</html>