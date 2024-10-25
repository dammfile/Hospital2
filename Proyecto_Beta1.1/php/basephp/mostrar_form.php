<?php

require 'conexion.php';

$query = "SELECT id_form, Persona_numCedula, fechaCreacion, ultimaEdicion, 
          nombre, apellido, tipo 
          FROM formulario 
          JOIN persona ON formulario.Persona_numCedula = persona.numCedula";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo "Error en la consulta: " . mysqli_error($conn); 
}

$conn->close();
?>