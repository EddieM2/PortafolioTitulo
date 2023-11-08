<?php
// Conexión a la base de datos
include("../models/db.php");

// Consulta SQL para obtener la lista de cursos
$queryCursos = "SELECT idCurso, nombre FROM curso";
$resultCursos = mysqli_query($conexion, $queryCursos);

if (!$resultCursos) {
    echo "Error al obtener la lista de cursos.";
}

?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<h1>Seleccionar Curso y Asignatura</h1>

<form action="#" method="post" id="seleccionarCursoForm">
    <label for="curso">Selecciona un curso:</label>
    <select name="curso" id="curso">
        <?php
        while ($rowCurso = mysqli_fetch_assoc($resultCursos)) {
            $idCurso = $rowCurso['idCurso'];
            $nombreCurso = $rowCurso['nombre'];
            echo "<option value='$idCurso'>$nombreCurso</option>";
        }
        ?>
    </select>

    <label for="asignatura">Selecciona una asignatura:</label>
    <select name="asignatura" id="asignatura">
        <!-- Las opciones de asignatura se cargarán dinámicamente aquí -->
    </select>

    <button type="submit" id="verCalificacionesBtn">Ver Calificaciones</button>
</form>

<div id="calificacionesTable">
    <!-- Aquí se mostrará la tabla de calificaciones -->
</div>

<script>
    $(document).ready(function() {
        // Intercepta el cambio en la selección del curso
        $("#curso").change(function() {
            var selectedCurso = $(this).val();
            cargarAsignaturas(selectedCurso);
        });

        $("#seleccionarCursoForm").submit(function(event) {
            event.preventDefault();
            var selectedCurso = $("#curso").val();
            var selectedAsignatura = $("#asignatura").val();
            
            // Realiza una solicitud AJAX para obtener las calificaciones
            $.ajax({
                type: "POST",
                url: "obtener_calificaciones.php", // Debes crear este archivo PHP
                data: {
                    curso: selectedCurso,
                    asignatura: selectedAsignatura
                },
                success: function(response) {
                    $("#calificacionesTable").html(response);
                }
            });
        });
    });

    function cargarAsignaturas(cursoSeleccionado) {
        // Realiza una solicitud AJAX para obtener las asignaturas del curso seleccionado
        $.ajax({
            type: "POST",
            url: "obtener_asignaturas.php", // Debes crear este archivo PHP
            data: {
                curso: cursoSeleccionado
            },
            success: function(response) {
                // Actualiza el menú desplegable de asignaturas
                $("#asignatura").html(response);
            }
        });
    }

    // Carga las asignaturas al cargar la página
    var cursoInicial = $("#curso").val();
    cargarAsignaturas(cursoInicial);
</script>

</body>
</html>
