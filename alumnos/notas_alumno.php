<?php
session_start();
//if (!isset($_SESSION['rut'])) {
  //  header("Location: ../login.php"); // Redirige si no ha iniciado sesión
    //exit();
//}

include("../models/db.php");

// Obtén el rut del alumno desde la sesión
$alumno_rut = $_SESSION['rut'];

// Realiza una consulta para obtener las calificaciones del alumno junto con el nombre de la asignatura
$query = "SELECT cal.idCalificacion, cal.fecha, asi.nombre AS nombre_asignatura, cal.calificacion1, cal.calificacion2, cal.calificacion3, cal.calificacion4
          FROM calificaciones AS cal
          INNER JOIN asignatura AS asi ON cal.idAsignatura = asi.idAsignatura
          WHERE cal.idAlumno = '$alumno_rut'";

$result = mysqli_query($conexion, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calificaciones del Alumno</title>

</head>
<body>
    <h1>Calificaciones del Alumno</h1>

    <?php
    if (mysqli_num_rows($result) > 0) {
        echo "<table>";
        echo "<tr><th>Asignatura</th><th>Fecha</th><th>Calificación 1</th><th>Calificación 2</th><th>Calificación 3</th><th>Calificación 4</th></tr>";

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['nombre_asignatura'] . "</td>";
            echo "<td>" . $row['fecha'] . "</td>";
            echo "<td>" . $row['calificacion1'] . "</td>";
            echo "<td>" . $row['calificacion2'] . "</td>";
            echo "<td>" . $row['calificacion3'] . "</td>";
            echo "<td>" . $row['calificacion4'] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No hay calificaciones registradas.";
    }
    ?>

    <a href="inicioAlum.php">Volver a la página de inicio del alumno</a>
</body>
</html>
