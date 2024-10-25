<?php
require 'basephp/conexion.php';

$nombre = "";
$apellido = "";
$cedula = ""; 
// el name "buscar" envia "cedula" la cual posteriormente pasará a ser una variable usada para filtrar 
// nombre y apellido y rellenar estos automaticamente al buscar y encontrar una cedula registrada.
if (isset($_POST['buscar'])) {
    $cedula = $_POST['cedula']; 

    $sql = "SELECT nombre, apellido FROM persona WHERE numCedula = '$cedula'";
    $result = mysqli_query($conn, $sql);

    // Si se encuentra la cédula, autocompletar los campos
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $nombre = $row['nombre'];
        $apellido = $row['apellido'];
    } else {
        $error = "No se encontró ninguna persona con esa cédula.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/form2.css">
    <title>Nuevo Informe</title>
</head>
<body>
<header>
    <h1>Nuevo Informe</h1>
</header>

<?php if (isset($error)): ?>
        <p style="color:red; text-align:center;"><?php echo $error; ?></p>
    <?php endif; ?>

    <div class="search">
<form action="" method="post">
        <input type="number" id="cedula" name="cedula" value="<?php echo $cedula; ?>" required placeholder="Buscar cedula">
        <button type="submit" name="buscar" class="btn">Buscar Cédula</button>
        </form>
</div>

<div class="formulario">
    <form action="basephp/form1ins.php" method="post">
        <legend><b>Información del Usuario</b></legend>
        <div class="user-info">
            <div class="organ">
                <label for="nombre">Cedula:*</label>
                <input type="number" id="cedula" name="cedula" value="<?php echo $cedula; ?>" required>

                <label for="apellido">Apellido:*</label>
            <input type="text" id="apellido" name="apellido" value="<?php echo $apellido; ?>" required>

            </div>

            <div class="organ">

            <label for="nombre">Nombre:*</label>
                <input type="text" id="nombre" name="nombre" value="<?php echo $nombre; ?>" required>

                <label for="motivo">Motivo:*</label>
                <select name="motivo" id="motivo" required>
                    <option value="">- Selecciona -</option>
                    <option value="Tramite">Trámite</option>
                    <option value="Policlinica">Policlinica</option>
                    <option value="Guardia">Guardia</option>
                    <option value="Capacitación">Capacitación</option>
                </select>

                <label for="cant">Cantidad de pasajes:*</label>
                <input type="number" name="cant" id="cant" min="0" max="2" required>
            </div>
        </div>

        <!-- Información del Viaje -->
        <legend><b>Información del Viaje</b></legend>
        <div class="viaje-info">
            <div class="organ">
                <label for="origen">Origen:*</label>
                <input type="text" id="origen" name="origen" required>

                <label for="destino">Destino:*</label>
                <input type="text" id="destino" name="destino" required>

                <label for="razon">Anotaciones:</label>
                <textarea id="anot" name="anot" rows="4"></textarea>
            </div>

            <div class="organ">
                <label for="fecha">Fecha de Viaje:*</label>
                <input type="date" id="fecha" name="fecha" required>

                <label for="agencia">Agencia:</label>
                <input type="text" id="agencia" name="agencia" required>
            </div>
        </div>

        <div class="btn-container">
            <input type="submit" class="btn" value="ENVIAR">
        </div>
    </form>
</div>

<a href="../html/menu.html" class="backbtn">Atrás</a>

</body>
</html>
