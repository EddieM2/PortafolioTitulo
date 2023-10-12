<?php
include("../models/db.php");

if (isset($_GET['asignatura'])) {
    $asignatura_id = $_GET['asignatura'];
    $idCurso = $_GET['idCurso'];
    
    // Obtiene la fecha actual
    $fecha = date('Y-m-d'); // Formato: AAAA-MM-DD

    // Verifica si ya existe una clase para la asignatura y curso en la fecha actual
    $query_existencia_clase = "SELECT COUNT(*) AS existe
        FROM asistencia
        WHERE idAsignatura = $asignatura_id AND idCurso = $idCurso AND fecha = '$fecha'";

    $result_existencia_clase = mysqli_query($conexion, $query_existencia_clase);
    $row_existencia_clase = mysqli_fetch_assoc($result_existencia_clase);
    $clase_existente = (int)$row_existencia_clase['existe'];

    if ($clase_existente) {
        // La clase ya existe, muestra un mensaje
        echo "La clase de asistencia para esta asignatura y curso en la fecha actual ya ha sido creada.";
    } else {
        // La clase no existe, procede con la inserción
        $query_insert_asistencia = "INSERT INTO asistencia (rutAlumno, idAsignatura, idCurso, fecha, presente) 
            SELECT alumno.rut, $asignatura_id, $idCurso, '$fecha', 0
            FROM alumno
            INNER JOIN inscripcion ON alumno.rut = inscripcion.rutAlumno
            WHERE inscripcion.idCurso = $idCurso";

        $result_insert_asistencia = mysqli_query($conexion, $query_insert_asistencia);

        if ($result_insert_asistencia) {
            // La clase se ha creado y todos los alumnos se han marcado como ausentes

            // Recupera la lista de alumnos para mostrarla
            $query_lista_alumnos = "SELECT alumno.rut, alumno.nombre AS nombre_alumno
            FROM alumno
            INNER JOIN inscripcion ON alumno.rut = inscripcion.rutAlumno
            WHERE inscripcion.idCurso IN (
                SELECT idCurso FROM asignatura WHERE idAsignatura = $asignatura_id
            )";
            $result_lista_alumnos = mysqli_query($conexion, $query_lista_alumnos);

            if ($result_lista_alumnos) {
                echo "<h1>Lista de Alumnos en el Curso</h1>";
                echo "<ul>";
                while ($row_alumno = mysqli_fetch_assoc($result_lista_alumnos)) {
                    echo "<li>" . $row_alumno['rut'] . " - " . $row_alumno['nombre_alumno'] . "</li>";
                }
                echo "</ul>";
            } else {
                echo "Error al obtener la lista de alumnos.";
            }

            // Redirige a la página de lista de alumnos en esa asignatura y curso
            header("Location: asignaturas_asistencia.php?asignatura=$asignatura_id&idCurso=$idCurso");
            exit();
        } else {
            // Manejo de errores si la inserción falla
            echo "Error al crear la clase de asistencia.";
        }
    }
}
?>