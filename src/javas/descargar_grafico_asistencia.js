var anchoPersonalizado = 700;  // Establece el ancho personalizado en píxeles
var altoPersonalizado = 700;  // Establece el alto personalizado en píxeles

document.getElementById('descargarGrafico').addEventListener('click', function() {
    // Ocultar los botones antes de la captura
    document.getElementById('descargarGrafico').style.display = 'none';
    document.getElementById('formularioAsistencia').style.display = 'none';

    // Captura el contenido del gráfico con un tamaño personalizado
    html2canvas(graficoAsistencia, { width: anchoPersonalizado, height: altoPersonalizado }).then(function(canvas) {
        var pdf = new jsPDF();
        // Agrega el gráfico al PDF con margen
        pdf.addImage(canvas.toDataURL('image/png'), 'PNG', 10, 10);  // Añade un margen de 10 unidades

        // Agrega el nombre del curso seleccionado al PDF
        var nombreCurso = document.getElementById('curso').value;
        pdf.text(10, 10, 'Curso: ' + nombreCurso);
        // Descarga el PDF
        pdf.save('grafico_asistencia.pdf');

        // Mostrar los botones nuevamente después de la captura
        document.getElementById('descargarGrafico').style.display = 'block';
        document.getElementById('formularioAsistencia').style.display = 'block';
    });
});
