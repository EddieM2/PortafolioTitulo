<?php include("../models/db.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gráfico de Asistencia</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dom-to-image/2.6.0/dom-to-image.min.js"></script>
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
                    <div id="graficosContainer">
                        <!-- Aqui si mostrara la targeta -->
                    </div>

                    <!-- Aqui se mostrara el curso seleccionado -->
                    <div id="cursoSeleccionado"></div>
                </div>
            </div>
        </div>
    </main>

    
    <script src="../src/javas/descargar_grafico_asistencia.js"></script>
</body>
</html>
