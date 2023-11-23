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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Curso y Asignatura</title>
    <link rel="stylesheet" href="../src/css/graficos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            background-color: #125E5E;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            margin-top: 5rem;
        }

        .card {
            background-color: #fff;
            color: #125E5E;
            border: 2px solid #125E5E;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            width: 120%;
            max-width: 1050px;
        }

        .btn-primary {
            background-color: #125E5E;
            border-color: #125E5E;
        }

        #calificacionesTable {
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="custom-card-body">
                        <h1 class="text-center">Seleccionar Curso y Asignatura</h1>

                        <form action="#" method="post" id="seleccionarCursoForm">
                            <div class="mb-3">
                                <label for="curso" class="form-label">Selecciona un curso:</label>
                                <select name="curso" id="curso" class="form-select">
                                    <?php
                                    while ($rowCurso = mysqli_fetch_assoc($resultCursos)) {
                                        $idCurso = $rowCurso['idCurso'];
                                        $nombreCurso = $rowCurso['nombre'];
                                        echo "<option value='$idCurso'>$nombreCurso</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="asignatura" class="form-label">Selecciona una asignatura:</label>
                                <select name="asignatura" id="asignatura" class="form-select">
                                    <!-- Las opciones de asignatura se cargarán dinámicamente aquí -->
                                </select>
                            </div>

                            <div class="text-center">
                                <button type="submit" id="verCalificacionesBtn" class="btn btn-primary">Ver Calificaciones</button>
                            </div>
                        </form>

                        <div id="calificacionesTable" class="mt-4">
                            <!-- Aquí se mostrará la tabla de calificaciones -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
