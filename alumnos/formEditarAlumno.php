<?php include("../models/db.php") ?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Alumno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css"> 
    <style>
        body {
            padding-top: 90px; /* Agrega un espacio en la parte superior del cuerpo de la página */
        }

        .card {
            max-width: 600px; /* Limita el ancho máximo de la tarjeta */
            margin: 0 auto; /* Centra la tarjeta horizontalmente */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Editar Alumno</h1>
                <?php
                if (isset($_GET["rut"])) {
                    $rut = $_GET["rut"];

                    if (!$conexion) {
                        die("Error de conexión: " . mysqli_connect_error());
                    }

                    $sql = "SELECT * FROM alumno WHERE rut = '$rut'";
                    $result = mysqli_query($conexion, $sql);

                    if (mysqli_num_rows($result) == 1) {
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
                        $rutApoderado = $row["rutApoderado"];

                        echo "<form method='POST' action='../models/alumnosModels/editarAlumno.php'>";
                        echo "<input type='hidden' name='rut' value='$rut'>";
                        echo "Nombre: <input type='text' name='nombre' value='$nombre' class='form-control' required><br>";
                        echo "Apellido Paterno: <input type='text' name 'apellidoP' value='$apellidoP' class='form-control' required><br>";
                        echo "Apellido Materno: <input type='text' name='apellidoM' value='$apellidoM' class='form-control' required><br>";
                        echo "Correo Electrónico: <input type='email' name='correo' value='$correo' class='form-control' required><br>";
                        echo "ID Cargo: <input type='number' name='idCargo' value='$idCargo' class='form-control' required><br>";
                        echo "Dirección: <input type='text' name='direccion' value='$direccion' class='form-control' required><br>";
                        echo "Fecha de Nacimiento: <input type='date' name='fechaNacimiento' value='$fechaNacimiento' class='form-control' required><br>";
                        echo "Teléfono: <input type='tel' name='telefono' value='$telefono' class='form-control' required><br>";
                        echo "Género: <input type='text' name='genero' value='$genero' class='form-control' required><br>";
                        echo "Estado Académico: <input type='text' name='estadoAcademico' value='$estadoAcademico' class='form-control' required><br>";

                        // Agregar campo de selección para el RUT del apoderado
                        echo "RUT Apoderado: <select name='rutApoderado' class='form-control'>";
                        echo "<option value=''>Seleccione un apoderado</option>";

                        $sqlApoderados = "SELECT rut, nombre FROM apoderado";
                        $resultApoderados = mysqli_query($conexion, $sqlApoderados);

                        while ($rowApoderado = mysqli_fetch_assoc($resultApoderados)) {
                            $selected = ($rowApoderado['rut'] == $rutApoderado) ? "selected" : "";
                            echo "<option value='" . $rowApoderado['rut'] . "' $selected>" . $rowApoderado['nombre'] . "</option>";
                        }

                        echo "</select><br>";

                        echo "<input type='submit' name='editar_alumno' value='Guardar Cambios' class='btn btn-primary'>";
                        echo "</form>";
                    } else {
                        echo "No se encontró un alumno con el RUT proporcionado.";
                    }

                    mysqli_close($conexion);
                } else {
                    echo "RUT no proporcionado en la URL.";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
