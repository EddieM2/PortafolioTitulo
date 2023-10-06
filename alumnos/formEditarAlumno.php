<?php include("../models/db.php") ?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Alumno</title>
</head>
<body>
    <h1>Editar Alumno</h1>
    
    <?php
    // Verificar si se ha proporcionado un parámetro "rut" en la URL
    if (isset($_GET["rut"])) {
        $rut = $_GET["rut"];

        

        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Consulta SQL para obtener los datos del alumno con el RUT proporcionado
        $sql = "SELECT * FROM alumno WHERE rut = '$rut'";
        $result = mysqli_query($conexion, $sql);

        if (mysqli_num_rows($result) == 1) {
            // Obtener los datos del alumno
            $row = mysqli_fetch_assoc($result);
            $nombre = $row["nombre"];
            $apellidoP = $row["apellidoP"];
            $apellidoM = $row["apellidoM"];
            $correo = $row["correo"];
            $idCargo = $row["idCargo"];
            $direccion = $row["direccion"];
            $fechaNacimiento = $row["fechaNacimiento"];
            $telefono = $row["telefono"];
            $genero = $row["genero"];
            $estadoAcademico = $row["estadoAcademico"];

            // Mostrar el formulario de edición
            echo "<form method='POST' action='../models/alumnosModels/editarAlumno.php'>";
            echo "<input type='hidden' name='rut' value='$rut'>";
            echo "Nombre: <input type='text' name='nombre' value='$nombre' required><br>";
            echo "Apellido Paterno: <input type='text' name='apellidoP' value='$apellidoP' required><br>";
            echo "Apellido Materno: <input type='text' name='apellidoM' value='$apellidoM' required><br>";
            echo "Correo Electrónico: <input type='email' name='correo' value='$correo' required><br>";
            echo "ID Cargo: <input type='number' name='idCargo' value='$idCargo' required><br>";
            echo "Dirección: <input type='text' name='direccion' value='$direccion' required><br>";
            echo "Fecha de Nacimiento: <input type='date' name='fechaNacimiento' value='$fechaNacimiento' required><br>";
            echo "Teléfono: <input type='tel' name='telefono' value='$telefono' required><br>";
            echo "Genero: <input type='text' name='genero' value='$genero' required><br>";
            echo "Estado Academico: <input type='text' name='estadoAcademico' value='$estadoAcademico' required><br>";

            // Agregar campo de selección para el RUT del apoderado
            echo "RUT Apoderado: <select name='rutApoderado'>";
            echo "<option value=''>Seleccione un apoderado</option>";

            // Consulta SQL para obtener la lista de apoderados
            $sqlApoderados = "SELECT rut, nombre FROM apoderado";
            $resultApoderados = mysqli_query($conexion, $sqlApoderados);

            while ($rowApoderado = mysqli_fetch_assoc($resultApoderados)) {
                $selected = ($rowApoderado['rut'] == $row['rutApoderado']) ? "selected" : "";
                echo "<option value='" . $rowApoderado['rut'] . "' $selected>" . $rowApoderado['nombre'] . "</option>";
            }

            echo "</select><br>";

            echo "<input type='submit' name='editar_alumno' value='Guardar Cambios'>";
            echo "</form>";
        } else {
            echo "No se encontró un alumno con el RUT proporcionado.";
        }

        // Cierra la conexión a la base de datos
        mysqli_close($conexion);
    } else {
        echo "RUT no proporcionado en la URL.";
    }
    ?>
</body>
</html>

