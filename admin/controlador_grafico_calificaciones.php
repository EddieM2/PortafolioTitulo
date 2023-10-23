<?php
include("modelo_grafico_calificaciones.php");

// Obtener cursos desde la base de datos
$queryCursos = "SELECT idCurso, nombre AS nombreCurso FROM curso";
$resultCursos = mysqli_query($conexion, $queryCursos);

// Obtener asignaturas desde la base de datos
$queryAsignaturas = "SELECT idAsignatura, nombre AS nombreAsignatura FROM asignatura";
$resultAsignaturas = mysqli_query($conexion, $queryAsignaturas);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["obtenerPromedios"])) {
    $idCurso = $_POST["curso"];
    $idAsignatura = $_POST["asignatura"];

    $promedios = obtenerPromediosCalificaciones($conexion, $idCurso, $idAsignatura);

    if ($promedios) {
        $datosJSON = json_encode($promedios);
        echo "<script>var datosJSON = $datosJSON;</script>";
        echo "<script>var curso = '$idCurso';</script>";
        echo "<script>var asignatura = '$idAsignatura';</script>";
    } else {
        echo "No se pudieron obtener los promedios.";
    }
}

// Incluye la vista después de definir las variables
include("grafico_calificaciones.php");
?>
