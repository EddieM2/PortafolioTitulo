<?php include("../models/db.php"); ?>
<?php


// Verificar si el usuario ha iniciado sesión como profesor
// if (!isset($_SESSION['rut']) || $_SESSION['cargo_id'] != 2) {
//     // Si no ha iniciado sesión como profesor, redirigir a la página de inicio de sesión
//     header("Location: login.php");
//     exit();
// }

// Obtener el RUT del profesor desde la sesión
$rut_profesor = $_SESSION['rut'];
$nombre_profesor = $_SESSION['user']; // Nombre del profesor

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

// Consultar solo el último mensaje de cada conversación relacionado con el curso y la asignatura
$mensajes_query = "SELECT m1.mensaje, m1.fechaenvio, m1.idConversacion, m1.idEmisor 
                  FROM mensajes m1
                  LEFT JOIN mensajes m2 
                  ON (m1.idConversacion = m2.idConversacion AND m1.fechaenvio < m2.fechaenvio)
                  WHERE m2.idConversacion IS NULL
                  AND m1.idCurso = $idCurso
                  AND m1.idAsignatura = $idAsignatura";

$mensajes_result = mysqli_query($conexion, $mensajes_query);

if (!$mensajes_result) {
    die("Error en la consulta de mensajes: " . mysqli_error($conexion));
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mensajes en Curso y Asignatura</title>
    <link rel="stylesheet" href="../src/css/mensajes.css">
    
</head>
<body>
    <div class="panel">
        <h1>Bienvenido, <?php echo $nombre_profesor; ?> (Profesor)</h1>
        
        <div class="panel-body">
            <h2>Curso y Asignatura:</h2>
            <?php
            // Consultar el nombre de la asignatura
            $asignatura_query = "SELECT nombre FROM asignatura WHERE idAsignatura = $idAsignatura";
            $asignatura_result = mysqli_query($conexion, $asignatura_query);

            if (!$asignatura_result) {
                die("Error al obtener el nombre de la asignatura: " . mysqli_error($conn));
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

            <p>Curso: <?php echo $nombreCurso; ?></p>
            <p>Asignatura: <?php echo $nombreAsignatura; ?></p>

            <h2>Mensajes:</h2>

            <!-- Mostrar indicación visual de mensajes no leídos -->
            <?php
            $mensajes_no_leidos_query = "SELECT COUNT(*) AS cantidad
                                    FROM mensajes
                                    WHERE idCurso = $idCurso
                                    AND idAsignatura = $idAsignatura
                                    AND leido = 0"; // Contar mensajes no leídos

            $mensajes_no_leidos_result = mysqli_query($conexion, $mensajes_no_leidos_query);

            if (!$mensajes_no_leidos_result) {
                die("Error al contar mensajes no leídos: " . mysqli_error($conexion));
            }

            $mensajes_no_leídos = mysqli_fetch_assoc($mensajes_no_leidos_result);

            if ($mensajes_no_leídos['cantidad'] > 0) {
                echo "<p>Tienes " . $mensajes_no_leídos['cantidad'] . " mensajes no leídos.</p>";
            }
            ?>

            <ul>
                <?php
                while ($mensaje = mysqli_fetch_assoc($mensajes_result)) {
                    echo "<li>";
                    echo "<strong>Fecha de Envío:</strong> " . htmlspecialchars($mensaje['fechaenvio']) . "<br>";
                    echo "<strong>Mensaje:</strong> " . htmlspecialchars($mensaje['mensaje']);

                    // Agregar enlace para ver todos los mensajes de la conversación
                    echo " <a href='ver_conversacion_profesor.php?idConversacion=" . $mensaje['idConversacion'] . "&idCurso=" . $idCurso . "&idAsignatura=" . $idAsignatura . "&idEmisor=" . $mensaje['idEmisor'] . "'>Ver Conversación</a>";

                    echo "</li>";
                }
                ?>
            </ul>

            <a href="lista_alumnos_para_enviar_mensaje.php?idCurso=<?php echo $idCurso; ?>&idAsignatura=<?php echo $idAsignatura; ?>">Enviar Nuevo Mensaje</a>

            <a href="cursos_asignaturas.php">Volver a la Lista de Cursos y Asignaturas</a>
            <a href="logout.php">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
