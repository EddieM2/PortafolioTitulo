<?php
// Incluye el archivo de configuración de la base de datos
include("../models/db.php");

// Realiza la consulta SQL para recuperar los formularios y respuestas
$sql = "SELECT * FROM denuncias";
$result = mysqli_query($conexion, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

// HTML para mostrar los formularios y respuestas en una tabla
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ver Formularios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css">
</head>
<body>
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body">
                <h2 class="card-title">Formularios Enviados</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Fecha</th>
                        </tr>

                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['titulo']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tipo']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                            echo "</tr>";
                        }
                        ?>

                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
