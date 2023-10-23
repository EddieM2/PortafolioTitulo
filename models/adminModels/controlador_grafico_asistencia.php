<?php
include("../db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["obtenerGrafico"])) {
    $idCurso = $_POST["curso"];

    // Consulta SQL para obtener los datos de asistencia por mes
    $sql = "SELECT YEAR(fecha) AS anio, MONTH(fecha) AS mes, 
                   SUM(presente) AS asistencias, COUNT(*) AS total_dias
            FROM asistencia
            WHERE idCurso = $idCurso
            GROUP BY anio, mes";

    $result = $conexion->query($sql);

    // Inicializa arrays para almacenar los datos
    $meses = array();
    $porcentajeAsistencias = array();
    $totalDiasRegistrados = array();
    $totalDiasPresentes = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $anio = $row["anio"];
            $mes = $row["mes"];
            $asistencias = $row["asistencias"];
            $totalDias = $row["total_dias"];

            $mesNombre = DateTime::createFromFormat('!m', $mes)->format('F');
            $meses[] = "$mesNombre $anio";

            // Calcula el porcentaje de asistencias
            $porcentaje = ($asistencias / $totalDias) * 100;
            $porcentajeAsistencias[] = round($porcentaje, 1);

            // Almacena el total de días registrados y el total de días en los que los alumnos estuvieron presentes
            $totalDiasRegistrados[] = $totalDias;
            $totalDiasPresentes[] = $asistencias;
        }
    }

    // Devuelve los datos como JSON
    $response = json_encode([
        'meses' => $meses,
        'porcentajeAsistencias' => $porcentajeAsistencias,
        'totalDiasRegistrados' => $totalDiasRegistrados,
        'totalDiasPresentes' => $totalDiasPresentes,
    ]);

    header('Content-Type: application/json');
    echo $response;
    exit;
}
?>
