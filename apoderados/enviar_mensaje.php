<?php
$rut_pupilo = $_GET['rut_pupilo'];
$nombre_asignatura = $_GET['nombre_asignatura'];
$nombre_curso = $_GET['nombre_curso'];
$rut_profesor = $_GET['rut_profesor'];
$nombre_apoderado = $_GET['nombre_apoderado'];
$idCurso = $_GET['idCurso'];
$idAsignatura = $_GET['idAsignatura'];

// Resto del código de la página "enviar_mensaje.php"
?>



<!DOCTYPE html>
<html>
<head>
    <title>Enviar Mensaje al Profesor</title>
</head>
<body>
    <h1>Enviar Mensaje al Profesor</h1>
    
    <form method="post" action="../models/apoderadosModels/procesar_mensaje.php">
        <input type="hidden" name="rut_pupilo" value="<?php echo $rut_pupilo; ?>">
        <input type="hidden" name="nombre_asignatura" value="<?php echo $nombre_asignatura; ?>">
        <input type="hidden" name="nombre_curso" value="<?php echo $nombre_curso; ?>">
        <input type="hidden" name="rut_profesor" value="<?php echo $rut_profesor; ?>">
        <input type="hidden" name="nombre_apoderado" value="<?php echo $nombre_apoderado; ?>">
        <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>">
        <input type="hidden" name="idAsignatura" value="<?php echo $idAsignatura; ?>">
        <input type="hidden" name="idConversacion" value="0">
        
        <label for="mensaje">Mensaje:</label><br>
        <textarea name="mensaje" rows="4" cols="50" required></textarea><br>

        <input type="submit" value="Enviar Mensaje">
    </form>
</body>
</html>
