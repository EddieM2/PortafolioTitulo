<?php include("../models/db.php") ?>

<?php
session_start();

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

            // Mostrar el nombre y apellido paterno del apoderado
            echo "Bienvenido, $nombreApoderado $apellidoPaterno<br>";

            // Consulta para obtener los pupilos del apoderado
            $consultaPupilos = "SELECT rut, nombre, apellidoP, apellidoM FROM alumno WHERE rutApoderado = '$apoderado_rut'";
            $resultadoPupilos = mysqli_query($conexion, $consultaPupilos);

            if ($resultadoPupilos) {
                // Mostrar la lista de pupilos en un formulario POST
                echo "<form method='post' action='opciones_alumno.php'>";
                echo "Selecciona un pupilo:<br>";
                while ($filaPupilo = mysqli_fetch_assoc($resultadoPupilos)) {
                    $rutPupilo = $filaPupilo['rut'];
                    $nombrePupilo = $filaPupilo['nombre'];
                    $apellidoPaternoPupilo = $filaPupilo['apellidoP'];
                    $apellidoMaternoPupilo = $filaPupilo['apellidoM'];

                    // Agregar un radio button para cada pupilo
                    echo "<input type='radio' name='rut_pupilo' value='$rutPupilo'> ";
                    echo "Rut: $rutPupilo, Nombre: $nombrePupilo, Apellido Paterno: $apellidoPaternoPupilo, Apellido Materno: $apellidoMaternoPupilo<br>";
                }
                echo "<input type='submit' value='Seleccionar'>";
                echo "</form>";
            } else {
                echo "Error en la consulta de pupilos: " . mysqli_error($conexion);
            }
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

