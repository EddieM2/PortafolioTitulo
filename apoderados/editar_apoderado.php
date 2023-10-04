<?php include("../models/db.php") ?>

<?php
// Verificar si se proporcionó un RUT de apoderado válido en la URL
if (isset($_GET['rut'])) {
    $rut = $_GET['rut'];

    // Validar el formato del RUT (opcional)
 

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    // Consulta para obtener los datos del apoderado
    $query = "SELECT * FROM apoderado WHERE rut = '$rut'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // Procesar el formulario de edición cuando se envíe
        if (isset($_POST['editar_apoderado'])) {
            $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
            $apellidoP = mysqli_real_escape_string($conexion, $_POST['apellidoP']);
            $apellidoM = mysqli_real_escape_string($conexion, $_POST['apellidoM']);
            $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
            $fechaNacimiento = $_POST['fechaNacimiento'];
            $telefono = $_POST['telefono'];
            $idCargo = $_POST['idCargo'];
            $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);

            // Actualizar la información del apoderado en la base de datos
            $updateQuery = "UPDATE apoderado SET
                nombre = '$nombre',
                apellidoP = '$apellidoP',
                apellidoM = '$apellidoM',
                correo = '$correo',
                fechaNacimiento = '$fechaNacimiento',
                telefono = '$telefono',
                idCargo = '$idCargo',
                direccion = '$direccion'
                WHERE rut = '$rut'";

            if (mysqli_query($conexion, $updateQuery)) {
                // Redirigir de vuelta a la lista de apoderados después de la edición
                header("Location: apoderados.php");
                exit();
            } else {
                echo "Error al actualizar el apoderado: " . mysqli_error($conexion);
            }
        }
    } else {
        echo "Apoderado no encontrado.";
    }

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    echo "RUT de apoderado no válido.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Apoderado</title>
</head>
<body>
    <h1>Editar Apoderado</h1>
    <form method="POST" action="">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" required><br>

        <label for="apellidoP">Apellido Paterno:</label>
        <input type="text" name="apellidoP" value="<?php echo htmlspecialchars($row['apellidoP']); ?>" required><br>

        <label for="apellidoM">Apellido Materno:</label>
        <input type="text" name="apellidoM" value="<?php echo htmlspecialchars($row['apellidoM']); ?>" required><br>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" value="<?php echo htmlspecialchars($row['correo']); ?>" required><br>

        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fechaNacimiento" value="<?php echo $row['fechaNacimiento']; ?>" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="tel" name="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>"><br>

        <label for="idCargo">Cargo:</label>
        <input type="number" name="idCargo" value="<?php echo $row['idCargo']; ?>" required><br>

        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" value="<?php echo htmlspecialchars($row['direccion']); ?>" required><br>

        <input type="submit" name="editar_apoderado" value="Guardar Cambios">
    </form>
</body>
</html>
