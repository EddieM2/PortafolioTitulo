<?php
include("../models/db.php");

// Obtener el RUT del profesor desde la sesión
$rut_profesor = $_SESSION['rut'];

// Obtener los parámetros de la URL (idCurso e idAsignatura)
if (isset($_GET['idCurso']) && isset($_GET['idAsignatura'])) {
    $idCurso = $_GET['idCurso'];
    $idAsignatura = $_GET['idAsignatura'];
} else {
    // Si no se proporcionaron los parámetros requeridos, redirigir a la página anterior
    header("Location: cursos_asignaturas.php");
    exit();
}

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consultar la lista de alumnos inscritos en esta asignatura y curso
$alumnos_query = "SELECT alumno.rut, alumno.nombre AS nombre_alumno
FROM alumno
INNER JOIN inscripcion ON alumno.rut = inscripcion.rutAlumno
WHERE inscripcion.idCurso IN (
    SELECT idCurso FROM asignatura WHERE idAsignatura = $idAsignatura
    )";

$alumnos_result = mysqli_query($conexion, $alumnos_query);

if (!$alumnos_result) {
    die("Error en la consulta de alumnos: " . mysqli_error($conexion));
}

// Consultar el nombre de la asignatura
$asignatura_query = "SELECT nombre FROM asignatura WHERE idAsignatura = $idAsignatura";
$asignatura_result = mysqli_query($conexion, $asignatura_query);

if (!$asignatura_result) {
    die("Error al obtener el nombre de la asignatura: " . mysqli_error($conexion));
}

$asignatura = mysqli_fetch_assoc($asignatura_result);

// Consultar el nombre del curso
$curso_query = "SELECT nombre FROM curso WHERE idCurso = $idCurso";
$curso_result = mysqli_query($conexion, $curso_query);

if (!$curso_result) {
    die("Error al obtener el nombre del curso: " . mysqli_error($conexion));
}

$curso = mysqli_fetch_assoc($curso_result);

$nombreCurso = $curso['nombre'];
$nombreAsignatura = $asignatura['nombre'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Enviar Nuevo Mensaje</title>
    <link rel="stylesheet" href="../src/css/mensajes.css">
    <style>
        body { padding-top: 20px; }
        .panel { overflow: auto; max-height: 80vh; }
    </style>
</head>
<body>
<div class="panel"> 
    <h1>Enviar Nuevo Mensaje</h1>
    
    <h2>Curso: <?php echo $nombreCurso; ?></h2>
    <h2>Asignatura: <?php echo $nombreAsignatura; ?></h2>

    <h2>Lista de Alumnos:</h2>

    <ul>
        <?php
        while ($alumno = mysqli_fetch_assoc($alumnos_result)) {
            echo "<li>";
            echo "<strong>Nombre:</strong> " . htmlspecialchars($alumno['nombre_alumno']) . "<br>";
            echo "<strong>RUT:</strong> " . htmlspecialchars($alumno['rut']);

            // Agregar enlace para enviar mensaje a este alumno
            echo " <a href='../models/profesoresModels/verificar_conversacion_apoderado.php?rutAlumno=" . $alumno['rut'] . "&idCurso=" . $idCurso . "&idAsignatura=" . $idAsignatura . "'>Enviar Mensaje</a>";

            echo "</li>";
        }
        ?>
    </ul>

    <a href="ver_mensajes.php?idCurso=<?php echo $idCurso; ?>&idAsignatura=<?php echo $idAsignatura; ?>">Volver a Mensajes</a>
    <a href="logout.php">Cerrar Sesión</a>
</div>    
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
