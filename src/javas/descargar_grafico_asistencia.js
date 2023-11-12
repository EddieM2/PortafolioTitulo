$(document).ready(function() {
    var graficoIndex = 1;

    // Elimina eventos click existentes para evitar la vinculación doble
    $("#generar-grafico").off("click");

    // Vincula el evento click
    $("#generar-grafico").on("click", function () {
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

                    // Mostrar el curso seleccionado
                    $("#cursoSeleccionado").text("Curso seleccionado: " + $("#curso option:selected").text());

                    // Actualizar el índice del gráfico
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

    // Descargar gráfico en formato PDF
    $("#descargarGrafico").on("click", function () {
        var selectedCurso = $("#curso option:selected").text();

        // Obtener el contenedor del gráfico
        var graficoContainer = document.getElementById("graficosContainer");

        // Convertir el contenedor en una imagen
        html2canvas(graficoContainer).then(function(canvas) {
            var imgData = canvas.toDataURL('image/jpeg');

            var doc = new jsPDF();
            doc.text(10, 10, "Curso seleccionado: " + selectedCurso);
            doc.addImage(imgData, 'PNG', 10, 30, 190, 100);

            // Reemplazar espacios en blanco y caracteres especiales en el nombre del curso para el nombre del PDF
            var nombreCursoPDF = selectedCurso.replace(/ /g, "_").replace(/[^\w\s]/gi, '') + "_grafico_asistencia.pdf";

            // Descargar el PDF
            doc.save(nombreCursoPDF);
        });
    });
});
