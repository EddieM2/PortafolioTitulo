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

            echo '<!DOCTYPE html>';
            echo '<html>';
            echo '<head>';
            echo '    <meta charset="UTF-8">';
            echo '    <title>Apoderado</title>';
            echo '    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">';
            echo '    <link rel="stylesheet" href="../src/css/profes.css">'; // Asegúrate de que la ruta al archivo CSS sea correcta
            echo '</head>';
            echo '<body>';
            echo '    <div class="container mt-5">';
            echo '        <div class="custom-card">';
            echo '            <div class="custom-card-body">';
            echo "                <h1 class='card-title'>Bienvenido, $nombreApoderado $apellidoPaterno</h1>";

            // Consulta para obtener los pupilos del apoderado
            $consultaPupilos = "SELECT rut, nombre, apellidoP, apellidoM FROM alumno WHERE rutApoderado = '$apoderado_rut'";
            $resultadoPupilos = mysqli_query($conexion, $consultaPupilos);

            if ($resultadoPupilos) {
                echo '                <form method="post" action="notas_alumno_apoderado.php">';
                echo '                    <p>Selecciona un pupilo:</p>';

                while ($filaPupilo = mysqli_fetch_assoc($resultadoPupilos)) {
                    $rutPupilo = $filaPupilo['rut'];
                    $nombrePupilo = $filaPupilo['nombre'];
                    $apellidoPaternoPupilo = $filaPupilo['apellidoP'];
                    $apellidoMaternoPupilo = $filaPupilo['apellidoM'];

                    echo "                    <input type='radio' name='rut_pupilo' value='$rutPupilo'>";
                    echo "                    <label>Rut: $rutPupilo, Nombre: $nombrePupilo, Apellido Paterno: $apellidoPaternoPupilo, Apellido Materno: $apellidoMaternoPupilo</label>";
                }

                echo '                    <button type="submit" class="btn btn-primary">Seleccionar</button>';
                echo '                </form>';
            } else {
                echo "                <p>Error en la consulta de pupilos: " . mysqli_error($conexion) . "</p>";
            }

            echo '            </div>';
            echo '        </div>';
            echo '    </div>';
            echo '    <a class="btn btn-primary" href="inicioSesionApoderado.php">Cerrar sesión</a>';
            echo '</body>';
            echo '</html>';
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
