<?php include("../models/db.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gráfico de Asistencia</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>

    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
 
    <script src="../node_modules/html2canvas/dist/html2canvas.min.js"></script>

</head>
<body>
    <h1>Gráfico de Asistencia</h1>

    <!-- Formulario para seleccionar el curso -->
    <form id="formularioAsistencia" action="../models/adminModels/controlador_grafico_asistencia.php" method="post">
        <label for="curso">Selecciona un curso:</label>
        <select name="curso" id="curso">
            <?php
            // Obtiene los cursos desde la base de datos
            $queryCursos = "SELECT idCurso, nombre AS nombreCurso FROM curso";
            $resultCursos = mysqli_query($conexion, $queryCursos);

            while ($curso = mysqli_fetch_assoc($resultCursos)) {
                echo "<option value='" . $curso['idCurso'] . "'>" . $curso['nombreCurso'] . "</option>";
            }
            ?>
        </select>
        <button type="submit" name="obtenerGrafico">Generar Gráfico</button>
    </form>

    <!-- Lugar para mostrar el gráfico -->
    <div style="width: 40%; max-width: 1000px; margin: 0 auto;">
        <canvas id="graficoAsistencia" width="1000" height="400"></canvas>
    </div>

    <button id="descargarGrafico">Descargar Gráfico</button>

    <script>
        // Datos para el gráfico
        var meses = <?php echo json_encode($meses); ?>;
        var porcentajeAsistencias = <?php echo json_encode($porcentajeAsistencias); ?>;

        // Configuración del gráfico
        var ctx = document.getElementById('graficoAsistencia').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: meses,
                datasets: [{
                    label: 'Porcentaje de Asistencias',
                    data: porcentajeAsistencias,
                    borderColor: 'blue',
                    fill: false
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        title: {
                            display: true,
                            text: 'Porcentaje de Asistencias'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Mes'
                        }
                    }
                }
            }
        });


    </script>
    <script src="../../src/javas/descargar_grafico_asistencia.js"></script>
</body>
</html>
