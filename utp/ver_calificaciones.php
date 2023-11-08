<?php
// Conexión a la base de datos
include("../models/db.php");

// Verificar si se ha seleccionado un curso
if (isset($_POST['curso'])) {
    $idCurso = $_POST['curso'];

    // Consulta SQL para obtener las asignaturas del curso seleccionado
    $query = "SELECT idAsignatura, nombre FROM asignatura WHERE idCurso = $idCurso";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        // Mostrar las asignaturas y el botón "Ver Notas" en cada una
        echo "<h1>Asignaturas del Curso</h1>";
        echo "<ul>";
        while ($row = mysqli_fetch_assoc($result)) {
            $idAsignatura = $row['idAsignatura'];
            $nombreAsignatura = $row['nombre'];
            echo "<li>$nombreAsignatura";
            echo "<form action='ver_notas.php' method='post'>";
            echo "<input type='hidden' name='curso' value='$idCurso'>";
            echo "<input type='hidden' name='asignatura' value='$idAsignatura'>";
            echo "<button type='submit'>Ver Notas</button>";
            echo "</form>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "Error al obtener las asignaturas del curso.";
    }
} else {
    echo "No se ha seleccionado un curso.";
}
?>
