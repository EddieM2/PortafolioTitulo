<?php
include("../models/db.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clases Creadas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"> <!-- Enlace a Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- Enlace a Font Awesome -->
    <link rel="stylesheet" href='../src/css/profes.css'> <!-- Agrega el enlace a tu archivo CSS -->
    <style>
        .card {
            max-height: 600px; /* Ajusta la altura máxima según tus necesidades */
            overflow-y: auto; /* Agrega una barra de desplazamiento vertical si es necesario */
        }

        .table-responsive {
            overflow-x: auto; /* Agrega una barra de desplazamiento horizontal si es necesario */
        }
    </style>
</head>
<body class="body">
    <div class="container">
        <div class="card"> <!-- Agregar la tarjeta personalizada -->
            <div class="card-body"> <!-- Cuerpo de la tarjeta -->
                <h1>Clases Creadas</h1>
                <!-- Aquí se mostrarán las clases creadas -->
                <?php
                // Consulta SQL para obtener las clases creadas ordenadas por fecha
                $query_clases_creadas = "SELECT DISTINCT fecha, idCurso FROM asistencia ORDER BY fecha DESC";
                $result_clases_creadas = mysqli_query($conexion, $query_clases_creadas);

                if ($result_clases_creadas) {
                    echo "<div class='table-responsive'>"; // Agregar clase para hacer que la tabla sea responsive
                    echo "<table class='table table-bordered'>"; // Utilizar clases de Bootstrap para una tabla ordenada
                    echo "<thead class='thead-dark'>"; // Agregar un encabezado oscuro
                    echo "<tr>";
                    echo "<th>Fecha</th>";
                    echo "<th>Curso</th>";
                    echo "<th>Acción</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody>";

                    while ($row_clase = mysqli_fetch_assoc($result_clases_creadas)) {
                        echo "<tr>";
                        echo "<td>" . $row_clase['fecha'] . "</td>";
                        echo "<td>" . $row_clase['idCurso'] . "</td>";
                        echo "<td><a class='btn btn-primary' href='editar_asistencia.php?fecha=" . $row_clase['fecha'] . "&idCurso=" . $row_clase['idCurso'] . "'>Registrar Asistencia</a></td>";
                        echo "</tr>";
                    }

                    echo "</tbody>";
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "Error al obtener las clases creadas.";
                }
                ?>
            </div>
        </div>
    </div>
    <button class='btn btn-secondary' onclick='window.history.back();'><i class='fas fa-arrow-left'></i> Volver Atrás</button>
</body>
</html>
