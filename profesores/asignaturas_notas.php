<?php include("../models/db.php"); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
<?php
// Verificar si el usuario ha iniciado sesión como profesor
// if (!isset($_SESSION['rut']) || $_SESSION['cargo_id'] != 2) {
// Si no ha iniciado sesión como profesor, redirigir a la página de inicio de sesión
// header("Location: login.php");
// exit();
// }

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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos y Asignaturas</title>
    <link rel="stylesheet" href="../src/css/profes.css">
</head>
<body>
    <div class="card">
        <h1>Bienvenido, <?php echo $nombre_profesor; ?> (Profesor)</h1>

        <h2>Cursos y Asignaturas:</h2>

        <ul>
            <?php
            while ($curso = mysqli_fetch_assoc($cursos_result)) {
                echo "<li class='course-card'>";
                echo "<strong>Curso:</strong> " . htmlspecialchars($curso['nombre_curso']);
                echo "<div class='subject-list'>";
                
                // Consultar las asignaturas de este curso para el profesor
                $idCurso = $curso['idCurso'];
                $asignaturas_query = "SELECT idAsignatura, nombre FROM asignatura WHERE idCurso = $idCurso AND rutProfesor = '$rut_profesor'";
                $asignaturas_result = mysqli_query($conexion, $asignaturas_query);

                if (!$asignaturas_result) {
                    die("Error en la consulta de asignaturas: " . mysqli_error($conexion));
                }

                echo "<strong>Asignaturas:</strong><br>";
                echo "<ul class='subject-card'>";
                while ($asignatura = mysqli_fetch_assoc($asignaturas_result)) {
                    echo "<li>";
                    echo "<span>" . htmlspecialchars($asignatura['nombre']) . "</span>";
                    echo "<a class='btn' href='ingresar_notas.php?asignatura={$asignatura['idAsignatura']}&idCurso={$curso['idCurso']}'>Ingresar Notas</a>";
                    echo "</li>";
                }
                echo "</ul>";
                echo "</div>";

                echo "</li>";
            }
            ?>
        </ul>
    </div>
    <button class="btn-back" onclick="window.history.back();"><i class="fas fa-arrow-left"></i> Volver Atrás</button>
    <form action="../includes/logout.php" method="post">
    <button type="submit" name="logout" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
</form>



</body>
</html>
