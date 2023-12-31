<?php include("../models/db.php") ?>
<?php
if (isset($_POST['agregar_apoderado'])) {
    $rut = mysqli_real_escape_string($conexion, $_POST['rut']);
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellidoP = mysqli_real_escape_string($conexion, $_POST['apellidoP']);
    $apellidoM = mysqli_real_escape_string($conexion, $_POST['apellidoM']);
    $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
    $fechaNacimiento = $_POST['fechaNacimiento'];
    $telefono = $_POST['telefono'];
    $idCargo = $_POST['idCargo'];
    $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);

    // Insertar los datos del apoderado en la base de datos
    $insertQuery = "INSERT INTO apoderado (rut, nombre, apellidoP, apellidoM, correo, fechaNacimiento, telefono, idCargo, direccion) VALUES ('$rut', '$nombre', '$apellidoP', '$apellidoM', '$correo', '$fechaNacimiento', '$telefono', '$idCargo', '$direccion')";

    if (mysqli_query($conexion, $insertQuery)) {
        header("Location: ../models/apoderadosModels/vistaApoderados.php");
        exit();
    } else {
        echo "Error al agregar el apoderado: " . mysqli_error($conexion);
    }
}

mysqli_close($conexion);
?>

<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
    <title>Agregar Apoderado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Agregar Apoderado</h1>
                <form method="POST" action="" onsubmit="return validarFormularioApoderado();">
                    <label for="rut">RUT:</label>
                    <input type="text" name="rut" class="form-control" id="rut" required><br>

                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" required><br>

                    <label for="apellidoP">Apellido Paterno:</label>
                    <input type="text" name="apellidoP" class="form-control" id="apellidoP" required><br>

                    <label for="apellidoM">Apellido Materno:</label>
                    <input type="text" name="apellidoM" class="form-control" id="apellidoM" required><br>

                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" name="correo" class="form-control" id="correo" required><br>

                    <label for="fechaNacimiento">Fecha de Nacimiento:</label>
                    <input type="date" name="fechaNacimiento" class="form-control" id="fechaNacimiento" required><br>

                    <label for="telefono">Teléfono:</label>
                    <input type="tel" name="telefono" class="form-control" id="telefono"><br>

                    <input type="hidden" name="idCargo" value="4">

                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" class="form-control" id="direccion" required><br>

                    <input type="submit" name="agregar_apoderado" value="Agregar Apoderado" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
    <script src="../src/javas/seguridad.js"></script>
</body>
</html>
