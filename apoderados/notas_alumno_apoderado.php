<?php
include("../models/db.php");

// Rut del alumno seleccionado 
$rut_pupilo = $_POST['rut_pupilo'];

// Consulta para obtener las calificaciones del alumno junto con el nombre de la asignatura
$query = "SELECT cal.idCalificacion, cal.fecha, asi.nombre AS nombre_asignatura, cal.calificacion1, cal.calificacion2, cal.calificacion3, cal.calificacion4, cal.promedio
          FROM calificaciones AS cal
          INNER JOIN asignatura AS asi ON cal.idAsignatura = asi.idAsignatura
          WHERE cal.idAlumno = '$rut_pupilo'";

$result = mysqli_query($conexion, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Calificaciones del Alumno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="../src/css/profes.css"> 
</head>
<body>
    <div class="container mt-5">
        <div class="accordion" id="accordionAsignaturas">

            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="accordion-item">';
                    echo '<h2 class="accordion-header" id="headingAsignatura' . $row['idCalificacion'] . '">';
                    echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAsignatura' . $row['idCalificacion'] . '" aria-expanded="true" aria-controls="collapseAsignatura' . $row['idCalificacion'] . '">';
                    echo $row['nombre_asignatura'];
                    echo '</button>';
                    echo '</h2>';
                    echo '<div id="collapseAsignatura' . $row['idCalificacion'] . '" class="accordion-collapse collapse" aria-labelledby="headingAsignatura' . $row['idCalificacion'] . '" data-bs-parent="#accordionAsignaturas">';
                    echo '<div class="accordion-body">';
                    //echo '<p>Fecha: ' . $row['fecha'] . '</p>';
                    echo '<p>Calificación 1: ' . $row['calificacion1'] . '</p>';
                    echo '<p>Calificación 2: ' . $row['calificacion2'] . '</p>';
                    echo '<p>Calificación 3: ' . $row['calificacion3'] . '</p>';
                    echo '<p>Calificación 4: ' . $row['calificacion4'] . '</p>';

                    // Mostrar el promedio solo si es superior a 0
                    if ($row['promedio'] > 0) {
                        echo '<p>Promedio: ' . $row['promedio'] . '</p>';
                    }

                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p>No hay calificaciones registradas.</p>';
            }
            ?>

        </div>
        <button class="btn-back" onclick="window.history.back();"><i class="fas fa-arrow-left"></i> Volver Atrás</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


