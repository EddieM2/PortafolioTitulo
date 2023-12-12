<?php
include("../models/db.php");

// Consulta para obtener el porcentaje de asistencia de todos los cursos
$queryAsistencia = "SELECT c.nombre AS curso, COUNT(a.idAsistencia) AS total_registros, 
                    SUM(a.presente) AS total_presentes
                    FROM curso c
                    LEFT JOIN asistencia a ON c.idCurso = a.idCurso
                    GROUP BY c.nombre";

$resultAsistencia = mysqli_query($conexion, $queryAsistencia);

if ($resultAsistencia) {
    // Muestra el porcentaje de asistencia para cada curso
    while ($row = mysqli_fetch_assoc($resultAsistencia)) {
        $curso = $row['curso'];
        $totalRegistros = $row['total_registros'];
        $totalPresentes = $row['total_presentes'];

        if ($totalRegistros > 0) {
            // Calcula el porcentaje de asistencias y redondea a dos decimales
            $porcentajeAsistencia = round(($totalPresentes / $totalRegistros) * 100, 2);
            echo "<p>Curso: $curso - Porcentaje de Asistencia: $porcentajeAsistencia%</p>";
        } else {
            echo "<p>Curso: $curso - Sin datos de asistencia</p>";
        }
    }
} else {
    echo "Error al obtener la asistencia.";
}
?>
