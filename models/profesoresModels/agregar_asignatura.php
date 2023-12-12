<?php
include("../db.php");

if (isset($_POST['agregar_asignatura'])) {
    $nombreAsignatura = $_POST['nueva_asignatura'];
    $rutProfesor = $_POST['nuevo_profesor'];
    $idCurso = $_POST['nuevo_curso']; 

    // Recupera el valor máximo actual de idAsignatura
    $queryMaxId = "SELECT MAX(idAsignatura) AS max_id FROM asignatura";
    $resultMaxId = mysqli_query($conexion, $queryMaxId);
    $rowMaxId = mysqli_fetch_assoc($resultMaxId);

    if ($rowMaxId['max_id'] !== null) {
        $nuevoIdAsignatura = $rowMaxId['max_id'] + 1;
    } else {
        $nuevoIdAsignatura = 1; // Si no hay registros previos, comienza desde 1
    }

    // Escapa los valores para evitar inyección de SQL
    $nombreAsignatura = mysqli_real_escape_string($conexion, $nombreAsignatura);
    $rutProfesor = mysqli_real_escape_string($conexion, $rutProfesor);

    // Inserta la nueva asignatura en la tabla, incluyendo el idCurso
    $query = "INSERT INTO asignatura (idAsignatura, nombre, rutProfesor, idCurso) VALUES ('$nuevoIdAsignatura', '$nombreAsignatura', '$rutProfesor', '$idCurso')";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        // Éxito: la asignatura se ha agregado correctamente
        header("Location: administrarCursosAsignaturas.php");
        exit; // detiene el script luego de la redirrecion
    } else {
        // controlar el error
        echo "Error al agregar la asignatura: " . mysqli_error($conexion);
    }
}

// Cierra la conexión a la base de datos
mysqli_close($conexion);
?>
