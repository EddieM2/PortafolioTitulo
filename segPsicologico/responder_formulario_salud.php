<?php
include("../models/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_formulario_salud_mental = $_POST['id_formulario_salud_mental'];
    $respuesta_encargado = $_POST['respuesta_encargado'];

    // Realiza la inserción de la respuesta del encargado en la tabla respuestas_encargado_salud_mental
    $sql = "INSERT INTO respuestas_encargado_salud_mental (id_formulario_salud_mental, respuesta_encargado) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->execute([$id_formulario_salud_mental, $respuesta_encargado]);

        // Redirige al usuario a la página de formularios o a donde desees
        header("Location: verFormularios.php");
        exit;
    } else {
        echo "Error al preparar la consulta.";
    }
}
?>
