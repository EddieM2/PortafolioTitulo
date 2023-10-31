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
</head>
<body>
    <h2>Formularios Enviados</h2>
    <table border="1">
        <tr>
            <th>Titulo/th>
            <th>Descripcion</th>
            <th>Tipo</th>
            <th>Fecha</th>
    
        </tr>

        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
      //      echo "<td>" . htmlspecialchars($row['id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['titulo']) . "</td>";
            echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
            echo "<td>" . htmlspecialchars($row['tipo']) . "</td>";
            echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
         
           // echo '<td><a href="responder_formulario_salud.php?id=' . $row['id'] . '">Responder</a></td>';
            echo "</tr>";
        }
        ?>

    </table>
</body>
</html>
