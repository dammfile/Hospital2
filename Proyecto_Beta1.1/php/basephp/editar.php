<?php
$host = 'localhost';          
$database = 'dammfile';      
$user = 'root';         
$password = '';  

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cedula = $_POST['cedula'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $genero = $_POST['genero'];
    $fecnac = $_POST['fecnac'];

    $sqlUpdate = "UPDATE persona
                  SET nombre = '$nombre', apellido = '$apellido', genero = '$genero', fecnac = '$fecnac' 
                  WHERE numCedula = '$cedula'"; 

    if (mysqli_query($conn, $sqlUpdate)) {
        header("Location: ../personas.php"); // Función para redirigir hacia personas.php una vez el usuario ha sido registrado
        exit();
    } else {
        echo "Error al actualizar los datos: " . mysqli_error($conn);
    }
}

$conn->close();
?>
