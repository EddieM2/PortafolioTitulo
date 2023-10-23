<?php
include("../models/db.php");

if (isset($_POST['curso']) && isset($_POST['asignatura'])) {
    $idCurso = $_POST['curso'];
    $idAsignatura = $_POST['asignatura'];

    $consultaNombreCurso = "SELECT nombre FROM curso WHERE idCurso = $idCurso";
    $resultadoNombreCurso = mysqli_query($conexion, $consultaNombreCurso);

    $consultaNombreAsignatura = "SELECT nombre FROM asignatura WHERE idAsignatura = $idAsignatura";
    $resultadoNombreAsignatura = mysqli_query($conexion, $consultaNombreAsignatura);

    $nombreCurso = "";
    $nombreAsignatura = "";

    if ($resultadoNombreCurso && $row = mysqli_fetch_assoc($resultadoNombreCurso)) {
        $nombreCurso = $row['nombre'];
    }

    if ($resultadoNombreAsignatura && $row = mysqli_fetch_assoc($resultadoNombreAsignatura)) {
        $nombreAsignatura = $row['nombre'];
    }

    $consultaPromedios = "SELECT AVG(calificacion1) AS promedio1, AVG(calificacion2) AS promedio2, AVG(calificacion3) AS promedio3, AVG(calificacion4) AS promedio4
                         FROM calificaciones
                         WHERE idCurso = $idCurso AND idAsignatura = $idAsignatura";

    $resultadoPromedios = mysqli_query($conexion, $consultaPromedios);

    if ($resultadoPromedios) {
        $promedios = mysqli_fetch_assoc($resultadoPromedios);

        $response = array(
            'promedio1' => $promedios['promedio1'],
            'promedio2' => $promedios['promedio2'],
            'promedio3' => $promedios['promedio3'],
            'promedio4' => $promedios['promedio4'],
            'nombreCurso' => $nombreCurso,
            'nombreAsignatura' => $nombreAsignatura,
        );

        echo json_encode($response);
    } else {
        echo json_encode(array('error' => 'No se pudieron obtener los promedios.'));
    }
}

mysqli_close($conexion);
