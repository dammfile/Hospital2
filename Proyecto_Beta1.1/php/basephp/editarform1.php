<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST["cedula"];
    $motivo = $_POST["motivo"];
    $cant = $_POST["cant"];
    $origen = $_POST["origen"];
    $destino = $_POST["destino"];
    $anotaciones = $_POST["anot"];
    $fecviaje = $_POST["fecha"];
    $agencia = $_POST["agencia"];
    $fecha_edicion = date('Y-m-d H:i:s');

    if (empty($cedula) || empty($origen) || empty($destino) || empty($fecviaje) || empty($anotaciones)) {
        echo "<p>Todos los campos son obligatorios.</p>";
        exit();
    }

    $sql_pasaje = "UPDATE Pasaje 
                   SET origen = '$origen', destino = '$destino', fecha = '$fecviaje', cantidad = '$cant' 
                   WHERE Persona_numCedula = '$cedula'";

    if ($conn->query($sql_pasaje) !== TRUE) {
        echo "Error al actualizar en Pasaje: " . $conn->error;
        exit();
    }

    $sql_formulario = "UPDATE formulario 
                       SET motivo = '$motivo', anotaciones = '$anotaciones', agencia = '$agencia', ultimaEdicion='$fecha_edicion' 
                       WHERE Persona_numCedula = '$cedula'";

    if ($conn->query($sql_formulario) !== TRUE) {
        echo "Error al actualizar en formulario: " . $conn->error;
        exit();
    }

    header("Location: ../registros.php");
    exit(); 
}

$conn->close();
