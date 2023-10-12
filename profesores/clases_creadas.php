<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clases Creadas</title>
</head>
<body>
    
    <table border="1">
        <tr>
          
        </tr>
        <!-- Aquí se mostrarán las clases creadas -->
        <?php

include("../models/db.php");

// Consulta SQL para obtener las clases creadas ordenadas por fecha
$query_clases_creadas = "SELECT DISTINCT fecha, idAsignatura, idCurso FROM asistencia ORDER BY fecha DESC";
$result_clases_creadas = mysqli_query($conexion, $query_clases_creadas);

if ($result_clases_creadas) {
    echo "<h1>Clases Creadas</h1>";
    echo "<table border='1'>";
    echo "<tr>";
    echo "<th>Fecha</th>";
    echo "<th>Asignatura</th>";
    echo "<th>Curso</th>";
    echo "<th>Acción</th>";
    echo "</tr>";

    while ($row_clase = mysqli_fetch_assoc($result_clases_creadas)) {
        echo "<tr>";
        echo "<td>" . $row_clase['fecha'] . "</td>";
        echo "<td>" . $row_clase['idAsignatura'] . "</td>";
        echo "<td>" . $row_clase['idCurso'] . "</td>";
        echo "<td><a href='editar_asistencia.php?fecha=" . $row_clase['fecha'] . "&idAsignatura=" . $row_clase['idAsignatura'] . "&idCurso=" . $row_clase['idCurso'] . "'>Registrar Asistencia</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "Error al obtener las clases creadas.";
}
?>


    </table>
</body>
</html>
