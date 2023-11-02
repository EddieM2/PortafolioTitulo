<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css">
</head>
<body>
<div class="container mt-5"> <!-- Agregar un contenedor Bootstrap para centrar el contenido -->
    <div class="custom-card"> <!-- Aplicar la clase "card" de Bootstrap y espacio superior -->
        <div class="custom-card-body"> <!-- Agregar un contenedor de cuerpo de tarjeta -->
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
                    echo "<h1 class='card-title'>Lista de Alumnos para la Asignatura</h1>"; // Estilo de título de tarjeta
                    echo "<div class='table-container'>";
                    echo "<form method='post' action='../models/profesoresModels/procesar_notas.php'>";
                    echo "<input type='hidden' name='asignatura_id' value='$asignatura_id'>";
                    echo "<input type='hidden' name='idCurso' value='$idCurso'>";
                    
                    echo "<div class='table-responsive'>";
                    echo "<table class='table table-striped table-inside-card'>"; // Estilo de tabla de Bootstrap
                    echo "<thead class='thead-dark'>"; // Estilo de encabezado de tabla de Bootstrap
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

                        $promedio = null;
                        if (
                            $calificaciones['calificacion1'] !== null &&
                            $calificaciones['calificacion2'] !== null &&
                            $calificaciones['calificacion3'] !== null &&
                            $calificaciones['calificacion4'] !== null
                        ) {
                            $promedio = ($calificaciones['calificacion1'] + $calificaciones['calificacion2'] + $calificaciones['calificacion3'] + $calificaciones['calificacion4']) / 4;
                        }

                        echo "<tr>";
                        echo "<td>$rut_alumno</td>";
                        echo "<td>$nombre_alumno</td>";
                        echo "<td>$apellidoP</td>";
                        echo "<td>$apellidoM</td>";
                        echo "<td><input type='number' name='calificaciones[$rut_alumno][calificacion1]' step='0.01' value='" . ($calificaciones['calificacion1'] ?? '') . "'></td>";
                        echo "<td><input type='number' name='calificaciones[$rut_alumno][calificacion2]' step='0.01' value='" . ($calificaciones['calificacion2'] ?? '') . "'></td>";
                        echo "<td><input type='number' name='calificaciones[$rut_alumno][calificacion3]' step='0.01' value='" . ($calificaciones['calificacion3'] ?? '') . "'></td>";
                        echo "<td><input type='number' name='calificaciones[$rut_alumno][calificacion4]' step='0.01' value='" . ($calificaciones['calificacion4'] ?? '') . "'></td>";
                        echo "<td>" . ($promedio ? number_format($promedio, 2) : '') . "</td>";
                        echo "</tr>";
                    }
                    echo "</tbody>";
                    echo "</table>";

                    echo "<input type='submit' value='Guardar Notas'>";
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
