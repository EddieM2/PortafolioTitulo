<?php include("db.php") ?>

<!DOCTYPE html>
<html>
<head>
    <title>Ingresar Notas</title>
</head>
<body>
    <?php
    
 //session_start();
    // Verifica si se ha proporcionado el parámetro de asignatura_id en la URL
    if (isset($_GET['asignatura_id'])) {
        $asignatura_id = $_GET['asignatura_id'];

        // Realiza una consulta SQL para obtener la lista de alumnos para esta asignatura
        // Reemplaza esto con tu consulta real
        $query_alumnos = "SELECT alumno.rut, alumno.nombre AS nombre_alumno
                          FROM alumno
                          INNER JOIN inscripcion ON alumno.rut = inscripcion.rutAlumno
                          WHERE inscripcion.idCurso IN (
                              SELECT idCurso FROM asignatura WHERE idAsignatura = $asignatura_id
                          )";
        $result_alumnos = mysqli_query($conexion, $query_alumnos);

        if ($result_alumnos) {
            echo "<h1>Lista de Alumnos para la Asignatura</h1>";
            echo "<form method='post' action='procesar_notas.php'>";
            echo "<input type='hidden' name='asignatura_id' value='$asignatura_id'>";
// ...

echo "<table>";
echo "<tr><th>RUT</th><th>Nombre del Alumno</th><th>Nota</th></tr>";

while ($row_alumno = mysqli_fetch_assoc($result_alumnos)) {
    $rut_alumno = $row_alumno['rut'];
    $nombre_alumno = $row_alumno['nombre_alumno'];

    // Aquí puedes mostrar una fila de la tabla con campos para ingresar notas
    echo "<tr>";
    echo "<td>$rut_alumno</td>";
    echo "<td>$nombre_alumno</td>";
    echo "<td><input type='number' name='calificaciones[$rut_alumno]' step='0.01'></td>"; // Corrección aquí
    echo "</tr>";
}

// ...


            echo "</table>";
            echo "<input type='submit' value='Guardar Notas'>";
            echo "</form>";
        } else {
            echo "Error al obtener la lista de alumnos.";
        }
    } else {
        echo "Falta el parámetro de asignatura_id en la URL.";
    }
    ?>
</body>
</html>
