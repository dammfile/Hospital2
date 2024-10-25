<?php
include 'validarcedula.php';

$servername = "localhost"; 
$username = "root";
$password = ""; 
$dbname = "dammfile"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if (isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST["cedula"]; 
    $nombre = $_POST["nombre"]; 
    $apellido = $_POST["apellido"];
    $genero = $_POST["genero"];
    $fecnac = $_POST["fecnac"];
    
    if (empty($cedula) || empty($nombre) || empty($apellido) || empty($genero) || empty($fecnac)) {
        header("Location: ../registropersona.php");
        exit();
    }

    // Validar la cédula llamando a la funcion dentro de validarcedula.php
    if (!validarCedula($cedula)) {
        header("Location: ../registropersona.php");
        exit();
    }
    
    $sql = "INSERT INTO persona (numCedula, nombre, apellido, genero, fecnac) VALUES ('$cedula', '$nombre', '$apellido', '$genero', '$fecnac')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../personas.php"); 
        exit(); 
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
