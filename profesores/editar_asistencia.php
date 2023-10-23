<?php
include("../models/db.php");

// Verifica si se han recibido los parámetros necesarios en la URL
// Verifica si se han recibido los parámetros necesarios en la URL
if (isset($_GET['fecha']) && isset($_GET['idCurso'])) {
    $fecha = $_GET['fecha'];
    $idCurso = $_GET['idCurso'];

    // Realiza una consulta SQL para obtener los registros de asistencia de esa fecha y curso
    $query_asistencia = "SELECT rutAlumno, presente FROM asistencia WHERE fecha = '$fecha' AND idCurso = $idCurso";
    $result_asistencia = mysqli_query($conexion, $query_asistencia);

    if ($result_asistencia) {
        echo "<h1>Editar Asistencia</h1>";
        echo "<form method='post' action='procesar_asistencia.php'>";
        echo "<input type='hidden' name='fecha' value='$fecha'>";
        echo "<input type='hidden' name='idCurso' value='$idCurso'>";

        echo "<table border='1'>";
        echo "<tr><th>RUT del Alumno</th><th>Nombre</th><th>Apellido Paterno</th><th>Apellido Materno</th><th>Asistencia</th></tr>";

        while ($row_asistencia = mysqli_fetch_assoc($result_asistencia)) {
            $idAlumno = $row_asistencia['rutAlumno'];
            $presente = $row_asistencia['presente'];

            // Recupera el nombre, apellido paterno y apellido materno del alumno para mostrarlo
            $query_nombre_alumno = "SELECT nombre, apellidoP, apellidoM FROM alumno WHERE rut = '$idAlumno'";
            $result_nombre_alumno = mysqli_query($conexion, $query_nombre_alumno);

            if ($result_nombre_alumno) {
                $row_nombre_alumno = mysqli_fetch_assoc($result_nombre_alumno);
                $nombre_alumno = $row_nombre_alumno['nombre'];
                $apellido_paterno = $row_nombre_alumno['apellidoP'];
                $apellido_materno = $row_nombre_alumno['apellidoM'];

                echo "<tr>";
                echo "<td>$idAlumno</td>";
                echo "<td>$nombre_alumno</td>";
                echo "<td>$apellido_paterno</td>";
                echo "<td>$apellido_materno</td>";
                echo "<td>";
                echo "<label><input type='checkbox' name='asistencia[$idAlumno]' value='1' " . ($presente == 1 ? "checked" : "") . "> Presente</label>";
                echo "<label><input type='checkbox' name='asistencia[$idAlumno]' value='0' " . ($presente == 0 ? "checked" : "") . "> Ausente</label>";
                echo "</td>";
                echo "</tr>";
            }
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

