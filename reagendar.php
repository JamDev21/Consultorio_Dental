<?php
include 'db_connect.php';
session_start();

if (!isset($_SESSION['personal_id'])) {
    header("Location: ingresar.html");
    exit();
}

// Verificar si se ha enviado el ID del paciente
if (isset($_POST['id_paciente'])) {
    $id_paciente = $_POST['id_paciente'];

    // Consulta para obtener los datos del paciente
    $sql = "SELECT * FROM citas WHERE id_paciente = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_paciente);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $cita = $result->fetch_assoc();
    } else {
        // Manejar el caso donde no se encuentra el paciente
        echo "Cita no encontrada.";
        exit();
    }
} else {
    echo "ID de paciente no proporcionado.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Paciente</title>
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

<section>
<main class="bodyLoging">
        <div class="divregistro">
            <footer class="footer-Div">
                <p class="title-text-loging">Agendar</p>
            </footer>
            <img class="img-perfil-registro" src="img\registro.png" alt="">
            <form action="reagendar2.php" method="POST">
                <label class="title-text-div" for="id_paciente">Id paciente: </label>
                <input type="text" name="id_paciente" id="id_paciente" value="<?php echo htmlspecialchars($cita['id_paciente']); ?>" required>
                <!-- <input type="id_paciente" name="id_paciente" id="id_paciente" required> -->
                
                <label  class = "title-text-div" for="fecha">Fecha:</label>
                <input type="text" name="fecha" id="fecha" value="<?php echo htmlspecialchars($cita['fecha']); ?>" required>
                <!-- <input type="fecha" name="fecha" id="fecha" required> -->
                
                <label  class = "title-text-div" for="hora">Hora:</label>
                <input type="text" name="hora" id="hora" value="<?php echo htmlspecialchars($cita['hora']); ?>" required>
                <!-- <input type="hora" name="hora" id="hora" required> -->
                <br>
                <label  class = "title-text-div" for="tipo_tratamiento">Tipo de tratamiento:</label>
                <input type="text" name="tipo_tratamiento" id="tipo_tratamiento" value="<?php echo htmlspecialchars($cita['tipo_tratamiento']); ?>" required>
                <!-- <input type="tipo_tratamiento" name="tipo_tratamiento" id="tipo_tratamiento" required> -->
                
                <label  class = "title-text-div" for="estado">Estado:</label>
                <input type="text" name="estado" id="estado" value="<?php echo htmlspecialchars($cita['estado']); ?>" required>
                <!-- <input type="estado" name="estado" id="estado" required> -->
                
                <input class="btn-div-registro" type="submit" value="Continuar">
            </form>
            <br>
            </div>
    </main>
    </main>
</section>

</body>
</html>