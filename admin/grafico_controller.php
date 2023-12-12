<?php
//inclusion del modelo
include("grafico_model.php");
//conexion a la base de datos
include("../models/db.php");

if (!$conexion) {
    die("Error en la conexión a la base de datos: " . mysqli_connect_error());
}

if (isset($_POST['curso']) && isset($_POST['asignatura'])) {
    $idCurso = $_POST['curso'];
    $idAsignatura = $_POST['asignatura'];

    $modelo = new GraficoModel($conexion);
    $promedios = $modelo->obtenerPromedioCalificaciones($idCurso, $idAsignatura);

    if ($promedios !== false) {
        // Crear un array asociativo con los datos
        $response = [
            'promedio1' => $promedios['promedio1'],
            'promedio2' => $promedios['promedio2'],
            'promedio3' => $promedios['promedio3'],
            'promedio4' => $promedios['promedio4'],
        ];

        // Establecer las cabeceras para indicar que la respuesta es JSON
        header('Content-Type: application/json');

        // Imprimir la respuesta en formato JSON
        echo json_encode($response);
    }
}
?>