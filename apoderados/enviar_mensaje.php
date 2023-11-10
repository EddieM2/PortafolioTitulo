<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Enviar Mensaje al Profesor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css">
</head>
<body>
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body">
                <?php
                $rut_pupilo = $_GET['rut_pupilo'];
                $nombre_asignatura = $_GET['nombre_asignatura'];
                $nombre_curso = $_GET['nombre_curso'];
                $rut_profesor = $_GET['rut_profesor'];
                $nombre_apoderado = $_GET['nombre_apoderado'];
                $idCurso = $_GET['idCurso'];
                $idAsignatura = $_GET['idAsignatura'];
                ?>

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

                    <input type="submit" class="btn btn-primary" value="Enviar Mensaje">
                </form>
            </div>
        </div>
    </div>
</body>
</html>
