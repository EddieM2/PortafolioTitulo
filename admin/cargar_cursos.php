<?php
include("../models/db.php");

$consultaCursos = "SELECT idCurso, nombre FROM curso";
$resultadoCursos = mysqli_query($conexion, $consultaCursos);

$cursos = array();

while ($row = mysqli_fetch_assoc($resultadoCursos)) {
    $cursos[] = array(
        'id' => $row['idCurso'],
        'nombre' => $row['nombre']
    );
}

echo json_encode($cursos);

mysqli_close($conexion);
?>
