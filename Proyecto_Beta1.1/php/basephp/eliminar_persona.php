<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dammfile";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_POST['cedula'])) {
    $cedula = $_POST['cedula'];

    if (is_numeric($cedula)) {

        $sqlCheck = "SELECT * FROM persona WHERE numCedula = $cedula"; 
        $result = $conn->query($sqlCheck);

        if ($result && $result->num_rows > 0) {
            $sqlDelete = "DELETE FROM persona WHERE numCedula = $cedula"; 
            if ($conn->query($sqlDelete) === TRUE) {
                header("Location: ../personas.php");
                exit();
            } else {
                echo "Error al eliminar el registro: " . $conn->error;
            }
        } else {
            echo "No se encontró ninguna persona con la cédula proporcionada.";
        }
    } else {
        echo "La cédula debe ser un número válido.";
    }
} else {
    echo "No se proporcionó la cédula.";
}

$conn->close();
?>
