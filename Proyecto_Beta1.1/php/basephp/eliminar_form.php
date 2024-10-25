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
    $cedula = $_POST["cedula"];

    $sql_verificar = "SELECT * FROM Paciente WHERE Persona_numCedula = '$cedula'";
    $resultado = $conn->query($sql_verificar);

    if ($resultado->num_rows > 0) {
        $sql_eliminar_pasaje = "DELETE FROM Pasaje WHERE Persona_numCedula = '$cedula'";
        if (!$conn->query($sql_eliminar_pasaje)) {
            echo "Error al eliminar el pasaje: " . $conn->error;
            exit();
        }

        $sql_eliminar_formulario = "DELETE FROM formulario WHERE Persona_numCedula = '$cedula'";
        if (!$conn->query($sql_eliminar_formulario)) {
            echo "Error al eliminar el formulario: " . $conn->error;
            exit();
        }

        $sql_eliminar_paciente = "DELETE FROM Paciente WHERE Persona_numCedula = '$cedula'";
        if (!$conn->query($sql_eliminar_paciente)) {
            echo "Error al eliminar el paciente: " . $conn->error;
            exit();
        }

        header("Location: ../registros.php");
        exit();  
    } else {
        echo "No se encontró un paciente con la cédula proporcionada.";
    }
}

$conn->close();
?>