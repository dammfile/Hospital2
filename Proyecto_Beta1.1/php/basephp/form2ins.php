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
    $atm = $_POST["atm"];
    $cant = $_POST["cant"];
    $comision = isset($_POST['comi']) ? 1 : 0; 
    $fecha_creacion = date('Y-m-d H:i:s');
    $tipoform = "Consulta";
    
    // Acompañante
    $cedulaa = $_POST["cedulaa"]; 
    $nombrea = $_POST["nombrea"];
    $apellidoa = $_POST["apellidoa"];
    $razon = $_POST["razon"];  
    $acomp = isset($_POST['acomp']) ? 1 : 0; 
    
    // Viaje 
    $origen = $_POST["origen"]; 
    $destino = $_POST["destino"];
    $anotaciones = $_POST["anot"];
    $fecviaje = $_POST["fecha"];
    $agencia = $_POST["agencia"];
    $hospital = $_POST["hospitales"];
    
    if (empty($cedula) || empty($origen) || empty($destino) || empty($fecviaje) || empty($anotaciones)) {
        echo "<p>Todos los campos son obligatorios.</p>";
        exit();
    }

    $sql_pasaje = "INSERT INTO Pasaje (Persona_numCedula, origen, destino, fecha, cantidad) 
                   VALUES ('$cedula', '$origen', '$destino', '$fecviaje', '$cant')";
    
    if (!$conn->query($sql_pasaje)) {
        echo "Error al insertar en Pasaje: " . $conn->error;
        exit();
    }

    $sql_formulario = "INSERT INTO formulario (Persona_numCedula, anotaciones, fechaCreacion, motivo, hospital, agencia, tipo, comision) 
                       VALUES ('$cedula', '$anotaciones', '$fecha_creacion', '$atm', '$hospital', '$agencia', '$tipoform', '$comision')";

    if (!$conn->query($sql_formulario)) {
        echo "Error al insertar en Formulario: " . $conn->error;
        exit();
    }

  // Insertar en la tabla Acompañante solo si acomp es igual a 1
    if ($acomp == 1) {
        $sql_acompanante = "INSERT INTO Acompañante (id_acomp, nombrea, apellidoa, razonAcomp, acomp, Persona_numCedula) 
                            VALUES ('$cedulaa', '$nombrea', '$apellidoa', '$razon', '$acomp', '$cedula')";

        if (!$conn->query($sql_acompanante)) {
            echo "Error al insertar en Acompañante: " . $conn->error;
            exit();
        }
    }

    $sql_paciente = "INSERT INTO Paciente (Persona_numCedula, atencionMedica) 
                     VALUES ('$cedula', '$atm')";

    if (!$conn->query($sql_paciente)) {
        echo "Error al insertar en Paciente: " . $conn->error;
        exit();
    }

    header("Location: ../registros.php");
    exit(); 
}

$conn->close();
?>
