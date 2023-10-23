<?php
session_start();
if (!isset($_SESSION['rut'])) {
    header("Location: ../login.php"); // Redirige si no ha iniciado sesión
    exit();
}

include("../models/db.php");

// Obtén el rut del alumno desde la sesión
$alumno_rut = $_SESSION['rut'];

// Realiza una consulta para obtener la asistencia del alumno en función de su rut
$query = "SELECT fecha, presente
          FROM asistencia
          WHERE rutAlumno = '$alumno_rut'";

$result = mysqli_query($conexion, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asistencia del Alumno</title>
    <!-- Agrega aquí tus enlaces a CSS y otros recursos -->
</head>
<body>
    <h1>Asistencia del Alumno</h1>

    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Fecha</th><th>Presente</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['fecha'] . "</td>";
            echo "<td>" . ($row['presente'] ? 'Presente' : 'Ausente') . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No hay registros de asistencia para este alumno.";
    }
    ?>

    <a href="inicioAlum.php">Volver a la página de inicio del alumno</a>
</body>
</html>
