<?php
function obtenerDatosAsistencia($conexion) {
    // Consulta SQL para obtener los datos de asistencia por mes
    $sql = "SELECT YEAR(fecha) AS anio, MONTH(fecha) AS mes, SUM(presente) AS asistencias FROM asistencia GROUP BY anio, mes";
    $result = $conexion->query($sql);

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

    return [
        'meses' => $meses,
        'porcentajeAsistencias' => $porcentajeAsistencias,
    ];
}



?>
