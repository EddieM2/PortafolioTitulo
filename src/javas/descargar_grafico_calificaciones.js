function descargarGraficoPDF() {
     // Crea una nueva instancia de jsPDF
     var pdf = new jsPDF();
 
     // Captura el contenido del gráfico utilizando el método `toDataUrl`
     var canvas = document.getElementById('graficoPromedioCalificaciones');
     var imageData = canvas.toDataURL('image/jpeg', 1.0);
 
     // Agrega la imagen del gráfico al PDF
     pdf.addImage(imageData, 'JPEG', 10, 10, 190, 100);  // Ajusta el tamaño y posición según tus necesidades
 
     // Agrega el nombre del curso y la asignatura al PDF
     var nombreCurso = document.getElementById('curso').value;
     var nombreAsignatura = document.getElementById('asignatura').value;
     pdf.text(10, 120, 'Curso: ' + nombreCurso);
     pdf.text(10, 130, 'Asignatura: ' + nombreAsignatura);
 
     // Guarda el PDF o muéstralo al usuario
     pdf.save('grafico_calificaciones.pdf');
 }
 