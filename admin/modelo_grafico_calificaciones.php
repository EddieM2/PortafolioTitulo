<?php
//conexion base de datos
include("db.php");

class GraficoModel {
    public function obtenerPromedioCalificaciones($idCurso, $idAsignatura) {
        $consulta = "SELECT AVG(calificacion1) AS promedio1, AVG(calificacion2) AS promedio2, AVG(calificacion3) AS promedio3, AVG(calificacion4) AS promedio4
                     FROM calificaciones
                     WHERE idCurso = $idCurso AND idAsignatura = $idAsignatura";

        $resultado = mysqli_query($conexion, $consulta);

        if ($resultado) {
            return mysqli_fetch_assoc($resultado);
        } else {
            return false;
        }
    }
}
?>
