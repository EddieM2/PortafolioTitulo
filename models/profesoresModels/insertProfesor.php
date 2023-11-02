<?php include("../db.php") ?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Profesor</title>
</head>
<body>
    <h1>Agregar Profesor</h1>

    <?php

    // Verificar si se ha enviado el formulario
    if (isset($_POST['agregar_profesor'])) {
        $rut = $_POST['rut'];
        $nombre = $_POST['nombre'];
        $apellidoP = $_POST['apellidoP'];
        $apellidoM = $_POST['apellidoM'];
        $correo = $_POST['correo'];
        $fechaNacimiento = $_POST['fechaNacimiento'];
        $telefono = $_POST['telefono'];
        $genero = $_POST['genero'];
        $idCargo = $_POST['idCargo']; // Agregamos el campo idCargo

        // Insertar el nuevo profesor en la tabla profesor
        $query = "INSERT INTO profesor (rut, nombre, apellidoP, apellidoM, correo, fechaNacimiento, telefono, genero, idCargo) VALUES ('$rut', '$nombre', '$apellidoP', '$apellidoM', '$correo', '$fechaNacimiento', '$telefono', '$genero', '$idCargo')";
        $result = mysqli_query($conexion, $query);

        if ($result) {
            // Éxito: el profesor se ha agregado correctamente
            echo "<p>Profesor agregado con éxito.</p>";

            // Redirigir al usuario a la página "inicioProf"
            header("Location: vistaProfesores.php");
            exit; // Asegurarse de que el script se detenga después de la redirección
        } else {
            // Error: no se pudo agregar el profesor
            echo "<p>Error al agregar el profesor: " . mysqli_error($conexion) . "</p>";
        }
    }
    ?>

    <form method="POST" action="">
        <label for="rut">RUT:</label>
        <input type="text" name="rut" required><br>

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required><br>

        <label for="apellidoP">Apellido Paterno:</label>
        <input type="text" name="apellidoP" required><br>

        <label for="apellidoM">Apellido Materno:</label>
        <input type="text" name="apellidoM" required><br>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" required><br>

        <label for="fechaNacimiento">Fecha de Nacimiento:</label>
        <input type="date" name="fechaNacimiento" required><br>

        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" required><br>

        <label for="genero">Género:</label>
        <input type="text" name="genero" required><br>

        <label for="idCargo">Cargo:</label>
        <select name="idCargo" required>
            <option value="1">Administrador</option>
            <option value="2">Profesor</option>
            <option value="3">Alumno</option>
            <option value="4">Apoderado</option>
        </select><br>

        <input type="submit" name="agregar_profesor" value="Agregar Profesor">
    </form>

    <a href="lista_profesores.php">Volver a la lista de profesores</a>
</body>
</html>
