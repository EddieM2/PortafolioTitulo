<?php include("../models/db.php") ?>
<!DOCTYPE html>
<html lang="es">
<head>
<link rel="stylesheet" href="../src/css/mensajes.css">
    <meta charset="UTF-8">
    <title>Enviar Nuevo Mensaje al Apoderado</title>
    <style>
        body {
            background-color: #125E5E;
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .container {
            margin-top: 5rem;
        }

        .card {
            background-color: #fff;
            color: #125E5E;
            border: 2px solid #125E5E;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            width: 80%;
            max-width: 600px;
        }

        .btn-primary {
            background-color: #125E5E;
            border-color: #125E5E;
        }

        #calificacionesTable {
            overflow-x: auto;
        }
    </style>
</head>
<body>
<div class="panel"> 
    <h1>Enviar Nuevo Mensaje al Apoderado  </h1>
    
    <?php
    // Obtener los parámetros de la URL (rutAlumno, idCurso, idAsignatura)
    if (isset($_GET['rutAlumno']) && isset($_GET['idCurso']) && isset($_GET['idAsignatura'])) {
        $rutAlumno = $_GET['rutAlumno'];
        $idCurso = $_GET['idCurso'];
        $idAsignatura = $_GET['idAsignatura'];
        $rut_Apoderado = $_GET['idEmisor'];
    } else {
        // Si no se proporcionaron los parámetros requeridos, redirigir a la página anterior
      //  header("Location: ver_mensajes.php?idCurso=$idCurso&idAsignatura=$idAsignatura");
        exit();
    }



    // Consultar el nombre del curso
    $curso_query = "SELECT nombre FROM curso WHERE idCurso = $idCurso";
    $curso_result = mysqli_query($conexion, $curso_query);

    if (!$curso_result) {
        die("Error al obtener el nombre del curso: " . mysqli_error($conexion));
    }

    $curso = mysqli_fetch_assoc($curso_result);
    $nombreCurso = $curso['nombre'];

    // Consultar el nombre de la asignatura
    $asignatura_query = "SELECT nombre FROM asignatura WHERE idAsignatura = $idAsignatura";
    $asignatura_result = mysqli_query($conexion, $asignatura_query);

    if (!$asignatura_result) {
        die("Error al obtener el nombre de la asignatura: " . mysqli_error($conn));
    }

    $asignatura = mysqli_fetch_assoc($asignatura_result);
    $nombreAsignatura = $asignatura['nombre'];

    // Consultar el nombre del apoderado
    $apoderado_query = "SELECT nombre FROM apoderado WHERE rut = '$rut_Apoderado'";
    $apoderado_result = mysqli_query($conexion, $apoderado_query);

    if (!$apoderado_result) {
        die("Error al obtener el nombre del apoderado: " . mysqli_error($conexion));
    }

    $apoderado = mysqli_fetch_assoc($apoderado_result);
    $nombreApoderado = $apoderado['nombre'];
    ?>

    <h2>Curso: <?php echo $nombreCurso; ?></h2>
    <h2>Asignatura: <?php echo $nombreAsignatura; ?></h2>
   
    <h2>Apoderado: <?php echo $nombreApoderado; ?></h2>




    <h2>Formulario para Enviar Mensaje:  </h2></h2>

    <form action="../models/profesoresModels/procesar_mensaje_apoderado.php" method="POST">
        <input type="hidden" name="rutAlumno" value="<?php echo $rutAlumno; ?>">
        <input type="hidden" name="rut_Apoderado" value="<?php echo $rut_Apoderado; ?>">
        <input type="hidden" name="idCurso" value="<?php echo $idCurso; ?>">
        <input type="hidden" name="idAsignatura" value="<?php echo $idAsignatura; ?>">
        <label for="mensaje">Mensaje:</label><br>
        <textarea name="mensaje" id="mensaje" rows="4" cols="50" required></textarea><br>
        <input type="submit" value="Enviar Mensaje">
    </form>
</div>

    <a href="ver_mensajes.php?idCurso=<?php echo $idCurso; ?>&idAsignatura=<?php echo $idAsignatura; ?>">Volver a Mensajes</a>
    <a href="logout.php">Cerrar Sesión</a>

</body>
</html>