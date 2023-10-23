<?
include("../models/db.php");
include("grafico_model.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Generar Gráfico de Promedios</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.debug.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Selecciona un Curso y una Asignatura</h1>
    <form id="formularioCursos">
        <label for="curso">Curso:</label>
        <select name="curso" id="curso">
            <option value="">Seleccione un curso</option> <!-- Opción vacía por defecto -->
            <!-- Opciones de cursos se cargarán dinámicamente -->
        </select>

        <label for="asignatura">Asignatura:</label>
        <select name="asignatura" id="asignatura">
            <!-- Opciones de asignaturas se cargarán dinámicamente -->
        </select>

        <input type="submit" value="Generar Gráfico">
    </form>

    <h2>Promedios de Calificaciones</h2>
    <p>Curso: <span id="nombreCurso"></span></p>
    <p>Asignatura: <span id="nombreAsignatura"></span></p>
    <canvas id="chart-container"></canvas>
    <button id="descargar-grafico">Descargar Gráfico</button>

    <script>
        var myChart; // Variable para almacenar el gráfico actual

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

            // Agregar evento al botón de descarga
            var descargarBoton = document.getElementById("descargar-grafico");
            descargarBoton.addEventListener("click", function () {
                // Crear un PDF con jsPDF
                var pdf = new jsPDF();
                pdf.text(10, 10, "Gráfico de Promedios de Calificaciones");

                // Obtener el nombre del curso y la asignatura
                var nombreCurso = $('#nombreCurso').text();
                var nombreAsignatura = $('#nombreAsignatura').text();
                var nombrePDF = "Promedios_" + nombreCurso + "_" + nombreAsignatura + ".pdf";

                // Agregar el nombre del curso y la asignatura al título del PDF
                pdf.text(10, 20, "Curso: " + nombreCurso);
                pdf.text(10, 30, "Asignatura: " + nombreAsignatura);

                // Obtener la imagen del gráfico como base64
                var graficoBase64 = document.getElementById("chart-container").toDataURL("image/png");

                // Agregar la imagen al PDF
                pdf.addImage(graficoBase64, "PNG", 10, 40, 180, 100);

                // Descargar el PDF con el nombre personalizado
                pdf.save(nombrePDF);
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