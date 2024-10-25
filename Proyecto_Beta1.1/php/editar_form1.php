<?php
// Datos de conexión
$host = 'localhost';          
$database = 'dammfile';      
$user = 'root';         
$password = '';  

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Comprobar si hay una cedula enviada
if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];

    // Consulta para obtener los datos del pasaje y formulario relacionados con la cédula
    $sql = "SELECT Pasaje.Persona_numCedula, Persona.nombre, Persona.apellido, 
                   formulario.motivo, Pasaje.cantidad, 
                   Pasaje.origen, Pasaje.destino, formulario.anotaciones, 
                   Pasaje.fecha, formulario.agencia 
            FROM Pasaje 
            JOIN formulario ON Pasaje.Persona_numCedula = formulario.Persona_numCedula
            JOIN Persona ON Pasaje.Persona_numCedula = Persona.numCedula
            WHERE Pasaje.Persona_numCedula = '$cedula'"; 
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error en la consulta: " . mysqli_error($conn);
        exit();
    }

    $usuario = mysqli_fetch_assoc($result);

    if (!$usuario) {
        echo "Usuario no encontrado.";
        exit();
    }
} else {
    echo "No se recibió ninguna cédula.";
    exit();
}

$conn->close(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form2.css">
    <title>Actualizar Informe</title>
</head>
<body>
<header>
    <h1>Actualizar Informe</h1>
</header>

<div class="formulario">
    <form action="basephp/editarform1.php" method="POST">
        <input type="hidden" name="cedula" value="<?php echo $usuario['Persona_numCedula']; ?>">
        
        <legend><b>Información del Usuario</b></legend>
        <div class="user-info">
            <div class="organ">
                <label for="cedula">Cédula:</label>
                <input type="number" id="cedula" name="cedula" value="<?php echo $usuario['Persona_numCedula']; ?>" readonly>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo $usuario['apellido']; ?>" readonly>

            </div>

            <div class="organ">
                
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $usuario['nombre']; ?>" readonly>

                <label for="motivo">Motivo:</label>
                <select name="motivo" id="motivo">
                    <option value="<?php echo $usuario['motivo']; ?>" selected><?php echo "Actual: " .$usuario['motivo'];?></option>
                    <option value="Tramite">Trámite</option>
                    <option value="Policlinica">Policlínica</option>
                    <option value="Guardia">Guardia</option>
                    <option value="Capacitación">Capacitación</option>
                </select>

                <label for="cant">Cantidad de pasajes:</label>
                <input type="number" name="cant" id="cant" value="<?php echo $usuario['cantidad']; ?>" required>
            </div>
        </div>

        <!-- Información del Viaje -->
        <legend><b>Información del Viaje</b></legend>
        <div class="viaje-info">
            <div class="organ">
                <label for="origen">Origen:</label>
                <input type="text" id="origen" name="origen" value="<?php echo $usuario['origen']; ?>" required>

                <label for="destino">Destino:</label>
                <input type="text" id="destino" name="destino" value="<?php echo $usuario['destino']; ?>" required>

                <label for="anot">Anotaciones:</label>
                <textarea id="anot" name="anot" rows="4" required><?php echo $usuario['anotaciones']; ?></textarea>
            </div>

            <div class="organ">
                <label for="fecha">Fecha de Viaje:</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo $usuario['fecha']; ?>" required>

                <label for="agencia">Agencia:</label>
                <input type="text" id="agencia" name="agencia" value="<?php echo $usuario['agencia']; ?>" required>
            </div>
        </div>

        <button type="submit" class="btn">Actualizar</button>
    </form>
    <a href="registros.php" class="backbtn">Atrás</a>
</div>
</body>
</html>
