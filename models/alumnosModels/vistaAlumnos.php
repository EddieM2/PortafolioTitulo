<?php include("../db.php") ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../../src/css/profes.css"> 
    <meta charset="UTF-8">
    <style>
        body { padding-top: 20px; }
        .container { overflow: auto; max-height: 80vh; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body">
                <h1 class="card-title">Lista de Alumnos</h1>

                <a href="../../alumnos/formAgregarAlumno.php" class="btn btn-primary">Agregar Alumno</a>

                <div class="table-responsive">
                    <table class="table table-bordered mt-3">
                        <?php
                        // Conexión a la base de datos

                        if (!$conexion) {
                            die("Error de conexión: " . mysqli_connect_error());
                        }

                        // Verificar la conexión
                        if ($conexion->connect_error) {
                            die("Error de conexión: " . $conexion->connect_error);
                        }

                        // Consulta SQL para obtener los datos de los alumnos y el nombre del curso
                        $sql = "SELECT alumno.rut, alumno.correo, alumno.nombre, alumno.apellidoM, alumno.apellidoP, alumno.idCargo, alumno.fechaNacimiento, alumno.direccion, alumno.telefono, alumno.genero, alumno.estadoAcademico, alumno.rutApoderado, curso.nombre AS nombreCurso
                                FROM alumno
                                INNER JOIN inscripcion ON alumno.rut = inscripcion.rutAlumno
                                INNER JOIN curso ON inscripcion.idCurso = curso.idCurso";
                        $result = $conexion->query($sql);

                        if ($result->num_rows > 0) {
                            // Imprimir nombres de columnas
                            echo "<thead class='thead-dark'>";
                            echo "<tr>";
                            echo "<th>RUT</th>";
                            echo "<th>Correo</th>";
                            echo "<th>Nombre</th>";
                            echo "<th>Apellido Materno</th>";
                            echo "<th>Apellido Paterno</th>";
                            echo "<th>ID Cargo</th>";
                            echo "<th>Fecha de Nacimiento</th>";
                            echo "<th>Dirección</th>";
                            echo "<th>Teléfono</th>";
                            echo "<th>Género</th>";
                            echo "<th>Estado Académico</th>";
                            echo "<th>Rut apoderado</th>";
                            echo "<th>Curso</th>";  // Nombre del curso
                            echo "<th>Editar</th>"; 
                            echo "<th>Eliminar</th>"; 
                            echo "</tr>";
                            echo "</thead>";

                            // Imprimir datos
                            echo "<tbody>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["rut"] . "</td>";
                                echo "<td>" . $row["correo"] . "</td>";
                                echo "<td>" . $row["nombre"] . "</td>";
                                echo "<td>" . $row["apellidoM"] . "</td>";
                                echo "<td>" . $row["apellidoP"] . "</td>";
                                echo "<td>" . $row["idCargo"] . "</td>";
                                echo "<td>" . $row["fechaNacimiento"] . "</td>";
                                echo "<td>" . $row["direccion"] . "</td>";
                                echo "<td>" . $row["telefono"] . "</td>";
                                echo "<td>" . $row["genero"] . "</td>";
                                echo "<td>" . $row["estadoAcademico"] . "</td>";
                                echo "<td>" . $row["rutApoderado"] . "</td>";
                                echo "<td>" . $row["nombreCurso"] . "</td>";  // Muestra el nombre del curso
                                echo "<td><a href='../../alumnos/formEditarAlumno.php?rut=" . $row["rut"] . "' class='btn btn-primary'>Editar</a></td>"; 
                                echo "<td><a href='eliminarAlumno.php?rut=" . $row["rut"] . "' class='btn btn-danger'>Eliminar</a></td>"; 
                                echo "</tr>";
                            }
                            echo "</tbody>";
                        } else {
                            echo "No se encontraron alumnos.";
                        }

                        // Cierra la conexión a la base de datos
                        $conexion->close();
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
