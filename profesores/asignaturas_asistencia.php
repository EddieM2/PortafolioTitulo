<?php
include("../models/db.php");

// Obtener el RUT del profesor desde la sesión
$rut_profesor = $_SESSION['rut'];
$nombre_profesor = $_SESSION['user']; 

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

// Consultar el nombre y apellido paterno del profesor
$profesor_query = "SELECT nombre, apellidoP FROM profesor WHERE rut = '$rut_profesor'";
$profesor_result = mysqli_query($conexion, $profesor_query);

if (!$profesor_result) {
    die("Error en la consulta de datos del profesor: " . mysqli_error($conexion));
}

// Obtener el nombre y apellido paterno del profesor
if ($profesor_data = mysqli_fetch_assoc($profesor_result)) {
    $nombre_profesor = $profesor_data['nombre'] . ' ' . $profesor_data['apellidoP'];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos y Asignaturas</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href='../src/css/profes.css'>
</head>
<body class="body">
    <div class="custom-card">
        <div class="custom-card-body">
            <h1>Bienvenido, <?php echo $nombre_profesor; ?> </h1>
            <h2>Curso y Asignaturas:</h2>
            <ul class="subject-list">
                <?php
                while ($curso = mysqli_fetch_assoc($cursos_result)) {
                    echo "<li class='course-card'>";
                    echo "<strong class='course-name'>Curso:</strong> " . htmlspecialchars($curso['nombre_curso']) . "<br>";
                    echo "<ul class='subject-card'>";
                    echo " <a class='btn' href='crear_clase.php?idCurso={$curso['idCurso']}'>Crear clase</a>";
                    echo "<a class='btn' href='clases_creadas.php?idCurso={$curso['idCurso']}'>Clases creadas</a>";
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
