<?php
// Incluye el archivo de configuración de la base de datos
include("../models/db.php");

// Realiza la consulta SQL para recuperar los formularios y respuestas
$sql = "SELECT * FROM respuestas_salud";
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
</head>
<body>
    <h2>Formularios Enviados</h2>
    <table border="1">
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
            <th>explicacion</th>
        
        </tr>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
      //      echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['rut_alumno']) . "</td>";
            echo "<td>" . htmlspecialchars($row['tristeza']) . "</td>";
            echo "<td>" . htmlspecialchars($row['autolesiones']) . "</td>";
            echo "<td>" . htmlspecialchars($row['cambios_sueño']) . "</td>";
            echo "<td>" . htmlspecialchars($row['concentracion']) . "</td>";
            echo "<td>" . htmlspecialchars($row['apoyo_amigos']) . "</td>";
            echo "<td>" . htmlspecialchars($row['conflictos']) . "</td>";
            echo "<td>" . htmlspecialchars($row['consumo_sustancias']) . "</td>";
            echo "<td>" . htmlspecialchars($row['autoestima']) . "</td>";
            echo "<td>" . htmlspecialchars($row['explicacion']) . "</td>";
           // echo '<td><a href="responder_formulario_salud.php?id=' . $row['id'] . '">Responder</a></td>';
            echo "</tr>";
        }
        ?>

    </table>
</body>
</html>
