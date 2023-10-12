

<?php

session_start();
// Verificar si el usuario ha iniciado sesión como profesor
//if (!isset($_SESSION['rut']) || $_SESSION['cargo_id'] != 2) {
    // Si no ha iniciado sesión como profesor, redirigir a la página de inicio de sesión
  //  header("Location: login.php");
    //exit();
//}

// Obtener el RUT del profesor desde la sesión
$rut_profesor = $_SESSION['rut'];
$nombre_profesor = $_SESSION['user']; // Nombre del profesor

// Conectar a la base de datos (ajusta la configuración de conexión según tu entorno)
$conn = mysqli_connect('localhost', 'root', '', 'probando2');

if (!$conn) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Consultar los cursos del profesor
$cursos_query = "SELECT DISTINCT c.idCurso, c.nombre AS nombre_curso
                 FROM curso c
                 INNER JOIN asignatura a ON c.idCurso = a.idCurso
                 WHERE a.rutProfesor = '$rut_profesor'";

$cursos_result = mysqli_query($conn, $cursos_query);

if (!$cursos_result) {
    die("Error en la consulta de cursos: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cursos y Asignaturas</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $nombre_profesor; ?> (Profesor)</h1>
    
    <h2>Cursos y Asignaturas:</h2>

    <ul>
        <?php
        while ($curso = mysqli_fetch_assoc($cursos_result)) {
            echo "<li>";
            echo "<strong>Curso:</strong> " . htmlspecialchars($curso['nombre_curso']) . "<br>";

            // Consultar las asignaturas de este curso para el profesor
            $idCurso = $curso['idCurso'];
            $asignaturas_query = "SELECT idAsignatura, nombre FROM asignatura WHERE idCurso = $idCurso AND rutProfesor = '$rut_profesor'";
            $asignaturas_result = mysqli_query($conn, $asignaturas_query);

            if (!$asignaturas_result) {
                die("Error en la consulta de asignaturas: " . mysqli_error($conn));
            }

            echo "<strong>Asignaturas:</strong><br>";
            echo "<ul>";
            while ($asignatura = mysqli_fetch_assoc($asignaturas_result)) {
                echo "<li>";
                echo htmlspecialchars($asignatura['nombre']);

           

  



                // Contar mensajes no leídos para esta asignatura
              


                // Boton para crear la clase de ese dia
                echo " <a href='crear_clases.php?asignatura={$asignatura['idAsignatura']}&idCurso={$curso['idCurso']}'>Ingresar asistencia</a>";
                echo " <a href='clases_creadas.php?asignatura={$asignatura['idAsignatura']}&idCurso={$curso['idCurso']}'>clases creadas</a>";
                echo "</a>";
                echo "</li>";
            }
            echo "</ul>";

            echo "</li>";
        }
        ?>
    </ul>

    <a href="logout.php">Cerrar Sesión</a>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
mysqli_close($conn);
?>