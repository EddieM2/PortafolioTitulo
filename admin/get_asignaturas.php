<?php
//conexion a la base de datos
include("../models/db.php");

if (isset($_POST['curso'])) {
    $idCurso = $_POST['curso'];
//consulta para obtener la asignatura y el nombre seleccionado
    $consultaAsignaturas = "SELECT idAsignatura, nombre FROM asignatura WHERE idCurso = ?";
    $stmt = mysqli_prepare($conexion, $consultaAsignaturas);
    mysqli_stmt_bind_param($stmt, "i", $idCurso);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $asignaturas = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $asignaturas[] = $row;
    }
//devolver como json
    echo json_encode($asignaturas);
} else {
    
    echo json_encode(array());
}
