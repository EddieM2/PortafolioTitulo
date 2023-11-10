<?php include("../db.php") ?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Profesores</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/profes.css">
</head>
<body>
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body">
                <h1 class="card-title">Lista de Profesores</h1>
                <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <tr>
                            <th>RUT</th>
                            <th>Nombre</th>
                            <th>Apellido Paterno</th>
                            <th>Apellido Materno</th>
                            <th>Correo Electrónico</th>
                            <th>Fecha de Nacimiento</th>
                            <th>Teléfono</th>
                            <th>Género</th>
                            <th>Asignaturas</th>
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
                                echo "<a href='../../profesores/formEditarProfesores.php?rut=" . $row['rut'] . "' class='btn btn-primary'>Editar</a>";
                                echo "<a href='eliminarProfesores.php?rut=" . $row['rut'] . "' class='btn btn-danger ml-2'>Eliminar</a>";
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
                </div>

                <a class="btn btn-primary" href="insertprofesor.php">Agregar Profesor</a>
                
                <!-- Botón para administrar cursos y asignaturas -->
                <a class="btn btn-primary" href="administrarCursosAsignaturas.php">Administrar Cursos y Asignaturas</a>
            </div>
        </div>
    </div>
</body>
</html>
