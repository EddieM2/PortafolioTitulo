<?php
include("../models/db.php");

// Verificar si se recibió el idCurso por GET
if (isset($_GET['idCurso'])) {
    $idCurso = $_GET['idCurso'];

    // Consulta SQL para obtener las clases creadas filtradas por idCurso
    $query_clases_creadas = "SELECT DISTINCT fecha, idCurso FROM asistencia WHERE idCurso = $idCurso ORDER BY fecha DESC";
    $result_clases_creadas = mysqli_query($conexion, $query_clases_creadas);

    if (!$result_clases_creadas) {
        die("Error al obtener las clases creadas: " . mysqli_error($conexion));
    }
} else {
    // Si no se recibió el idCurso, redirigir a la página anterior
    header("Location: editar_asistencia.php"); 
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clases Creadas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css"> <!-- Enlace a Bootstrap -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"> <!-- Enlace a Font Awesome -->
    <link rel="stylesheet" href='../src/css/profes.css'> 
    <style>
        .card {
            max-height: 600px; 
            overflow-y: auto; 
        }

        .table-responsive {
            overflow-x: auto; 
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
                if (isset($result_clases_creadas)) {
                    echo "<div class='table-responsive'>"; 
                    echo "<table class='table table-bordered'>"; 
                    echo "<thead class='thead-dark'>"; 
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
                    echo "No hay clases creadas para el curso seleccionado.";
                }
                ?>
            </div>
        </div>
    </div>
    <button class='btn btn-secondary' onclick='window.history.back();'><i class='fas fa-arrow-left'></i> Volver Atrás</button>
</body>
</html>
