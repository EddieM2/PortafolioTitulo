<?php
// Conexión a la base de datos
include("../models/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID del curso y la asignatura seleccionados
    $selectedCurso = $_POST["curso"];
    $selectedAsignatura = $_POST["asignatura"];

    // Consulta SQL para obtener las calificaciones del curso y la asignatura seleccionados
    $queryCalificaciones = "SELECT * FROM calificaciones WHERE idCurso = $selectedCurso AND idAsignatura = $selectedAsignatura";
    $resultCalificaciones = mysqli_query($conexion, $queryCalificaciones);

    if ($resultCalificaciones) {
        // Crear una tabla HTML para mostrar las calificaciones
        echo "<h2>Calificaciones del Curso y Asignatura Seleccionados</h2>";
        echo "<table border='1'>";
        echo "<tr>";
        echo "<th>Alumno</th>";
        echo "<th>Calificación 1</th>";
        echo "<th>Calificación 2</th>";
        echo "<th>Calificación 3</th>";
        echo "<th>Calificación 4</th>";
        echo "<th>Promedio</th>";
        echo "</tr>";

        while ($rowCalificacion = mysqli_fetch_assoc($resultCalificaciones)) {
            $alumno = $rowCalificacion['idAlumno'];
            $calificacion1 = $rowCalificacion['calificacion1'];
            $calificacion2 = $rowCalificacion['calificacion2'];
            $calificacion3 = $rowCalificacion['calificacion3'];
            $calificacion4 = $rowCalificacion['calificacion4'];
            $promedio = $rowCalificacion['promedio'];

            echo "<tr>";
            echo "<td>$alumno</td>";
            echo "<td>$calificacion1</td>";
            echo "<td>$calificacion2</td>";
            echo "<td>$calificacion3</td>";
            echo "<td>$calificacion4</td>";
            echo "<td>$promedio</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No se encontraron calificaciones para el curso y asignatura seleccionados.";
    }
} else {
    echo "Solicitud no válida.";
}
?>
