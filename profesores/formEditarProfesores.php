<?php include("../models/db.php") ?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Profesor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Editar Profesor</h1>
                <?php

                if (!$conexion) {
                    die("Error de conexión: " . mysqli_connect_error());
                }

                // Verifica si se ha proporcionado el parámetro 'rut' en la URL
                if (isset($_GET['rut'])) {
                    $rut = $_GET['rut'];

                    // Realiza una consulta SQL para obtener los datos del profesor con el RUT proporcionado
                    $query = "SELECT * FROM profesor WHERE rut = '$rut'";
                    $result = mysqli_query($conexion, $query);

                    if (mysqli_num_rows($result) === 1) {
                        $row = mysqli_fetch_assoc($result);
                        ?>
                        <form method="post" action="../models/profesoresModels/editarProfesores.php">
                            <input type="hidden" name="rut" value="<?php echo $row['rut']; ?>">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" name="nombre" value="<?php echo $row['nombre']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="apellidoP" class="form-label">Apellido Paterno:</label>
                                <input type="text" class="form-control" name="apellidoP" value="<?php echo $row['apellidoP']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="apellidoM" class="form-label">Apellido Materno:</label>
                                <input type="text" class="form-control" name="apellidoM" value="<?php echo $row['apellidoM']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo Electrónico:</label>
                                <input type="text" class="form-control" name="correo" value="<?php echo $row['correo']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                                <input type="text" class="form-control" name="fechaNacimiento" value="<?php echo $row['fechaNacimiento']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="telefono" class="form-label">Teléfono:</label>
                                <input type="text" class="form-control" name="telefono" value="<?php echo $row['telefono']; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="genero" class="form-label">Género:</label>
                                <input type="text" class="form-control" name="genero" value="<?php echo $row['genero']; ?>">
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </form>
                        <?php
                    } else {
                        echo "No se encontró ningún profesor con el RUT proporcionado.";
                    }
                } else {
                    echo "Falta el parámetro 'rut' en la URL.";
                }

                // Cierre de la conexión
                mysqli_close($conexion);
                ?>
            </div>
        </div>
    </div>
</body>
</html>
