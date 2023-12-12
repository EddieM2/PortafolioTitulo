<?php include("../models/db.php") ?>
<?php
if (isset($_GET['rut'])) {
    $rut = $_GET['rut'];

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    $query = "SELECT * FROM apoderado WHERE rut = '$rut'";
    $result = mysqli_query($conexion, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (isset($_POST['editar_apoderado'])) {
            $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
            $apellidoP = mysqli_real_escape_string($conexion, $_POST['apellidoP']);
            $apellidoM = mysqli_real_escape_string($conexion, $_POST['apellidoM']);
            $correo = mysqli_real_escape_string($conexion, $_POST['correo']);
            $fechaNacimiento = $_POST['fechaNacimiento'];
            $telefono = $_POST['telefono'];
            $idCargo = $_POST['idCargo'];
            $direccion = mysqli_real_escape_string($conexion, $_POST['direccion']);
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
                header("Location: ../models/apoderadosModels/vistaApoderados.php");
                exit();
            } else {
                echo "Error al actualizar el apoderado: " . mysqli_error($conexion);
            }
        }
    } else {
        echo "Apoderado no encontrado.";
    }

    mysqli_close($conexion);
} else {
    echo "RUT de apoderado no válido.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Apoderado</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css">
    <meta charset="UTF-8">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Editar Apoderado</h1>
                <form method="POST" action="">
                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" class="form-control" required><br>

                    <label for="apellidoP">Apellido Paterno:</label>
                    <input type="text" name="apellidoP" value="<?php echo htmlspecialchars($row['apellidoP']); ?>" class="form-control" required><br>

                    <label for="apellidoM">Apellido Materno:</label>
                    <input type="text" name="apellidoM" value="<?php echo htmlspecialchars($row['apellidoM']); ?>" class="form-control" required><br>

                    <label for="correo">Correo Electrónico:</label>
                    <input type="email" name="correo" value="<?php echo htmlspecialchars($row['correo']); ?>" class="form-control" required><br>

                    <label for="fechaNacimiento">Fecha de Nacimiento:</label>
                    <input type="date" name="fechaNacimiento" value="<?php echo $row['fechaNacimiento']; ?>" class="form-control" required><br>

                    <label for="telefono">Teléfono:</label>
                    <input type="tel" name="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>" class="form-control"><br>

                   <input type="hidden" name="idCargo" value="4">

                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" value="<?php echo htmlspecialchars($row['direccion']); ?>" class="form-control" required><br>

                    <input type="submit" name="editar_apoderado" value="Guardar Cambios" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</body>
</html>

