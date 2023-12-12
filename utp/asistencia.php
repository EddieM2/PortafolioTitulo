<?php
// Conexión a la base de datos
include("../models/db.php");

// Consulta SQL para obtener la lista de cursos
$queryCursos = "SELECT idCurso, nombre FROM curso";
$resultCursos = mysqli_query($conexion, $queryCursos);

if (!$resultCursos) {
    echo "Error al obtener la lista de cursos.";
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="../src/css/profes.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<div class="card">
<body>

<h1>Porcentaje de Asistencia por Curso</h1>

<div id="asistenciaResult">
    <!-- se mostrará el resultado del porcentaje de asistencia en esta parte -->
</div>

<script>
    $(document).ready(function() {
        // Realiza una solicitud AJAX para obtener el porcentaje de asistencia para todos los cursos
        $.ajax({
            type: "POST",
            url: "obtener_asistencia.php", 
            success: function(response) {
                $("#asistenciaResult").html(response);
            }
        });
    });
</script>
</div>
</body>
</html>
