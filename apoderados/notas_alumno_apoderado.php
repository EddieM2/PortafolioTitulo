<?php
include("../models/db.php");

// Asegúrate de que se haya iniciado la sesión del alumno
//if (isset($_SESSION['rut'])) {
// Rut del alumno seleccionado 
$rut_pupilo = $_POST['rut_pupilo'];

// Realiza una consulta para obtener las calificaciones del alumno junto con el nombre de la asignatura
$query = "SELECT cal.idCalificacion, cal.fecha, asi.nombre AS nombre_asignatura, cal.calificacion1, cal.calificacion2, cal.calificacion3, cal.calificacion4
          FROM calificaciones AS cal
          INNER JOIN asignatura AS asi ON cal.idAsignatura = asi.idAsignatura
          WHERE cal.idAlumno = '$rut_pupilo'";

$result = mysqli_query($conexion, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
//} else {
//    header("Location: ../login.php"); // Redirige si no ha iniciado sesión
//    exit();
//}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Calificaciones del Alumno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
    <link rel="stylesheet" href="../src/css/profes.css"> 
</head>
<body>
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body">
                <h1 class="card-title">Calificaciones del Alumno</h1>

                <div class= "table-responsive">

                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>Asignatura</th>
                                <th>Fecha</th>
                                <th>Calificación 1</th>
                                <th>Calificación 2</th>
                                <th>Calificación 3</th>
                                <th>Calificación 4</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<tr>';
                                    echo '<td>' . $row['nombre_asignatura'] . '</td>';
                                    echo '<td>' . $row['fecha'] . '</td>';
                                    echo '<td>' . $row['calificacion1'] . '</td>';
                                    echo '<td>' . $row['calificacion2'] . '</td>';
                                    echo '<td>' . $row['calificacion3'] . '</td>';
                                    echo '<td>' . $row['calificacion4'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="6">No hay calificaciones registradas.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>

                    
        </div>
        <button class="btn-back" onclick="window.history.back();"><i class="fas fa-arrow-left"></i> Volver Atrás</button>
    </div>

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
