<?php
include("../models/db.php");
include("modelo_grafico_calificaciones.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["obtenerPromedios"])) {
    $idCurso = $_POST["curso"];
    $idAsignatura = $_POST["asignatura"];

    // Llama a la función del modelo para obtener los promedios
    $promedios = obtenerPromediosCalificaciones($conexion, $idCurso, $idAsignatura);

    if ($promedios) {
        // Prepara los datos para el gráfico
        $labels = ["Calificación 1", "Calificación 2", "Calificación 3", "Calificación 4"];
        $datos = [
            $promedios['promedioCalificacion1'],
            $promedios['promedioCalificacion2'],
            $promedios['promedioCalificacion3'],
            $promedios['promedioCalificacion4']
        ];

        // Convierte los datos a formato JSON para que Chart.js los pueda usar
        $datosJSON = json_encode($datos);

        // No incluyas la vista, ya que el gráfico se generará en la misma página
    } else {
        // Maneja el caso en el que no se obtuvieron promedios
        echo "No se pudieron obtener los promedios.";
    }
}
?>
