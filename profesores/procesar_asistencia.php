<?php
include("../models/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['fecha'], $_POST['idCurso'], $_POST['asistencia'])) {
    $fecha = $_POST['fecha'];
  //  $idAsignatura = $_POST['idAsignatura'];
    $idCurso = $_POST['idCurso'];
    $asistencia = $_POST['asistencia'];

    // Realiza un bucle para procesar la asistencia de cada alumno
    foreach ($asistencia as $rutAlumno => $presente) {
        // Actualiza el registro de asistencia para el alumno
        $query_actualizar_asistencia = "UPDATE asistencia SET presente = $presente WHERE fecha = '$fecha' AND idCurso = $idCurso AND rutAlumno = '$rutAlumno'";
        $result_actualizar_asistencia = mysqli_query($conexion, $query_actualizar_asistencia);

        if (!$result_actualizar_asistencia) {
            echo "Error al actualizar la asistencia del alumno con RUT $rutAlumno.";
            exit();
        }
    }

    // Redirige de vuelta a la página de "Clases Creadas"
    header("Location: editar_asistencia.php?fecha=$fecha&idCurso=$idCurso&resultado=exito");

    exit();
} else {
    echo "Faltan parámetros en la solicitud o no se ha enviado la asistencia.";
}
?>
