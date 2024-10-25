<?php
require 'conexion.php'; // Asegúrate de tener este archivo con la conexión

// Verificar si el método de la solicitud es POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['cedula']) && isset($_POST['tipo'])) {
        $numCedula = $_POST['cedula'];
        $tipo = $_POST['tipo'];

        // Redireccionar a una parte u otra en base al tipo de formulario
        if ($tipo === 'General') {
            header("Location: ../editar_form1.php?cedula=" . urlencode($numCedula));
            exit;
        } elseif ($tipo === 'Consulta') {
            header("Location: ../editar_form2.php?cedula=" . urlencode($numCedula));
            exit;
        }
    } else {
        echo "Error: Cedula o tipo no están definidos.";
    }
} else {
    echo "Error: Se esperaba una solicitud POST.";
}
?>
