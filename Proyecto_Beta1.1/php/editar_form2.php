<?php
require 'basephp/conexion.php'; 

// Verificar si se se ha enviado la cedula
if (isset($_GET['cedula'])) {
    $numCedula = $_GET['cedula'];

    // Consulta para obtener los datos
    $sql = "SELECT 
                Pasaje.Persona_numCedula, Persona.nombre, Persona.apellido, formulario.motivo, Pasaje.cantidad, Pasaje.origen, 
                Pasaje.destino, formulario.anotaciones, Pasaje.fecha, formulario.agencia, formulario.comision,formulario.hospital,
                Paciente.atencionMedica, Acompañante.id_acomp, Acompañante.nombrea, Acompañante.apellidoa, Acompañante.acomp,
                Acompañante.razonAcomp 
            FROM Pasaje 
            JOIN formulario ON Pasaje.Persona_numCedula = formulario.Persona_numCedula
            JOIN Persona ON Pasaje.Persona_numCedula = Persona.numCedula
            LEFT JOIN Paciente ON Pasaje.Persona_numCedula = Paciente.Persona_numCedula
            LEFT JOIN Acompañante ON Pasaje.Persona_numCedula = Acompañante.Persona_numCedula
            WHERE Pasaje.Persona_numCedula = '$numCedula'";

    $result = mysqli_query($conn, $sql);
    
    // Veridica si hay resultados.
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $acomp = $row['acomp'];
        $comi = $row['comision'];
    } else {
        echo "No se encontraron datos.";
        exit;
    }
} else {
    echo "Error: Cédula no definida.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form.css">
    <title>Actualizar Informe</title>
</head>
<body>
<header>
    <h1>Actualizar Informe</h1>
</header>
<div class="formulario">
    <form action="basephp/editarform2.php" method="post">
        <!-- Información del Usuario -->
        <legend><b>Información del Paciente </b></legend>
        <div class="user-info">
            <div class="organ">
                <label for="cedula">Cédula:</label>
                <input type="number" id="cedula" name="cedula" value="<?php echo $row['Persona_numCedula']; ?>" readonly>

                <label for="apellido">Apellido:</label>
                <input type="text" id="apellido" name="apellido" value="<?php echo $row['apellido']; ?>" readonly>

                <div class="checkbox-container">
                    <label for="comi">Comision</label>
                    <input type="checkbox" name="comi" id="comi" vaule="<?php echo ($acomp == 1) ? 'checked' : ''; ?>">
                </div>
            </div>

            <div class="organ">

                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" readonly>

                <label for="atm">Atención Médica:</label>
                <input type="text" id="atm" name="atm" value="<?php echo $row['atencionMedica']; ?>" required>

                <label for="cant">Cantidad de pasajes:</label>
                <input type="number" id="cant" name="cant" value="<?php echo $row['cantidad']; ?>">
            </div>
        </div>

        <!-- Acompañante -->
        <legend><b>Acompañante</b></legend>
        <div class="acomp-info">
            <div class="organ">
                <label for="cedulaa">Cédula:</label>
                <input type="text" id="cedulaa" name="cedulaa" value="<?php echo $row['id_acomp']; ?>">

                <label for="apellidoa">Apellido:</label>
                <input type="text" id="apellidoa" name="apellidoa" value="<?php echo $row['apellidoa']; ?>" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+" title="Solo se permiten letras y espacios">
                <div class="checkbox-container">
                    <label for="acomp">Acompañante</label>
                    <input type="checkbox" name="acomp" id="acomp" <?php echo ($acomp == 1) ? 'checked' : ''; ?>>
                </div>
            </div>
            
            <div class="organ">
                <label for="nombrea">Nombre:</label>
                <input type="text" id="nombrea" name="nombrea" value="<?php echo $row['nombrea']; ?>" pattern="[A-Za-zÁÉÍÓÚáéíóúñÑ ]+" title="Solo se permiten letras y espacios">
                
                <label for="razon">Anotaciones:</label>
                <textarea id="razon" name="razon" rows="4"><?php echo $row['razonAcomp']; ?></textarea>
            </div>
        </div>

        <!-- Información del Viaje -->
        <legend><b>Información del Viaje</b></legend>
        <div class="viaje-info">
            <div class="organ">
                <label for="origen">Origen:</label>
                <input type="text" id="origen" name="origen" value="<?php echo $row['origen']; ?>" required>

                <label for="destino">Destino:</label>
                <input type="text" id="destino" name="destino" value="<?php echo $row['destino']; ?>" required>
            </div>

            <div class="organ">
                <label for="fecha">Fecha de Viaje:</label>
                <input type="date" id="fecha" name="fecha" value="<?php echo $row['fecha']; ?>" required>

                <label for="agencia">Agencia:</label>
                <input type="text" id="agencia" name="agencia" value="<?php echo $row['agencia']; ?>" required>

                <label for="hospitales">Hospital:</label>
                <select name="hospitales" id="hospitales" required>
                    <option value="<?php echo $row['hospital']?>"><?php echo "Actual: ".$row['hospital']?></option>
                    <option value="Fiacre">Fiacre</option>
                    <option value="Rivera">Rivera</option>
                    <option value="Montevideo">Montevideo</option>
                    <option value="Salto">Salto</option>
                </select>
            </div>
        </div>

        <div class="btn-container">
            <input type="submit" class="btn" value="Actualizar">
        </div>
    </form>
</div>
<a href="registros.php" class="backbtn">Atrás</a>
</body>
</html>
