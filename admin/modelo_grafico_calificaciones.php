<?php include("../models/db.php") ?>
<?php
function obtenerPromediosCalificaciones($conexion, $idCurso, $idAsignatura) {
    $query = "SELECT 
        AVG(calificacion1) AS promedioCalificacion1,
        AVG(calificacion2) AS promedioCalificacion2,
        AVG(calificacion3) AS promedioCalificacion3,
        AVG(calificacion4) AS promedioCalificacion4
        FROM calificaciones 
        WHERE idAsignatura = $idAsignatura AND idCurso = $idCurso";

    $result = mysqli_query($conexion, $query);

    if ($result) {
        $promedios = mysqli_fetch_assoc($result);

        return $promedios;
    } else {
        return false;
    }
}
?>