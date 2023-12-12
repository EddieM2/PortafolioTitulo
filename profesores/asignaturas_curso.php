<?php
include("../models/db.php");

// Verificar la sesión y los parámetros de la URL
//if (!isset($_SESSION['rut']) || $_SESSION['cargo_id'] != 2) {
  // header("Location: login.php");
   // exit();
//}

// Obtener el RUT del profesor desde la sesión
$rut_profesor = $_SESSION['rut'];

// Obtener el nombre y apellido paterno del profesor mediante una consulta SQL
$info_profesor_query = "SELECT nombre, apellidoP FROM profesor WHERE rut = '$rut_profesor'";
$info_profesor_result = mysqli_query($conexion, $info_profesor_query);

if (!$info_profesor_result) {
    die("Error al obtener la información del profesor: " . mysqli_error($conexion));
}

$profesor = mysqli_fetch_assoc($info_profesor_result);
$nombre_profesor = $profesor['nombre'];
$apellido_paterno_profesor = $profesor['apellidoP'];

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
    <link rel="stylesheet" href="../src/css/mensajes.css">
</head>
<body>
    <div class="panel">
        <h1>Bienvenido, <?php echo $nombre_profesor . ' ' . $apellido_paterno_profesor; ?> (Profesor)</h1>
        
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
    <a href="inicioprofesores.php">Inicio</a>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conexion);
?>



