<?php include("../models/db.php");?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gráfico de Promedio de Calificaciones</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>

<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Gráfico de Promedio de Calificaciones</h1>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["obtenerPromedios"])) {
        // Se han enviado datos, muestra el gráfico
        // Crear un contenedor para el gráfico
        echo '<div style="width: 800px; height: 400px;"><canvas id="graficoPromedioCalificaciones"></canvas></div>';
    }
    ?>

    <form id="formularioCalificaciones" method="post">
        <label for "curso">Selecciona un curso (ID):</label>
        <select name="curso" id="curso">
            <?php
            $queryCursos = "SELECT idCurso, nombre AS nombreCurso FROM curso";
            $resultCursos = mysqli_query($conexion, $queryCursos);

            while ($curso = mysqli_fetch_assoc($resultCursos)) {
                echo "<option value='" . $curso['idCurso'] . "'>" . $curso['nombreCurso'] . "</option>";
            }
            ?>
        </select>

        <label for "asignatura">Selecciona una asignatura (ID):</label>
        <select name="asignatura" id="asignatura">
            <?php
            $queryAsignaturas = "SELECT idAsignatura, nombre AS nombreAsignatura FROM asignatura";
            $resultAsignaturas = mysqli_query($conexion, $queryAsignaturas);

            while ($asignatura = mysqli_fetch_assoc($resultAsignaturas)) {
                echo "<option value='" . $asignatura['idAsignatura'] . "'>" . $asignatura['nombreAsignatura'] . "</option>";
            }
            ?>
        </select>

        <button type="submit" name="obtenerPromedios">Crear gráfico</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["obtenerPromedios"])) {
        // Se han enviado datos, muestra el nombre del curso y la asignatura
        $nombreCurso = $_POST["curso"];
        $nombreAsignatura = $_POST["asignatura"];
        echo "<p>Curso: $nombreCurso</p>";
        echo "<p>Asignatura: $nombreAsignatura</p>";
    }
    ?>

    <script>
        // Datos y configuración del gráfico (debes completar con tus propios datos)
        var data = {
            labels: ["Calificación 1", "Calificación 2", "Calificación 3", "Calificación 4"],
            datasets: [
                {
                    label: "Promedio de Calificaciones",
                    data: [5, 6, 7, 8], // Ejemplo de datos
                    backgroundColor: "rgba(75, 192, 192, 0.2)",
                    borderColor: "rgba(75, 192, 192, 1)",
                    borderWidth: 1
                }
            ]
        };

        var options = {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 10
                }
            }
        };

        // Crear un objeto de gráfico
        var ctx = document.getElementById("graficoPromedioCalificaciones").getContext("2d");
        var myChart = new Chart(ctx, {
            type: "line",
            data: data,
            options: options
        });
    </script>

    <!-- Botón para descargar el gráfico en PDF -->
    <button id="descargarGrafico" onclick="descargarGraficoPDF()">Descargar Gráfico</button>


    <script src="../src/javas/descargar_grafico_calificaciones.js"></script>
</body>
</html>

