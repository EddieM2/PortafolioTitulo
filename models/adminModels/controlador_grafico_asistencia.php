<?php  include("../db.php"); ?>
<?php


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["obtenerGrafico"])) {
    $idCurso = $_POST["curso"];
    
    // Consulta SQL para obtener los datos de asistencia por mes para un curso específico
    $sql = "SELECT YEAR(fecha) AS anio, MONTH(fecha) AS mes, SUM(presente) AS asistencias 
            FROM asistencia 
            WHERE idCurso = $idCurso 
            GROUP BY anio, mes";
    
    $result = $conexion->query($sql);

    // Inicializa arrays para almacenar los datos
    $meses = array();
    $porcentajeAsistencias = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $anio = $row["anio"];
            $mes = $row["mes"];
            $asistencias = $row["asistencias"];

            // Calcula el total de días en el mes
            $totalDiasEnMes = cal_days_in_month(CAL_GREGORIAN, $mes, $anio);

            $mesNombre = DateTime::createFromFormat('!m', $mes)->format('F');
            $meses[] = "$mesNombre $anio";

            // Calcula el porcentaje de asistencias
            $porcentaje = ($asistencias / $totalDiasEnMes) * 100;
            $porcentajeAsistencias[] = round($porcentaje, 2);
        }
    }
}

// Incluye la vista
include("../../admin/vista_grafico_asistencia.php");
?>
