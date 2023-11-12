

<?php
include("../models/db.php");
include("grafico_model.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generar Gráfico de Promedios</title>
    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/graficos.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1>Gráfico de Promedios</h1>
            </div>
            <div class="card-body">
                <div id="contenedorFormulario">
                    <h1>Selecciona un Curso y una Asignatura</h1>
                    <form id="formularioCursos">
                        <div class="form-group">
                            <label for="curso">Curso:</label>
                            <select name="curso" id="curso">
                                <option value="">Seleccione un curso</option> 
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="asignatura">Asignatura:</label>
                            <select name="asignatura" id="asignatura"></select>
                        </div>

                        <div class="form-group">
                        <input type="submit" value="Generar Gráfico" class="btn-generar-grafico">
                        </div>
                    </form>
                </div>

                <div id="graficosContainer" class="chart-container">
                    <h2>Promedios de Calificaciones</h2>
                    <p>Curso: <span id="nombreCurso"></span></p>
                    <p>Asignatura: <span id="nombreAsignatura"></span></p>
                    <canvas id="chart-container"></canvas>
                    <button id="descargar-grafico" class="btn-descargar-grafico">Descargar Gráfico</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../src/javas/descargar_grafico_calificaciones.js"></script>

    <script>
        var myChart; 

        // Crea el gráfico con los datos obtenidos
        function crearGrafico(promedios) {
            // Verificar si ya existe un gráfico y destruirlo
            if (myChart) {
                myChart.destroy();
            }

            var ctx = document.getElementById("chart-container").getContext("2d");
            myChart = new Chart(ctx, {
                type: "line",
                data: {
                    labels: ["Calificación 1", "Calificación 2", "Calificación 3", "Calificación 4"],
                    datasets: [
                        {
                            label: "Promedios de Calificaciones",
                            data: [
                                promedios.promedio1,
                                promedios.promedio2,
                                promedios.promedio3,
                                promedios.promedio4
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
        }

        // JavaScript para cargar cursos y asignaturas dinámicamente
        $(document).ready(function() {
            // Cargar cursos
            $.ajax({
                type: 'GET',
                url: 'cargar_cursos.php',
                dataType: 'json',
                success: function(data) {
                    var cursoSelect = $("#curso");
                    cursoSelect.empty();
                    cursoSelect.append($("<option>", {
                        value: "",
                        text: "Seleccione un curso"
                    }));
                    $.each(data, function(index, curso) {
                        cursoSelect.append($("<option>", {
                            value: curso.id,
                            text: curso.nombre
                        }));
                    });

                    // Cuando se selecciona un curso, cargar asignaturas
                    cursoSelect.change(function() {
                        var selectedCurso = $(this).val();
                        var asignaturaSelect = $("#asignatura");

                        // Limpia la lista de asignaturas
                        asignaturaSelect.empty();

                        // Cargar las asignaturas correspondientes al curso seleccionado
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
                            }
                        });
                    });
                }
            });

            // Manejar el envío del formulario
            $("#formularioCursos").submit(function(event) {
                event.preventDefault(); // Evitar el envío del formulario
                var selectedCurso = $("#curso").val();
                var selectedAsignatura = $("#asignatura").val();

                // Realizar una solicitud AJAX para obtener los promedios
                $.ajax({
                    type: 'POST',
                    url: 'obtener_promedios.php',
                    data: { curso: selectedCurso, asignatura: selectedAsignatura },
                    dataType: 'json',
                    success: function(data) {
                        crearGrafico(data);
                        $('#nombreCurso').text(data.nombreCurso);
                        $('#nombreAsignatura').text(data.nombreAsignatura);
                    },
                    error: function() {
                        alert("Error al obtener los datos del gráfico.");
                    }
                });
            });
        });
    </script>
</body>
</html>
