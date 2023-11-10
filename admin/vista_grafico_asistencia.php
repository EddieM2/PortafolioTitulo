<?php include("../models/db.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gráfico de Asistencia</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
    <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../node_modules/html2canvas/dist/html2canvas.min.js"></script>
    <link rel="stylesheet" href="../src/css/graficos.css">
</head>
<body>
    <main>
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h1>Gráfico de Asistencia</h1>
                </div>
                <div class="card-body">
                    <!-- Formulario para seleccionar el curso -->
                    <form id="formularioAsistencia">
                        <div class="form-group">
                            <label for="curso">Selecciona un curso:</label>
                            <select class="form-control" name="curso" id="curso">
                                <?php
                                // Obtiene los cursos desde la base de datos
                                $queryCursos = "SELECT idCurso, nombre AS nombreCurso FROM curso";
                                $resultCursos = mysqli_query($conexion, $queryCursos);

                                while ($curso = mysqli_fetch_assoc($resultCursos)) {
                                    echo "<option value='" . $curso['idCurso'] . "'>" . $curso['nombreCurso'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="button" id="generar-grafico" class="btn btn-primary">Generar Gráfico</button>
                            <button type="button" id="descargarGrafico" class="btn btn-primary">Descargar Gráfico</button>
                        </div>
                    </form>

                    <!-- Lugar para mostrar los gráficos -->
                    <div id="graficosContainer" >
  <!-- Contenido de la tarjeta aquí -->
</div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            var graficoIndex = 1;

            document.getElementById("generar-grafico").addEventListener("click", function () {
                var selectedCurso = document.getElementById("curso").value;

                if (selectedCurso) {
                    // Borra el contenido del contenedor antes de agregar un nuevo gráfico
                    document.getElementById("graficosContainer").innerHTML = "";

                    // Realiza una petición AJAX para obtener los datos del gráfico
                    $.ajax({
                        url: "../models/adminModels/controlador_grafico_asistencia.php",
                        method: "POST",
                        data: { obtenerGrafico: true, curso: selectedCurso },
                        dataType: "json",
                        success: function (data) {
                            var graficoCanvas = document.createElement("canvas");
                            

                            graficoCanvas.id = "graficoAsistencia" + graficoIndex;
                            graficoCanvas.width = 1000;
                            graficoCanvas.height = 400;

                            document.getElementById("graficosContainer").appendChild(graficoCanvas);

                            var ctx = graficoCanvas.getContext("2d");
                            var myChart = new Chart(ctx, {
                                type: "line", // Tipo de gráfico: línea
                                data: {
                                    labels: data.meses,
                                    datasets: [{
                                        label: "Porcentaje de Asistencias",
                                        data: data.porcentajeAsistencias,
                                        borderColor: "rgba(75, 192, 192, 1)", // Color de la línea
                                        borderWidth: 2 // Ancho de la línea
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            max: 100
                                        }
                                    }
                                }
                            });

                            graficoIndex++;
                        },
                        error: function () {
                            alert("Error al obtener los datos del gráfico.");
                        }
                    });
                } else {
                    alert("Selecciona un curso primero.");
                }
            });
        });
    </script>

    <script src="../src/javas/descargar_grafico_asistencia.js"></script>
</body>
</html>
