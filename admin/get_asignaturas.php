<?php
include("../models/db.php");

if (isset($_POST['curso'])) {
    $idCurso = $_POST['curso'];

    $consultaAsignaturas = "SELECT idAsignatura, nombre FROM asignatura WHERE idCurso = ?";
    $stmt = mysqli_prepare($conexion, $consultaAsignaturas);
    mysqli_stmt_bind_param($stmt, "i", $idCurso);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $asignaturas = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $asignaturas[] = $row;
    }

    echo json_encode($asignaturas);
} else {
    
    echo json_encode(array());
}
