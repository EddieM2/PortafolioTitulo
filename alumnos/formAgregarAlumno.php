<?php
include("../models/db.php");

// consulta para obtener la lista de apoderados
$queryApoderados = "SELECT rut, nombre FROM apoderado";
$resultApoderados = mysqli_query($conexion, $queryApoderados);

// consulta para obtener la lista de cursos
$queryCursos = "SELECT idCurso, nombre FROM curso";
$resultCursos = mysqli_query($conexion, $queryCursos);

// Verificar si hay resultados
if (!$resultApoderados || !$resultCursos) {
    die("Error al obtener la lista de apoderados o cursos: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agregar Alumno</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../src/css/profes.css"> 
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Agregar Alumno</h1>
                <form method="POST" action="../models/alumnosModels/insertAlumnos.php">
                    <label for="rut">RUT</label>
                    <input type="text" name="rut" class="form-control" required>

                    <label for="correo">Correo:</label>
                    <input type="email" name="correo" class="form-control" required>

                    <label for="nombre">Nombre:</label>
                    <input type="text" name="nombre" class="form-control" required>

                    <label for="apellidoM">Apellido Materno:</label>
                    <input type="text" name="apellidoM" class="form-control" required>

                    <label for="apellidoP">Apellido Paterno:</label>
                    <input type="text" name="apellidoP" class="form-control" required>

                    <input type="hidden" name="idCargo" value="3">

                    <label for="fechaNacimiento">Fecha de Nacimiento:</label>
                    <input type="date" name="fechaNacimiento" class="form-control" required>

                    <label for="direccion">Dirección:</label>
                    <input type="text" name="direccion" class="form-control" required>

                    <label for="telefono">Teléfono:</label>
                    <input type="text" name="telefono" class="form-control" required>

                    <label for="genero">Género:</label>
                    <input type="text" name="genero" class="form-control" required>

                    <label for="estadoAcademico">Estado Académico:</label>
                    <input type="text" name="estadoAcademico" class="form-control" required>
                 
                    <!-- Campo de selección para apoderado -->
                    <label for="apoderado">Apoderado:</label>
                    <select name="apoderado" class="form-control" required>
                        <option value="">Seleccione un apoderado</option>
                        <?php
                        // Generar opciones desde los resultados de la consulta
                        while ($apoderado = mysqli_fetch_assoc($resultApoderados)) {
                            echo "<option value='" . $apoderado['rut'] . "'>" . $apoderado['nombre'] . "</option>";
                        }
                        ?>
                    </select>

                    <!-- Campo de selección para curso -->
                    <label for="curso">Curso:</label>
                    <select name="idCurso" class="form-control" required>
                        <option value="">Seleccione un curso</option>
                        <?php
                        // Generar opciones desde los resultados de la consulta
                        while ($curso = mysqli_fetch_assoc($resultCursos)) {
                            echo "<option value='" . $curso['idCurso'] . "'>" . $curso['nombre'] . "</option>";
                        }
                        ?>
                    </select>

                    <button type="submit" class="btn btn-primary">Agregar Alumno</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
