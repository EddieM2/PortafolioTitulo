<?php

//if (!isset($_SESSION['rut'])) {
  //  header("Location: ../login.php"); // Redirige si no ha iniciado sesión
    //exit();
//}

include("../models/db.php");

// Obtén el rut del alumno desde la sesión
$alumno_rut = $_SESSION['rut'];

// Realiza una consulta para obtener las calificaciones del alumno junto con el nombre de la asignatura
$query = "SELECT cal.idCalificacion, cal.fecha, asi.nombre AS nombre_asignatura, cal.calificacion1, cal.calificacion2, cal.calificacion3, cal.calificacion4
          FROM calificaciones AS cal
          INNER JOIN asignatura AS asi ON cal.idAsignatura = asi.idAsignatura
          WHERE cal.idAlumno = '$alumno_rut'";

$result = mysqli_query($conexion, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calificaciones del Alumno</title>
    <style>
        /* Estilos para el contenedor de asignaturas */
        .asignatura {
            cursor: pointer;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
        }
        /* Estilos para ocultar las calificaciones al principio */
        .calificaciones {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Calificaciones del Alumno</h1>

    <?php
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="asignatura">';
            echo '<p>Asignatura: ' . $row['nombre_asignatura'] . '</p>';
            echo '<div class="calificaciones">';
          //  echo '<p>Fecha: ' . $row['fecha'] . '</p>';
            echo '<p>Calificación 1: ' . $row['calificacion1'] . '</p>';
            echo '<p>Calificación 2: ' . $row['calificacion2'] . '</p>';
            echo '<p>Calificación 3: ' . $row['calificacion3'] . '</p>';
            echo '<p>Calificación 4: ' . $row['calificacion4'] . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "No hay calificaciones registradas.";
    }
    ?>

    <a href="inicioAlum.php">Volver a la página de inicio del alumno</a>

    <script>
        // JavaScript para manejar el despliegue de las calificaciones al hacer clic
        const asignaturas = document.querySelectorAll('.asignatura');

        asignaturas.forEach(asignatura => {
            asignatura.addEventListener('click', () => {
                const calificaciones = asignatura.querySelector('.calificaciones');
                calificaciones.style.display = (calificaciones.style.display === 'block') ? 'none' : 'block';
            });
        });
    </script>
</body>
</html>
