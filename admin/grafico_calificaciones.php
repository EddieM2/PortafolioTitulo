<?php
// Realizar la conexión a la base de datos
include("../models/db.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gráfico de Calificaciones</title>
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
                    <h1>Gráfico de Calificaciones</h1>
                </div>
                <div class="card-body">
                    <h1>Selecciona un Curso y una Asignatura</h1>
                    <form id="formularioCursos">
                        <div class="form-group">
                            <label for="curso">Curso:</label>
                            <select class="form-control" name="curso" id="curso">
                                <option value="">Seleccione un curso</option>
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
                            <label for="asignatura">Asignatura:</label>
                            <select class="form-control" name="asignatura" id="asignatura"></select>
                        </div>
                        <div class="form-group">
                        <input type="submit" value="Generar Gráfico" class="btn-generar-grafico">
                        <button id="descargar-grafico" class="btn-descargar-grafico">Descargar Gráfico</button>
                        <script src="../src/javas/descargar_grafico_calificaciones.js"></script>

                        

                        </div>
                    </form>

                    <!-- Lugar para mostrar los gráficos -->
                    <div id="graficosContainer">
                        <!-- Contenido del gráfico aquí -->
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            var graficoIndex = 1;

            // Cargar las asignaturas correspondientes al curso seleccionado
            $("#curso").change(function() {
                var selectedCurso = $(this).val();
                var asignaturaSelect = $("#asignatura");

                // Limpiar la lista de asignaturas
                asignaturaSelect.empty();

                // Realizar una petición AJAX para cargar las asignaturas correspondientes al curso seleccionado
                $.ajax({
                    type: 'GET',
                    url: 'cargar_asignaturas.php',
                    data: { curso: selectedCurso },
                    dataType: 'json',
                    success: function(data) {
                        $.each(data, function(index, asignatura) {
                            asignaturaSelect.append($("<option>", {
                                value: asignatura.id,
                                text: asignatura.nombre
                            }));
                        });
                    },
                    error: function() {
                        alert("Error al cargar las asignaturas.");
                    }
                });
            });

            // Generar el gráfico cuando se envía el formulario
            $("#formularioCursos").submit(function(event) {
                event.preventDefault(); // Evitar el envío del formulario
                var selectedCurso = $("#curso").val();
                var selectedAsignatura = $("#asignatura").val();

                if (selectedCurso && selectedAsignatura) {
                    // Borra el contenido del contenedor antes de agregar un nuevo gráfico
                    document.getElementById("graficosContainer").innerHTML = "";

                    // Realiza una petición AJAX para obtener los datos del gráfico
                    $.ajax({
                        url: "obtener_promedios.php",
                        method: "POST",
                        data: { curso: selectedCurso, asignatura: selectedAsignatura },
                        dataType: "json",
                        success: function(data) {
                            var graficoCanvas = document.createElement("canvas");

                            graficoCanvas.id = "graficoCalificaciones" + graficoIndex;
                            graficoCanvas.width = 1000;
                            graficoCanvas.height = 400;

                            document.getElementById("graficosContainer").appendChild(graficoCanvas);

                            var ctx = graficoCanvas.getContext("2d");
                            var myChart = new Chart(ctx, {
                                type: "line", // Tipo de gráfico: línea
                                data: {
                                    labels: ["Calificación 1", "Calificación 2", "Calificación 3", "Calificación 4"],
                                    datasets: [
                                        {
                                            label: "Promedios de Calificaciones",
                                            data: [
                                                data.promedio1,
                                                data.promedio2,
                                                data.promedio3,
                                                data.promedio4
                                            ],
                                            backgroundColor: "rgba(75, 192, 192, 0.2)",
                                            borderColor: "rgba(75, 192, 192, 1)",
                                            borderWidth: 1
                                        }
                                    ]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });

                            graficoIndex++;
                        },
                        error: function() {
                            alert("Error al obtener los datos del gráfico.");
                        }
                    });
                } else {
                    alert("Selecciona un curso y una asignatura primero.");
                }
            });
        });
    </script>

    <script src="../src/javas/descargar_grafico_calificaciones.js"></script>
</body>
</html>
