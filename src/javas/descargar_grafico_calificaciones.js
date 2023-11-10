// descargar_grafico_pdf.js



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
    pdf.addImage(graficoBase64, "PNG", 10, 50, 180, 100);

    // Descargar el PDF con el nombre personalizado
    pdf.save(nombrePDF);
});
