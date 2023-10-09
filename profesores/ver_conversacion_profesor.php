<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ver Conversación</title>
</head>
<body>
    <?php
    session_start();

    // Obtener el RUT del profesor desde la sesión
    $rut_profesor = $_SESSION['rut'];

    // Obtener los parámetros de la URL (idConversacion, idCurso, idAsignatura, idEmisor)
    if (isset($_GET['idConversacion']) && isset($_GET['idCurso']) && isset($_GET['idAsignatura']) && isset($_GET['idEmisor'])) {
        $idConversacion = $_GET['idConversacion'];
        $idCurso = $_GET['idCurso'];
        $idAsignatura = $_GET['idAsignatura'];
        $idEmisor = $_GET['idEmisor'];
    } else {
        // Si no se proporcionaron los parámetros requeridos, redirigir a la página anterior
        header("Location: cursos_asignaturas.php");
        exit();
    }

    // Conectar a la base de datos (ajusta la configuración de conexión según tu entorno)
    $conn = mysqli_connect('localhost', 'root', '', 'probando2');

    // Consulta para obtener el nombre del profesor
    $profesor_query = "SELECT nombre FROM usuarios WHERE rut = '$rut_profesor'";
    $profesor_result = mysqli_query($conn, $profesor_query);

    if (!$profesor_result) {
        die("Error al obtener el nombre del profesor: " . mysqli_error($conn));
    }

    // Consulta para obtener el nombre del apoderado
    $apoderado_query = "SELECT nombre FROM usuarios WHERE rut = '$idEmisor'";
    $apoderado_result = mysqli_query($conn, $apoderado_query);

    if (!$apoderado_result) {
        die("Error al obtener el nombre del apoderado: " . mysqli_error($conn));
    }

    $profesor_nombre = mysqli_fetch_assoc($profesor_result)['nombre'];
    $apoderado_nombre = mysqli_fetch_assoc($apoderado_result)['nombre'];

    // Consulta para obtener el nombre del curso
    $curso_query = "SELECT nombre FROM curso WHERE idCurso = $idCurso";
    $curso_result = mysqli_query($conn, $curso_query);

    if (!$curso_result) {
        die("Error al obtener el nombre del curso: " . mysqli_error($conn));
    }

    $curso_nombre = mysqli_fetch_assoc($curso_result)['nombre'];

    // Consulta para obtener el nombre de la asignatura
    $asignatura_query = "SELECT nombre FROM asignatura WHERE idAsignatura = $idAsignatura";
    $asignatura_result = mysqli_query($conn, $asignatura_query);

    if (!$asignatura_result) {
        die("Error al obtener el nombre de la asignatura: " . mysqli_error($conn));
    }

    $asignatura_nombre = mysqli_fetch_assoc($asignatura_result)['nombre'];

    // Consultar los mensajes de la conversación
    echo "ID de Conversación: $idConversacion"; // Agrega esta línea para depurar
    $mensajes_query = "SELECT m.idMensaje, m.mensaje, m.fechaenvio, u.nombre AS nombre_emisor, m.leido
                      FROM mensajes m
                      INNER JOIN usuarios u ON m.idEmisor = u.rut
                      WHERE m.idConversacion = $idConversacion";

    $mensajes_result = mysqli_query($conn, $mensajes_query);

    if (!$mensajes_result) {
        die("Error en la consulta de mensajes: " . mysqli_error($conn));
    }
    ?>

    <h1>Conversación con <?php echo $apoderado_nombre; ?></h1>

    <h2>Profesor: <?php echo $profesor_nombre; ?></h2>
    <p>Curso: <?php echo $curso_nombre; ?></p>
    <p>Asignatura: <?php echo $asignatura_nombre; ?></p>

    <h2>Mensajes:</h2>

    <ul>
        <?php
        while ($mensaje = mysqli_fetch_assoc($mensajes_result)) {
            echo "<li>";
            echo "<strong>Fecha de Envío:</strong> " . htmlspecialchars($mensaje['fechaenvio']) . "<br>";
            echo "<strong>Emisor:</strong> " . htmlspecialchars($mensaje['nombre_emisor']) . "<br>";
            echo "<strong>Mensaje:</strong> " . htmlspecialchars($mensaje['mensaje']);

            if ($mensaje['leido'] == 0) {
                echo "<em>(No leído)</em>";
            } else {
                echo "<em>(Leído)</em>";
            }

            echo "</li>";
        }
        ?>
    </ul>

    <form method="post" action="../models/profesoresModels/controlador_ver_conversacion.php">
        <input type="hidden" name="idConversacion" value="<?php echo $idConversacion; ?>">
        <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>">
        <input type="hidden" name="idAsignatura" value="<?php echo $idAsignatura; ?>">
        <input type="hidden" name="idEmisor" value="<?php echo $idEmisor; ?>">
        <label for="mensaje">Escribir Mensaje:</label>
        <textarea id="mensaje" name="mensaje" rows="4" cols="50"></textarea>
        <br>
        <input type="submit" value="Enviar Mensaje">
    </form>
    <a href="cursos_asignaturas.php">Volver a la Lista de Cursos y Asignaturas</a>
    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>
