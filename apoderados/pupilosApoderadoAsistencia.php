<?php
include("../models/db.php");

// Verificar si el usuario ha iniciado sesión como apoderado
if (isset($_SESSION['rut'])) {
    $apoderado_rut = $_SESSION['rut'];

    // Consulta para obtener el nombre y apellido paterno del apoderado
    $consultaApoderado = "SELECT nombre, apellidoP FROM apoderado WHERE rut = '$apoderado_rut'";
    $resultadoApoderado = mysqli_query($conexion, $consultaApoderado);

    if ($resultadoApoderado) {
        $filaApoderado = mysqli_fetch_assoc($resultadoApoderado);

        if ($filaApoderado) {
            $nombreApoderado = $filaApoderado['nombre'];
            $apellidoPaterno = $filaApoderado['apellidoP'];

            // Cerrar la etiqueta PHP para comenzar la estructura HTML
            ?>

            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <title>Asistencia del Alumno</title>
                <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
                <link rel="stylesheet" href="../src/css/profes.css"> <!-- Asegúrate de que la ruta al archivo CSS sea correcta -->
            </head>
            <body>
                <div class="container mt-5">
                    <div class="custom-card">
                        <div class="custom-card-body">
                            <h1 class="card-title">Bienvenido, <?php echo $nombreApoderado . ' ' . $apellidoPaterno; ?></h1>

                            <?php
                            // Consulta para obtener los pupilos del apoderado
                            $consultaPupilos = "SELECT rut, nombre, apellidoP, apellidoM FROM alumno WHERE rutApoderado = '$apoderado_rut'";
                            $resultadoPupilos = mysqli_query($conexion, $consultaPupilos);

                            if ($resultadoPupilos) {
                                // Mostrar la lista de pupilos en un formulario POST
                                echo "<form method='post' action='asistencia_alumno_apoderado.php'>";
                                echo "Selecciona un pupilo:<br>";
                                while ($filaPupilo = mysqli_fetch_assoc($resultadoPupilos)) {
                                    $rutPupilo = $filaPupilo['rut'];
                                    $nombrePupilo = $filaPupilo['nombre'];
                                    $apellidoPaternoPupilo = $filaPupilo['apellidoP'];
                                    $apellidoMaternoPupilo = $filaPupilo['apellidoM'];

                                    // Agregar un radio button para cada pupilo y un campo oculto con el Rut del alumno
                                    echo "<input type='radio' name='rut_pupilo' value='$rutPupilo'> ";
                                    echo "Rut: $rutPupilo, Nombre: $nombrePupilo, Apellido Paterno: $apellidoPaternoPupilo, Apellido Materno: $apellidoMaternoPupilo<br>";
                                    // echo "<input type='hidden' name='rut_pupilo' value='$rutPupilo'>";
                                }
                                echo "<input type='submit' value='Seleccionar'>";
                                echo "</form>";
                            } else {
                                echo "Error en la consulta de pupilos: " . mysqli_error($conexion);
                            }
                            ?>

                        </div>
                    </div>
                </div>
            </body>
            </html>

            <?php
        } else {
            echo "Error: Apoderado no encontrado";
        }
    } else {
        echo "Error en la consulta de apoderado: " . mysqli_error($conexion);
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conexion);
} else {
    // Si no ha iniciado sesión, redirigir a la página de inicio de sesión
    header("Location: inicioSesionApoderado.php");
    exit();
}
?>
