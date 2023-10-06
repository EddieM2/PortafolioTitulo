<?php include("../models/db.php") ?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Profesor</title>
</head>
<body>
    <h1>Editar Profesor</h1>
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
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" value="<?php echo $row['nombre']; ?>"><br>
                <label for="apellidoP">Apellido Paterno:</label>
                <input type="text" name="apellidoP" value="<?php echo $row['apellidoP']; ?>"><br>
                <label for="apellidoM">Apellido Materno:</label>
                <input type="text" name="apellidoM" value="<?php echo $row['apellidoM']; ?>"><br>
                <label for="correo">Correo Electrónico:</label>
                <input type="text" name="correo" value="<?php echo $row['correo']; ?>"><br>
                <label for="fechaNacimiento">Fecha de Nacimiento:</label>
                <input type="text" name="fechaNacimiento" value="<?php echo $row['fechaNacimiento']; ?>"><br>
                <label for="telefono">Teléfono:</label>
                <input type="text" name="telefono" value="<?php echo $row['telefono']; ?>"><br>
                <label for="genero">Género:</label>
                <input type="text" name="genero" value="<?php echo $row['genero']; ?>"><br>

                <input type="submit" value="Guardar Cambios">
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
</body>
</html>
