<?php
include("../models/db.php");

// Obtiene los valores del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rut_alumno = $_POST['rut_alumno'];
    $tristeza = $_POST['tristeza'];
    $autolesiones = $_POST['autolesiones'];
    $cambios_sueno = $_POST['cambios-sueño'];
    $concentracion = $_POST['concentración'];
    $apoyo_amigos = $_POST['apoyo-amigos'];
    $conflictos = $_POST['conflictos'];
    $consumo_sustancias = $_POST['consumo-sustancias'];
    $autoestima = $_POST['autoestima'];
    $comentarios = $_POST['comentarios'];
    $explicacion = $_POST['explicacion'];

    // Escapar los valores para prevenir la inyección de SQL
    $rut_alumno = mysqli_real_escape_string($conexion, $rut_alumno);
    $tristeza = mysqli_real_escape_string($conexion, $tristeza);
    $autolesiones = mysqli_real_escape_string($conexion, $autolesiones);
    $cambios_sueno = mysqli_real_escape_string($conexion, $cambios_sueno);
    $concentracion = mysqli_real_escape_string($conexion, $concentracion);
    $apoyo_amigos = mysqli_real_escape_string($conexion, $apoyo_amigos);
    $conflictos = mysqli_real_escape_string($conexion, $conflictos);
    $consumo_sustancias = mysqli_real_escape_string($conexion, $consumo_sustancias);
    $autoestima = mysqli_real_escape_string($conexion, $autoestima);
    $comentarios = mysqli_real_escape_string($conexion, $comentarios);
    $explicacion = mysqli_real_escape_string($conexion, $explicacion);

    // Prepara la consulta SQL con los valores recogidos, incluyendo la columna fecha
    $sql = "INSERT INTO respuestas_salud (rut_alumno, tristeza, autolesiones, cambios_sueno, concentracion, apoyo_amigos, conflictos, consumo_sustancias, autoestima, explicacion, fecha) VALUES ('$rut_alumno', '$tristeza', '$autolesiones', '$cambios_sueno', '$concentracion', '$apoyo_amigos', '$conflictos', '$consumo_sustancias', '$autoestima', '$explicacion', NOW())";

    // Establecer la codificación de caracteres
    mysqli_set_charset($conexion, "utf8");

    // Ejecutar la consulta y redirigir al usuario
    if (mysqli_query($conexion, $sql)) {
        // Redirige al usuario a la página siguiente
        header("Location: segPsico.php?exito=true");
        exit;
    } else {
        echo "Error al procesar el formulario: " . mysqli_error($conexion);
    }
}
?>
