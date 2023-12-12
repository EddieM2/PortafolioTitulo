<?php
// Incluye el archivo de configuracion de la base de datos
include("../models/db.php");

// consulta para traer los formularios y respuestas
$sql = "SELECT * FROM respuestas_salud";
$result = mysqli_query($conexion, $sql);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="gb18030">
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
                            <th>Rut del Alumno</th>
                            <th>Tristeza</th>
                            <th>Autolesiones</th>
                            <th>Cambios en el Sueño</th>
                            <th>Concentración</th>
                            <th>Apoyo de Amigos</th>
                            <th>Conflictos</th>
                            <th>Consumo de Sustancias</th>
                            <th>Autoestima</th>
                            <th>Explicación</th>
                        </tr>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['rut_alumno']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['tristeza']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['autolesiones']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['cambios_sueno']) ."</td>";
                            echo "<td>" . htmlspecialchars($row['concentracion']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['apoyo_amigos']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['conflictos']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['consumo_sustancias']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['autoestima']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['explicacion']) . "</td>";
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
