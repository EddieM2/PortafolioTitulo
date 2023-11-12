<?php
session_start();
include("../models/db.php");

$alumno_rut = $_SESSION['rut'];

$query_asignaturas = "SELECT DISTINCT asi.idAsignatura, asi.nombre AS nombre_asignatura
                      FROM calificaciones AS cal
                      INNER JOIN asignatura AS asi ON cal.idAsignatura = asi.idAsignatura
                      WHERE cal.idAlumno = '$alumno_rut'";
$result_asignaturas = mysqli_query($conexion, $query_asignaturas);

if (!$result_asignaturas) {
    die("Error en la consulta de asignaturas: " . mysqli_error($conexion));
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
                if (mysqli_num_rows($result_asignaturas) > 0) {
                    while ($row_asignatura = mysqli_fetch_assoc($result_asignaturas)) {
                        echo '<div class="accordion" id="accordionAsignatura' . $row_asignatura['idAsignatura'] . '">';
                        echo '<div class="accordion-item">';
                        echo '<h2 class="accordion-header" id="headingAsignatura' . $row_asignatura['idAsignatura'] . '">';
                        echo '<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAsignatura' . $row_asignatura['idAsignatura'] . '" aria-expanded="true" aria-controls="collapseAsignatura' . $row_asignatura['idAsignatura'] . '">';
                        echo $row_asignatura['nombre_asignatura'];
                        echo '</button>';
                        echo '</h2>';
                        echo '<div id="collapseAsignatura' . $row_asignatura['idAsignatura'] . '" class="accordion-collapse collapse" aria-labelledby="headingAsignatura' . $row_asignatura['idAsignatura'] . '" data-bs-parent="#accordionAsignatura' . $row_asignatura['idAsignatura'] . '">';
                        echo '<div class="accordion-body">';

                        $idAsignatura = $row_asignatura['idAsignatura'];
                        $query_calificaciones = "SELECT fecha, calificacion1, calificacion2, calificacion3, calificacion4, promedio
                                                FROM calificaciones
                                                WHERE idAlumno = '$alumno_rut' AND idAsignatura = '$idAsignatura'";
                        $result_calificaciones = mysqli_query($conexion, $query_calificaciones);

                        if (!$result_calificaciones) {
                            die("Error en la consulta de calificaciones: " . mysqli_error($conexion));
                        }

                        if (mysqli_num_rows($result_calificaciones) > 0) {
                            $row_calificaciones = mysqli_fetch_assoc($result_calificaciones);
                            echo '<p>Fecha: ' . $row_calificaciones['fecha'] . '</p>';
                            echo '<p>Calificación 1: ' . $row_calificaciones['calificacion1'] . '</p>';
                            echo '<p>Calificación 2: ' . $row_calificaciones['calificacion2'] . '</p>';
                            echo '<p>Calificación 3: ' . $row_calificaciones['calificacion3'] . '</p>';
                            echo '<p>Calificación 4: ' . $row_calificaciones['calificacion4'] . '</p>';
                            if ($row_calificaciones['promedio'] >= 1.0) {
                                echo '<p>Promedio: ' . $row_calificaciones['promedio'] . '</p>';
                            }
                        } else {
                            echo "No hay calificaciones registradas para esta asignatura.";
                        }

                        echo '</div>';
                        echo '</div>';
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
