<?php
include("../models/db.php");

// Verifica si se han recibido los parámetros necesarios en la URL
if (isset($_GET['fecha']) && isset($_GET['Asignatura']) && isset($_GET['idCurso'])) {
    $fecha = $_GET['fecha'];
    $idAsignatura = $_GET['Asignatura'];
    $idCurso = $_GET['idCurso'];

    // Realiza una consulta SQL para obtener los registros de asistencia de esa fecha, asignatura y curso
    $query_asistencia = "SELECT rutAlumno, presente FROM asistencia WHERE fecha = '$fecha' AND idAsignatura = $idAsignatura AND idCurso = $idCurso";
    $result_asistencia = mysqli_query($conexion, $query_asistencia);

    if ($result_asistencia) {
        echo "<h1>Editar Asistencia</h1>";
        echo "<form method='post' action='procesar_asistencia.php'>";
        echo "<input type='hidden' name='fecha' value='$fecha'>";
        echo "<input type='hidden' name='idAsignatura' value='$idAsignatura'>";
        echo "<input type='hidden' name='idCurso' value='$idCurso'>";

        echo "<table border='1'>";
        echo "<tr><th>RUT del Alumno</th><th>Asistencia</th></tr>";

        while ($row_asistencia = mysqli_fetch_assoc($result_asistencia)) {
            $idAlumno = $row_asistencia['rutAlumno'];
            $presente = $row_asistencia['presente'];

            // Recupera el nombre del alumno para mostrarlo
            $query_nombre_alumno = "SELECT nombre FROM alumno WHERE rut = '$idAlumno'";
            $result_nombre_alumno = mysqli_query($conexion, $query_nombre_alumno);
            $nombre_alumno = "Nombre no encontrado";

            if ($result_nombre_alumno) {
                $row_nombre_alumno = mysqli_fetch_assoc($result_nombre_alumno);
                $nombre_alumno = $row_nombre_alumno['nombre'];
            }

            echo "<tr>";
            echo "<td>$idAlumno - $nombre_alumno</td>";
            echo "<td>";
            echo "<label><input type='checkbox' name='asistencia[$idAlumno]' value='1' " . ($presente == 1 ? "checked" : "") . "> Presente</label>";
            echo "<label><input type='checkbox' name='asistencia[$idAlumno]' value='0' " . ($presente == 0 ? "checked" : "") . "> Ausente</label>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";

        echo "<input type='submit' value='Guardar Asistencia'>";
        echo "</form>";
    } else {
        echo "Error al obtener la asistencia.";
    }
} else {
    echo "Faltan parámetros en la URL.";
}
?>

