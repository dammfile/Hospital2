<?php
$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "dammfile"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Persona 
    $cedula = $_POST["cedula"]; 
    $motivo = $_POST["motivo"]; 
    $cant = $_POST["cant"];
    $fecha_creacion = date('Y-m-d H:i:s');
    $tipoform = "General";
    
    // Viaje 
    $origen = $_POST["origen"]; 
    $destino = $_POST["destino"];
    $anotaciones = $_POST["anot"];
    $fecviaje = $_POST["fecha"];
    $agencia = $_POST["agencia"];
    
    if (empty($cedula) || empty($origen) || empty($destino) || empty($fecviaje) || empty($anotaciones)) {
        echo "<p>Todos los campos son obligatorios.</p>";
        exit();
    }
    
    $sql_pasaje = "INSERT INTO Pasaje (Persona_numCedula, origen, destino, fecha, cantidad) 
                   VALUES ('$cedula', '$origen', '$destino', '$fecviaje', '$cant')";

    if ($conn->query($sql_pasaje) !== TRUE) {
        echo "Error al insertar en Pasaje: " . $conn->error;
        exit();
    }
    
    $sql_formulario = "INSERT INTO formulario (Persona_numCedula, anotaciones, fechaCreacion, motivo, agencia, tipo) 
                       VALUES ('$cedula', '$anotaciones', '$fecha_creacion', '$motivo', '$agencia', '$tipoform')";

    if ($conn->query($sql_formulario) !== TRUE) {
        echo "Error al insertar en formulario: " . $conn->error;
        exit();
    }

    header("Location: ../registros.php");
    exit(); 
}

$conn->close();
?>
