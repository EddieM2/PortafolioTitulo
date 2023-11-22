<?php

 include("../models/db.php") ;

// Recoge los valores del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];
    $tipo = $_POST['tipo'];

    
    $sql = "INSERT INTO denuncias (titulo, descripcion, tipo, fecha) VALUES (?, ?, ?, NOW())";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        
        $stmt->execute([$titulo, $descripcion, $tipo]);

        // Redirige al usuario a una página de confirmación o a donde lo desees
        header("Location: denuncia_exitosa.php"); 
        exit;
    } else {
        echo "Error al preparar la consulta.";
    }
}
?>
