<?php
session_start();
if (!isset($_SESSION['rut'])) {
    header("Location: ../login.php"); // Redirige si no ha iniciado sesión
    exit();
}

include("../models/db.php");

// Obtén el rut del alumno desde la sesión
$alumno_rut = $_SESSION['rut'];

// Realiza una consulta para obtener la asistencia del alumno en función de su rut
$query = "SELECT fecha, presente
          FROM asistencia
          WHERE rutAlumno = '$alumno_rut'";

$result = mysqli_query($conexion, $query);

if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asistencia del Alumno</title>
    <!-- Agrega aquí tus enlaces a CSS y otros recursos -->
    <link rel="stylesheet" href="ruta_de_tu_estilo.css"> <!-- Agrega la ruta de tu hoja de estilo CSS -->
    <style>
        /* Estilos CSS */
        body {
            background-color: #125E5E; /* Reemplaza XXXXXX con el color del colegio */
        }
        .month-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
            cursor: pointer;
            background-color: #FFFFFF; /* Color de fondo para los acordeones */
        }
        .month-box table {
            display: none;
        }
        .attendance-summary {
            margin-top: 20px;
            font-weight: bold;
            color: #000000; /* Color de texto para el resumen de asistencia */
            text-align: center;

            
            
            
        }
        h1 {
            text-align: center; /* Para centrar el título horizontalmente */
        }
        .btn-back {
    display: block;
    margin: 0 auto; /* Esto centrará el botón horizontalmente */
    padding: 10px 20px;
    background-color: #007bff; /* Color de fondo */
    color: #fff; /* Color de texto */
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
}

.btn-back i {
    margin-right: 5px; /* Espacio entre el icono y el texto */
}
    </style>
</head>
<body>
    <h1>Asistencia del Alumno</h1>

    <?php
    if (mysqli_num_rows($result) > 0) {
        $currentMonth = '';
        $monthData = array();
        $totalDays = 0;
        $presentDays = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            $date = date_create($row['fecha']);
            $month = date_format($date, 'F Y'); // Obtiene el mes y el año

            if ($currentMonth !== $month) {
                // Inicio de un nuevo mes, crea un cuadro para el mes anterior (si hubo asistencia)
                if (!empty($monthData)) {
                    echo "<div class='month-box' onclick='toggleMonth(this)'>";
                    echo "<h2>$currentMonth</h2>";
                    echo "<table>";
                    echo "<tr><th>Fecha</th><th>Presente</th></tr>";
                    foreach ($monthData as $data) {
                        echo "<tr>";
                        echo "<td>" . $data['fecha'] . "</td>";
                        echo "<td>" . ($data['presente'] ? 'Presente' : 'Ausente') . "</td>";
                        echo "</tr>";
                        $totalDays++;
                        if ($data['presente']) {
                            $presentDays++;
                        }
                    }
                    echo "</table>";
                    echo "</div>";
                }

                $currentMonth = $month;
                $monthData = array();
            }

            $monthData[] = $row;
            $totalDays++;
            if ($row['presente']) {
                $presentDays++;
            }
        }

        // Mostrar el último mes
        if (!empty($monthData)) {
            echo "<div class='month-box' onclick='toggleMonth(this)'>";
            echo "<h2>$currentMonth</h2>";
            echo "<table>";
            echo "<tr><th>Fecha</th><th>Presente</th></tr>";
            foreach ($monthData as $data) {
                echo "<tr>";
                echo "<td>" . $data['fecha'] . "</td>";
                echo "<td>" . ($data['presente'] ? 'Presente' : 'Ausente') . "</td>";
                echo "</tr>";
                $totalDays++;
                if ($data['presente']) {
                    $presentDays++;
                }
            }
            echo "</table>";
            echo "</div>";
        }

        // Calcular el porcentaje de asistencia
        $attendancePercentage = ($presentDays / $totalDays) * 100;

        echo "<div class='attendance-summary style='text-align: center;'>";
        echo "Porcentaje de Asistencia Total: " . number_format($attendancePercentage, 2) . "%";
        echo "</div>";
    } else {
        echo "No hay registros de asistencia para este alumno.";
    }
    ?>

<button class="btn-back" onclick="window.history.back();"><i class="fas fa-arrow-left"></i> Volver Atrás</button>

    <script>
        function toggleMonth(monthBox) {
            const table = monthBox.querySelector('table');
            table.style.display = (table.style.display === 'table') ? 'none' : 'table';
        }
    </script>
</body>
</html>
