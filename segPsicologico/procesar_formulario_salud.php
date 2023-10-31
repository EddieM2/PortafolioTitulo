<?php
// Incluye el archivo de conexión a la base de datos
include("../models/db.php");

// Recoge los valores del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
     $rut_alumno = $_POST['rut_alumno'];
     $tristeza = $_POST['tristeza'];
     $autolesiones = $_POST['autolesiones'];
     $cambios_sueño = $_POST['cambios-sueño'];
     $concentracion = $_POST['concentración'];
     $apoyo_amigos = $_POST['apoyo-amigos'];
     $conflictos = $_POST['conflictos'];
     $consumo_sustancias = $_POST['consumo-sustancias'];
     $autoestima = $_POST['autoestima'];
     $comentarios = $_POST['comentarios'];
     $explicacion = $_POST['explicacion'];

    // Prepara la consulta SQL con los valores recogidos
    $sql = "INSERT INTO respuestas_salud (rut_alumno, tristeza, autolesiones, cambios_sueño, concentracion, apoyo_amigos, conflictos, consumo_sustancias, autoestima, comentarios, explicacion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        // Asegúrate de que los valores 'si' y 'no' estén entre comillas simples en la consulta SQL
        $stmt->execute([$rut_alumno, $tristeza, $autolesiones, $cambios_sueño, $concentracion, $apoyo_amigos, $conflictos, $consumo_sustancias, $autoestima, $comentarios, $explicacion]);
        
        // Redirige al usuario a la página siguiente
        header("Location: formSaludMental.php");
        exit;
    } else {
        echo "Error al preparar la consulta.";
    }
}
?>
