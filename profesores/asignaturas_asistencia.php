
<?php include("../models/db.php") ?>
<?php


// Verificar si el usuario ha iniciado sesión como profesor
//if (!isset($_SESSION['rut']) || $_SESSION['cargo_id'] != 2) {
    // Si no ha iniciado sesión como profesor, redirigir a la página de inicio de sesión
  //  header("Location: login.php");
    //exit();
//}

// Obtener el RUT del profesor desde la sesión
$rut_profesor = $_SESSION['rut'];
$nombre_profesor = $_SESSION['user']; // Nombre del profesor



if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consultar los cursos del profesor
$cursos_query = "SELECT DISTINCT c.idCurso, c.nombre AS nombre_curso
                 FROM curso c
                 INNER JOIN asignatura a ON c.idCurso = a.idCurso
                 WHERE a.rutProfesor = '$rut_profesor'";

$cursos_result = mysqli_query($conexion, $cursos_query);

if (!$cursos_result) {
    die("Error en la consulta de cursos: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos y Asignaturas</title>
    <link rel="stylesheet" href="../src/css/profes.css">
</head>
<body class="body">
    <div class="custom-card"> <!-- Agregar la tarjeta personalizada -->
        <div class="custom-card-body"> <!-- Cuerpo de la tarjeta -->
            <h1>Bienvenido, <?php echo $nombre_profesor; ?> (Profesor)</h1> <!-- Mover el título "Bienvenido, profesor" aquí -->
            <h2>Curso y Asignaturas:</h2> <!-- Mover el título "Curso y Asignaturas" aquí -->
            <ul class="subject-list">
                <?php
                while ($curso = mysqli_fetch_assoc($cursos_result)) {
                    echo "<li class='course-card'>";
                    echo "<strong class='course-name'>Curso:</strong> " . htmlspecialchars($curso['nombre_curso']) . "<br>";

                    // Consultar las asignaturas de este curso para el profesor
                    $idCurso = $curso['idCurso'];
                    $asignaturas_query = "SELECT idAsignatura, nombre FROM asignatura WHERE idCurso = $idCurso AND rutProfesor = '$rut_profesor'";
                    $asignaturas_result = mysqli_query($conexion, $asignaturas_query);

                    if (!$asignaturas_result) {
                        die("Error en la consulta de asignaturas: " . mysqli_error($conexion));
                    }

                    echo "<strong class='subject-label'>Asignaturas:</strong><br>";
                    echo "<ul class='subject-card'>";
                    while ($asignatura = mysqli_fetch_assoc($asignaturas_result)) {
                        echo "<li>";
                        echo htmlspecialchars($asignatura['nombre']);

                        // Botón para crear la clase de ese día
                        echo " <a class='btn' href='crear_clase.php?idCurso={$curso['idCurso']}'>Crear clase</a>";

                        // Botón para ver las clases creadas
                        echo " <a class='btn' href='clases_creadas.php?idCurso={$curso['idCurso']}'>Clases creadas</a>";
                        echo "</li>";
                    }
                    echo "</ul>";

                    echo "</li>";
                }
                ?>
            </ul>
        </div>
    </div>
    <button class="btn-back" onclick="window.history.back();"><i class="fas fa-arrow-left"></i> Volver Atrás</button>
    <form action="../includes/logout.php" method="post">
    <button type="submit" name="logout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
</form>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
