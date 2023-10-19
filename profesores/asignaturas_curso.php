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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<!DOCTYPE html>
<link rel="stylesheet" href="../src/css/mensajes.css">

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos y Asignaturas</title>
    <link rel="stylesheet" href="../src/css/mensajes.css">
</head>
<body>
    <div class="panel">
        <h1>Bienvenido, <?php echo $nombre_profesor; ?> (Profesor)</h1>
        
        <div class="panel-body">
            <h2>Cursos y Asignaturas:</h2>

            <ul>
                <?php
                while ($curso = mysqli_fetch_assoc($cursos_result)) {
                    echo "<li>";
                    echo "<strong>Curso:</strong> " . htmlspecialchars($curso['nombre_curso']) . "<br>";

                    // Consultar las asignaturas de este curso para el profesor
                    $idCurso = $curso['idCurso'];
                    $asignaturas_query = "SELECT idAsignatura, nombre FROM asignatura WHERE idCurso = $idCurso AND rutProfesor = '$rut_profesor'";
                    $asignaturas_result = mysqli_query($conexion, $asignaturas_query);

                    if (!$asignaturas_result) {
                        die("Error en la consulta de asignaturas: " . mysqli_error($conexion));
                    }

                    echo "<strong>Asignaturas:</strong><br>";
                    echo "<ul>";
                    while ($asignatura = mysqli_fetch_assoc($asignaturas_result)) {
                        echo "<li>";
                        echo htmlspecialchars($asignatura['nombre']);

                        // Contar mensajes no leídos para esta asignatura
                        $idAsignatura = $asignatura['idAsignatura'];
                        $mensajes_no_leidos_query = "SELECT COUNT(*) AS cantidad FROM mensajes WHERE idCurso = $idCurso AND idAsignatura = $idAsignatura AND leido = 0";
                        $mensajes_no_leidos_result = mysqli_query($conexion, $mensajes_no_leidos_query);

                        if (!$mensajes_no_leidos_result) {
                            die("Error al contar mensajes no leídos: " . mysqli_error($conexion));
                        }

                        $mensajes_no_leidos = mysqli_fetch_assoc($mensajes_no_leidos_result);
                        $cantidad_no_leidos = (int)$mensajes_no_leidos['cantidad'];

                     
                        echo " <a href='ver_mensajes.php?idAsignatura=" . $asignatura['idAsignatura'] . "&idCurso=$idCurso'>Ver Mensajes";
                        if ($cantidad_no_leidos > 0) {
                            echo " ($cantidad_no_leidos no leídos)";
                        }
                        echo "</a>";
                        echo "</li>";
                    }
                    echo "</ul>";

                    echo "</li>";
                }
                ?>
            </ul>
        </div>
    </div>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>
