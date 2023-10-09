<?php
include("../models/db.php");

// Verifica si se ha proporcionado el parámetro de asignatura_id en la URL
if (isset($_GET['asignatura'])) {
    $asignatura_id = $_GET['asignatura'];
    $idCurso = $_GET['idCurso'];

    // Realiza una consulta SQL para obtener la lista de alumnos para esta asignatura
    $query_alumnos = "SELECT alumno.rut, alumno.nombre AS nombre_alumno
                      FROM alumno
                      INNER JOIN inscripcion ON alumno.rut = inscripcion.rutAlumno
                      WHERE inscripcion.idCurso IN (
                          SELECT idCurso FROM asignatura WHERE idAsignatura = $asignatura_id
                      )";
    $result_alumnos = mysqli_query($conexion, $query_alumnos);

    if ($result_alumnos) {
        echo "<h1>Lista de Alumnos para la Asignatura</h1>";
        echo "<form method='post' action='../models/profesoresModels/procesar_notas.php'>";
        echo "<input type='hidden' name='asignatura_id' value='$asignatura_id'>";
        echo "<input type='hidden' name='idCurso' value='$idCurso'>";

        echo "<table>";
        echo "<tr><th>RUT</th><th>Nombre del Alumno</th><th>Nota 1</th><th>Nota 2</th><th>Nota 3</th><th>Nota 4</th><th>Promedio</th></tr>";

        while ($row_alumno = mysqli_fetch_assoc($result_alumnos)) {
            $rut_alumno = $row_alumno['rut'];
            $nombre_alumno = $row_alumno['nombre_alumno'];

            // Realiza una consulta SQL para obtener las calificaciones ya ingresadas para este alumno
            $query_calificaciones = "SELECT calificacion1, calificacion2, calificacion3, calificacion4
                                    FROM calificaciones
                                    WHERE idAlumno = '$rut_alumno' AND idAsignatura = $asignatura_id AND idCurso = $idCurso";
            $result_calificaciones = mysqli_query($conexion, $query_calificaciones);

            $calificaciones = mysqli_fetch_assoc($result_calificaciones);

            // Calcula el promedio de las calificaciones
            $promedio = ($calificaciones['calificacion1'] + $calificaciones['calificacion2'] + $calificaciones['calificacion3'] + $calificaciones['calificacion4']) / 4;

            echo "<tr>";
            echo "<td>$rut_alumno</td>";
            echo "<td>$nombre_alumno</td>";
            echo "<td><input type='number' name='calificaciones[$rut_alumno][calificacion1]' step='0.01' value='" . $calificaciones['calificacion1'] . "'></td>";
            echo "<td><input type='number' name='calificaciones[$rut_alumno][calificacion2]' step='0.01' value='" . $calificaciones['calificacion2'] . "'></td>";
            echo "<td><input type='number' name='calificaciones[$rut_alumno][calificacion3]' step='0.01' value='" . $calificaciones['calificacion3'] . "'></td>";
            echo "<td><input type='number' name='calificaciones[$rut_alumno][calificacion4]' step='0.01' value='" . $calificaciones['calificacion4'] . "'></td>";
            echo "<td>$promedio</td>";
            echo "</tr>";
        }
        echo "</table>";

        echo "<input type='submit' value='Guardar Notas'>";
        echo "</form>";
    } else {
        echo "Error al obtener la lista de alumnos.";
    }
} else {
    echo "Falta el parámetro de asignatura_id en la URL.";
}
?>
