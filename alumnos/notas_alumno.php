<?php
session_start();
// if (!isset($_SESSION['rut'])) {
//     header("Location: ../login.php"); // Redirige si no ha iniciado sesión
//     exit();
// }

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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css">
</head>
<body>
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body">
                <h1 class="card-title">Calificaciones del Alumno</h1>

                <?php
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="asignatura">';
                        echo '<p>Asignatura: ' . $row['nombre_asignatura'] . '</p>';
                        echo '<div class="calificaciones">';
                        echo '<p>Fecha: ' . $row['fecha'] . '</p>';
                        echo '<p>Calificación 1: ' . $row['calificacion1'] . '</p>';
                        echo '<p>Calificación 2: ' . $row['calificacion2'] . '</p>';
                        echo '<p>Calificación 3: ' . $row['calificacion3'] . '</p>';
                        echo '<p>Calificación 4: ' . $row['calificacion4'] . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                } else {
                    echo "No hay calificaciones registradas.";
                }
                ?>

                <a class="btn btn-primary" href="inicioAlum.php">Volver a la página de inicio del alumno</a>
            </div>
        </div>
    </div>
</body>
</html>
