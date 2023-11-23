<?php include("../db.php") ?>
<!DOCTYPE html>
<html>
<head>
    <title>Agregar Profesor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/profes.css">
    <style>
        body {
            padding-top: 100px; /* Agrega un espacio en la parte superior del cuerpo de la página */
        }

        .card {
            max-width: 600px; /* Limita el ancho máximo de la tarjeta */
            margin: 0 auto; /* Centra la tarjeta horizontalmente */
        }
    </style>
</head>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Agregar Profesor</h1>
                <?php
                // Verificar si se ha enviado el formulario
                if (isset($_POST['agregar_profesor'])) {
                    $rut = $_POST['rut'];
                    $nombre = $_POST['nombre'];
                    $apellidoP = $_POST['apellidoP'];
                    $apellidoM = $_POST['apellidoM'];
                    $correo = $_POST['correo'];
                    $fechaNacimiento = $_POST['fechaNacimiento'];
                    $telefono = $_POST['telefono'];
                    $genero = $_POST['genero'];
                    $idCargo = $_POST['idCargo'];
                    $idCurso = $_POST['curso'];
                    $idAsignatura = $_POST['asignatura'];

                    // Insertar el nuevo profesor en la tabla profesor
                    $query = "INSERT INTO profesor (rut, nombre, apellidoP, apellidoM, correo, fechaNacimiento, telefono, genero, idCargo, idCurso, idAsignatura) 
                              VALUES ('$rut', '$nombre', '$apellidoP', '$apellidoM', '$correo', '$fechaNacimiento', '$telefono', '$genero', '$idCargo', '$idCurso', '$idAsignatura')";
                    $result = mysqli_query($conexion, $query);

                    if ($result) {
                        // Éxito: el profesor se ha agregado correctamente
                        echo "<p>Profesor agregado con éxito.</p>";

                        // Redirigir al usuario a la página "lista_profesores"
                        echo "<a class='btn btn-primary' href='lista_profesores.php'>Volver a la lista de profesores</a>";
                    } else {
                        // Error: no se pudo agregar el profesor
                        echo "<p>Error al agregar el profesor: " . mysqli_error($conexion) . "</p>";
                    }
                }
                ?>
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="rut" class="form-label">RUT:</label>
                        <input type="text" name="rut" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellidoP" class="form-label">Apellido Paterno:</label>
                        <input type="text" name="apellidoP" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="apellidoM" class="form-label">Apellido Materno:</label>
                        <input type="text" name="apellidoM" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico:</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento:</label>
                        <input type="date" name="fechaNacimiento" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="text" name="telefono" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="genero" class="form-label">Género:</label>
                        <input type="text" name="genero" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="idCargo" class="form-label">Cargo:</label>
                        <select name="idCargo" class="form-select" required>
                            <option value="1">Administrador</option>
                            <option value="2">Profesor</option>
                            <option value="3">Alumno</option>
                            <option value="4">Apoderado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="curso" class="form-label">Curso:</label>
                        <select name="curso" class="form-select" required>
                            <option value="">Seleccione un curso</option>
                            <?php
                            $queryCursos = "SELECT idCurso, nombre FROM curso";
                            $resultCursos = mysqli_query($conexion, $queryCursos);

                            if ($resultCursos) {
                                while ($rowCurso = mysqli_fetch_assoc($resultCursos)) {
                                    echo "<option value='" . $rowCurso['idCurso'] . "'>" . $rowCurso['nombre'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="asignatura" class="form-label">Asignatura:</label>
                        <select name="asignatura" class="form-select" required>
                            <option value="">Seleccione una asignatura</option>
                            <?php
                            $queryAsignaturas = "SELECT idAsignatura, nombre FROM asignatura";
                            $resultAsignaturas = mysqli_query($conexion, $queryAsignaturas);

                            if ($resultAsignaturas) {
                                while ($rowAsignatura = mysqli_fetch_assoc($resultAsignaturas)) {
                                    echo "<option value='" . $rowAsignatura['idAsignatura'] . "'>" . $rowAsignatura['nombre'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" name="agregar_profesor" class="btn btn-primary">Agregar Profesor</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
