<?php include("../db.php") ?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Profesores</title>
    <style>
        table {
            border-collapse: collapse;
            width: 80%;
            margin: 20px auto;
        }

        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        .add-button {
            margin-top: 20px;
            display: block;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Lista de Profesores</h1>
    <table>
        <tr>
            <th>RUT</th>
            <th>Nombre</th>
            <th>Apellido Paterno</th>
            <th>Apellido Materno</th>
            <th>Correo Electrónico</th>
            <th>Fecha de Nacimiento</th>
            <th>Teléfono</th>
            <th>Género</th>
            <th>Asignaturas</th> <!-- Nueva columna para mostrar las asignaturas -->
            <th>Acciones</th>
        </tr>
        <?php


        if (!$conexion) {
            die("Error de conexión: " . mysqli_connect_error());
        }

        // Consulta para obtener la lista de profesores con sus asignaturas relacionadas
        $query = "SELECT p.rut, p.nombre, p.apellidoP, p.apellidoM, p.correo, p.fechaNacimiento, p.telefono, p.genero, GROUP_CONCAT(a.nombre SEPARATOR ', ') as asignaturas
                  FROM profesor p LEFT JOIN asignatura a 
                  ON p.rut = a.rutProfesor
                  GROUP BY p.rut";
        $result = mysqli_query($conexion, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['rut'] . "</td>";
                echo "<td>" . $row['nombre'] . "</td>";
                echo "<td>" . $row['apellidoP'] . "</td>";
                echo "<td>" . $row['apellidoM'] . "</td>";
                echo "<td>" . $row['correo'] . "</td>";
                echo "<td>" . $row['fechaNacimiento'] . "</td>";
                echo "<td>" . $row['telefono'] . "</td>";
                echo "<td>" . $row['genero'] . "</td>";
                echo "<td>" . $row['asignaturas'] . "</td>"; // Mostrar las asignaturas relacionadas
                echo "<td>";
                echo "<a href='../../profesores/formEditarProfesores.php?rut=" . $row['rut'] . "'>Editar</a> | ";
                echo "<a href='eliminarProfesores.php?rut=" . $row['rut'] . "'>Eliminar</a>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No hay profesores registrados.</td></tr>";
        }

        // Cerrar la conexión
        mysqli_close($conexion);
        ?>
    </table>

    <a class="add-button" href="agregar_profesor.php">Agregar Profesor</a>
</body>
</html>
