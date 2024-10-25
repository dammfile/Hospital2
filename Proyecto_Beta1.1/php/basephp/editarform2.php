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
    $fecha_edicion = date('Y-m-d H:i:s');

    // Acompañante
    $cedulaa = $_POST["cedulaa"];
    $nombrea = $_POST["nombrea"];
    $apellidoa = $_POST["apellidoa"];
    $razon = $_POST["razon"];
    $acomp = isset($_POST['acomp']) ? 1 : 0;

    // Viaje
    $origen = $_POST["origen"];
    $destino = $_POST["destino"];
    $anotaciones = $_POST["razon"];
    $fecviaje = $_POST["fecha"];
    $agencia = $_POST["agencia"];
    $hospital = $_POST["hospitales"];

    if (empty($cedula) || empty($origen) || empty($destino) || empty($fecviaje) || empty($anotaciones)) {
        echo "<p>Todos los campos obligatorios deben estar llenos.</p>";
        exit();
    }

    $sql_pasaje = "UPDATE Pasaje 
                   SET origen='$origen', destino='$destino', fecha='$fecviaje', cantidad='$cant' 
                   WHERE Persona_numCedula='$cedula'";
    if (!$conn->query($sql_pasaje)) {
        echo "Error al actualizar Pasaje: " . $conn->error;
        exit();
    }

    $sql_formulario = "UPDATE formulario 
                       SET anotaciones='$anotaciones', motivo='$atm', hospital='$hospital', agencia='$agencia', comision='$comision', ultimaEdicion='$fecha_edicion' 
                       WHERE Persona_numCedula='$cedula'";
    if (!$conn->query($sql_formulario)) {
        echo "Error al actualizar Formulario: " . $conn->error;
        exit();
    }

    if ($acomp == 1) {
        $sql_acompanante = "UPDATE Acompañante 
                            SET nombrea='$nombrea', apellidoa='$apellidoa', razonAcomp='$razon', acomp='$acomp' 
                            WHERE Persona_numCedula='$cedula'";
        if (!$conn->query($sql_acompanante)) {
            echo "Error al actualizar Acompañante: " . $conn->error;
            exit();
        }
    }

    $sql_paciente = "UPDATE Paciente 
                     SET atencionMedica='$atm' 
                     WHERE Persona_numCedula='$cedula'";
    if (!$conn->query($sql_paciente)) {
        echo "Error al actualizar Paciente: " . $conn->error;
        exit();
    }

    header("Location: ../registros.php");
    exit();
}

$conn->close();
?>
