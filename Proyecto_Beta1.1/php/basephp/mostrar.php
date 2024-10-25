<?php
require 'conexion.php';

$query = "SELECT numCedula, nombre, apellido, genero, fecnac FROM persona"; 
$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error en la consulta: " . mysqli_error($conn); 
}
?>

