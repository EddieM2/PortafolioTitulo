<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Seguimiento Psicológico</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css">
</head>
<body>
    <meta charset="utf-8">
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body">
                <?php if (isset($_GET['exito']) && $_GET['exito'] == 'true') {
                    echo "<p style='color: green;'>El formulario se envió correctamente.</p>";
                }
                ?>
                <h1 class="card-title">Módulo de Seguimiento Psicológico</h1>
                <p>El Módulo de Seguimiento Psicológico proporciona herramientas y formularios diseñados para realizar un seguimiento detallado del bienestar psicológico de los alumnos. A través de este módulo, los profesionales de la salud mental pueden recopilar información valiosa para comprender y abordar las necesidades emocionales de los estudiantes.</p>
                <p>Ofrecemos un enfoque integral que permite registrar datos relevantes, evaluar el progreso y brindar el apoyo necesario. Este módulo se centra en la salud mental y emocional, promoviendo un entorno educativo que apoya el bienestar integral de cada alumno.</p>
                <a class="btn btn-primary" href="formSaludMental.php">Comenzar formulario</a>
                <a class="btn btn-secondary" href="../alumnos/inicioAlum.php">Volver Atrás</a>
            </div>
        </div>
    </div>
</body>
</html>
