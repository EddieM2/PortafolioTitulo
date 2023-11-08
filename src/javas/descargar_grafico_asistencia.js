// descargar_grafico_pdf.js

// Función para descargar el gráfico en formato PDF
function descargarGraficoPDF() {
    // Obtiene el contenedor del gráfico
    var graficoContainer = document.getElementById("graficosContainer");

    // convertir el contenedor en una imagen
    html2canvas(graficoContainer).then(function(canvas) {
        var imgData = canvas.toDataURL('image/jpeg');

        
        var doc = new jsPDF();
        doc.addImage(imgData, 'PNG', 10, 10, 190, 100);

        // Descarga el PDF
        doc.save('grafico_asistencia.pdf');
    });
}


var descargarGraficoButton = document.getElementById("descargarGrafico");
descargarGraficoButton.addEventListener("click", descargarGraficoPDF);
