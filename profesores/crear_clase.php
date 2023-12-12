<?php
include("../models/db.php");

if (isset($_GET['idCurso'])) {
   // $asignatura_id = $_GET['asignatura'];
    $idCurso = $_GET['idCurso'];
    
    // Obtiene la fecha actual
    $fecha = date('Y-m-d'); // Formato: AAAA-MM-DD

    // Verifica si ya existe una clase para el curso en la fecha actual
    $query_existencia_clase = "SELECT COUNT(*) AS existe
        FROM asistencia
        WHERE idCurso = $idCurso AND fecha = '$fecha'";

    $result_existencia_clase = mysqli_query($conexion, $query_existencia_clase);
    $row_existencia_clase = mysqli_fetch_assoc($result_existencia_clase);
    $clase_existente = (int)$row_existencia_clase['existe'];

    if ($clase_existente) {
        // La clase ya existe, muestra un mensaje o redirige a la página de edición de asistencia
        //  redirigir a la página de edición con los parámetros necesarios
        header("Location: editar_asistencia.php?fecha=$fecha&idCurso=$idCurso");
     //  echo ' holas';
        exit();
    } else {
        // La clase no existe, se realiza la inserción
        $query_insert_asistencia = "INSERT INTO asistencia (rutAlumno, idCurso, fecha, presente) 
            SELECT alumno.rut, $idCurso, '$fecha', 0
            FROM alumno
            INNER JOIN inscripcion ON alumno.rut = inscripcion.rutAlumno
            WHERE inscripcion.idCurso = $idCurso";

        $result_insert_asistencia = mysqli_query($conexion, $query_insert_asistencia);

        if ($result_insert_asistencia) {
            // La clase se ha creado y todos los alumnos se han marcado como ausentes

        

            // Redirige a la página de lista de alumnos en ese curso
            header("Location: editar_asistencia.php?fecha=$fecha&idCurso=$idCurso");
            exit();
        } else {
            // Manejo de errores si la inserción falla
            echo "Error al crear la clase de asistencia.";
        }
    }
}
?>
