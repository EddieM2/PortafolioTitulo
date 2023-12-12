<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css">
    <style>
        /* Estilo para ocultar la fila del promedio */
        .hidden-row {
            display: none;
        }

        .card-limit-height {
            max-height: 500px; 
            overflow-y: auto; /* Agrega una barra de desplazamiento si el contenido es más largo */
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Recupera el promedio almacenado localmente al cargar la página
            var storedPromedio = localStorage.getItem('promedio');
            var promedioFinalCell = document.getElementById('promedio_final');

            if (storedPromedio && promedioFinalCell) {
                promedioFinalCell.textContent = storedPromedio;
                // Muestra la fila del promedio
                var hiddenRow = document.querySelector('.hidden-row');
                hiddenRow.style.display = 'table-row';
            }
        });

        function calcularPromedio() {
            var rows = document.querySelectorAll('table tbody tr');
            var totalCalificaciones = 0;
            var totalAlumnos = 0;

            rows.forEach(function (row) {
                var inputs = row.querySelectorAll('input[type="number"]');
                var promedio = 0;
                var count = 0;

                inputs.forEach(function (input) {
                    var calificacion = parseFloat(input.value);
                    if (!isNaN(calificacion)) {
                        // Redondea cada calificación a dos decimales antes de sumar
                        calificacion = parseFloat(calificacion.toFixed(2));
                        promedio += calificacion;
                        count++;
                    }
                });

                if (count > 0) {
                    // Redondea el promedio a dos decimales antes de asignar al campo
                    promedio /= count;
                    promedio = parseFloat(promedio.toFixed(2));

                    var promedioCell = row.querySelector('.promedio');
                    if (promedioCell) {
                        promedioCell.textContent = promedio.toFixed(1);  // Muestra el promedio con un decimal
                    }
                    totalCalificaciones += promedio;
                    totalAlumnos++;
                }
            });

            if (totalAlumnos > 0) {
                var promedioFinal = totalCalificaciones / totalAlumnos;
                // Redondea el promedio final a dos decimales antes de asignar al campo
                promedioFinal = parseFloat(promedioFinal.toFixed(2));

                var promedioFinalCell = document.getElementById('promedio_final');
                if (promedioFinalCell) {
                    promedioFinalCell.textContent = promedioFinal.toFixed(1);  // Muestra el promedio final con un decimal
                }
                // Asigna el valor al campo oculto para enviarlo al servidor
                var promedioField = document.getElementById('promedio');
                if (promedioField) {
                    promedioField.value = promedioFinal.toFixed(2);  // Conserva el valor real con dos decimales para el servidor
                }

                // Almacena el promedio final localmente
                localStorage.setItem('promedio', promedioFinal.toFixed(1));

                // Muestra la fila del promedio
                var hiddenRow = document.querySelector('.hidden-row');
                hiddenRow.style.display = 'table-row';
            }
        }

        function guardarNotas() {
            var formData = new FormData(document.getElementById('notasForm'));

            // Ejemplo con fetch:
            fetch('../models/profesoresModels/procesar_notas.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                // Manejar la respuesta 
                console.log(data);
            })
            .catch(error => {
                // Manejar errores
                console.error('Error:', error);
            });
        }
    </script>
</head>
<body>
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body card-limit-height">
                <?php
                include("../models/db.php");

                if (isset($_GET['asignatura'])) {
                    $asignatura_id = $_GET['asignatura'];
                    $idCurso = $_GET['idCurso'];

                    $query_alumnos = "SELECT alumno.rut, alumno.nombre AS nombre_alumno, alumno.apellidoP, alumno.apellidoM
                    FROM alumno
                    INNER JOIN inscripcion ON alumno.rut = inscripcion.rutAlumno
                    WHERE inscripcion.idCurso IN (
                        SELECT idCurso FROM asignatura WHERE idAsignatura = $asignatura_id
                    )";
                    $result_alumnos = mysqli_query($conexion, $query_alumnos);

                    if ($result_alumnos) {
                        echo "<h1 class='card-title'>Lista de Alumnos para la Asignatura</h1>";
                        echo "<div class='table-container'>";
                        echo "<form id='notasForm'>";
                        echo "<input type='hidden' name='asignatura_id' value='$asignatura_id'>";
                        echo "<input type='hidden' name='idCurso' value='$idCurso'>";
                        // Agrega el campo oculto para el promedio
                        echo "<input type='hidden' name='promedio' id='promedio' value=''>";

                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-striped table-inside-card'>";
                        echo "<thead class='thead-dark'>";
                        echo "<tr><th>RUT</th><th>Nombre del Alumno</th><th>Apellido Paterno</th><th class='d-none d-sm-table-cell'>Apellido Materno</th><th>Nota 1</th><th>Nota 2</th><th>Nota 3</th><th>Nota 4</th><th>Promedio</th></tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row_alumno = mysqli_fetch_assoc($result_alumnos)) {
                            $rut_alumno = $row_alumno['rut'];
                            $nombre_alumno = $row_alumno['nombre_alumno'];
                            $apellidoP = $row_alumno['apellidoP'];
                            $apellidoM = $row_alumno['apellidoM'];

                            $query_calificaciones = "SELECT calificacion1, calificacion2, calificacion3, calificacion4
                                                FROM calificaciones
                                                WHERE idAlumno = '$rut_alumno' AND idAsignatura = $asignatura_id AND idCurso = $idCurso";
                            $result_calificaciones = mysqli_query($conexion, $query_calificaciones);

                            $calificaciones = [
                                'calificacion1' => null,
                                'calificacion2' => null,
                                'calificacion3' => null,
                                'calificacion4' => null
                            ];

                            if ($result_calificaciones) {
                                $calificaciones = mysqli_fetch_assoc($result_calificaciones);
                            }

                            echo "<tr>";
                            echo "<td>$rut_alumno</td>";
                            echo "<td>$nombre_alumno</td>";
                            echo "<td>$apellidoP</td>";
                            echo "<td>$apellidoM</td>";
                            echo "<td><input type='number' name='calificaciones[$rut_alumno][calificacion1]' value='" . ($calificaciones['calificacion1'] ?? '') . "'></td>";
                            echo "<td><input type='number' name='calificaciones[$rut_alumno][calificacion2]' value='" . ($calificaciones['calificacion2'] ?? '') . "'></td>";
                            echo "<td><input type='number' name='calificaciones[$rut_alumno][calificacion3]' value='" . ($calificaciones['calificacion3'] ?? '') . "'></td>";
                            echo "<td><input type='number' name='calificaciones[$rut_alumno][calificacion4]' value='" . ($calificaciones['calificacion4'] ?? '') . "'></td>";
                            echo "<td class='promedio'></td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";

                        echo "<table class='table table-striped table-inside-card'>";
                        //echo "<tbody class='hidden-row'>";
                        //echo "<tr><td colspan='4'></td><td>Promedio</td><td id='promedio_final'></td></tr>";
                        echo "</tbody>";
                        echo "</table>";

                        echo "<input type='button' value='Calcular Promedio' onclick='calcularPromedio();'>";
                        echo "<input type='button' value='Guardar Notas' onclick='guardarNotas();'>";
                        echo "</form>";
                        echo "</div>";
                    } else {
                        echo "Error al obtener la lista de alumnos.";
                    }
                } else {
                    echo "Falta el parámetro de asignatura_id en la URL.";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>


