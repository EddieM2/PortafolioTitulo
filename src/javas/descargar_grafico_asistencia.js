$(document).ready(function() {
    var graficoIndex = 1;

    // Elimina eventos click existentes 
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
                    graficoCanvas.width = 1200; // Aumenta el ancho del gráfico
                    graficoCanvas.height = 600; // Aumenta el alto del gráfico

                    document.getElementById("graficosContainer").appendChild(graficoCanvas);

                    var ctx = graficoCanvas.getContext("2d");
                    var myChart = new Chart(ctx, {
                        type: "line",
                        data: {
                            labels: data.meses,
                            datasets: [{
                                label: "Porcentaje de Asistencias",
                                data: data.porcentajeAsistencias,
                                borderColor: "rgba(75, 192, 192, 1)",
                                borderWidth: 2
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

        // Forzar el fondo del contenedor a blanco
        graficoContainer.style.backgroundColor = 'white';

        // Convertir el contenedor en una imagen con mayor calidad
        html2canvas(graficoContainer, { scale: 2 }).then(function(canvas) {
            // Restaurar el fondo original después de la conversión
            graficoContainer.style.backgroundColor = '';

            var imgData = canvas.toDataURL('image/jpeg', 1.0); // Ajusta la calidad de la imagen

            var doc = new jsPDF();
            doc.text(10, 10, "Curso seleccionado: " + selectedCurso);
            doc.addImage(imgData, 'JPEG', 10, 30, 190, 100);

            // Reemplazar espacios en blanco y caracteres especiales en el nombre del curso para el nombre del PDF
            var nombreCursoPDF = selectedCurso.replace(/ /g, "_").replace(/[^\w\s]/gi, '') + "_grafico_asistencia.pdf";

            // Descargar el PDF
            doc.save(nombreCursoPDF);
        });
    });
});






