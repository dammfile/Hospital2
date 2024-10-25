<?php
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
?>