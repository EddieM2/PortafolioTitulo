 <?php include("../db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Asignaturas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/profes.css">
</head>
<body>
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body">
                <h1 class="card-title">Administración de Asignaturas</h1>

                <!-- Seleccionar curso -->
                <form method="POST" action="">
                    <label for="select_curso">Seleccione un Curso:</label>
                    <select name="select_curso" onchange="this.form.submit()">
                        <option value="" disabled selected>Seleccionar</option> <!-- Opción inicial deshabilitada y seleccionada -->
                        <?php
                        // Lista de cursos para el menú desplegable
                        $queryCursos = "SELECT idCurso, nombre FROM curso";
                        $resultCursos = mysqli_query($conexion, $queryCursos);
                        if ($resultCursos) {
                            while ($curso = mysqli_fetch_assoc($resultCursos)) {
                                $selected = (isset($_POST['select_curso']) && $_POST['select_curso'] == $curso['idCurso']) ? 'selected' : '';
                                echo "<option value='" . $curso['idCurso'] . "' $selected>" . $curso['nombre'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </form>

                <?php
                // Mostrar asignaturas y profesores asociados al curso seleccionado
                if (isset($_POST['select_curso'])) {
                    $selectedCurso = $_POST['select_curso'];

                    $queryAsignaturas = "SELECT a.idAsignatura, a.nombre AS nombre_asignatura, a.rutProfesor, p.nombre AS nombre_profesor
                                        FROM asignatura a
                                        LEFT JOIN profesor p ON a.rutProfesor = p.rut
                                        WHERE a.idCurso = $selectedCurso";

                    $resultAsignaturas = mysqli_query($conexion, $queryAsignaturas);

                    if (mysqli_num_rows($resultAsignaturas) > 0) {
                        echo "<form method='POST' action='guardar_asignaturas.php'>";
                        echo "<div class='table-responsive'>";
                        echo "<table class='table table-bordered mt-3'>";
                        echo "<tr>";
                        echo "<th>Nombre de la Asignatura</th>";
                        echo "<th>Profesor</th>";
                        echo "<th>Acciones</th>";
                        echo "</tr>";

                        while ($row = mysqli_fetch_assoc($resultAsignaturas)) {
                            echo "<tr>";
                            echo "<td><input type='text' name='asignatura_nombre[]' value='" . $row['nombre_asignatura'] . "'></td>";
                            echo "<td>";
                            echo "<select name='asignatura_profesor[]'>";
                            echo "<option value='" . $row['rutProfesor'] . "'>" . $row['nombre_profesor'] . "</option>";
                            // Lista de profesores para el menú desplegable
                            $queryProfesores = "SELECT rut, nombre FROM profesor";
                            $resultProfesores = mysqli_query($conexion, $queryProfesores);
                            if ($resultProfesores) {
                                while ($profesor = mysqli_fetch_assoc($resultProfesores)) {
                                    echo "<option value='" . $profesor['rut'] . "'>" . $profesor['nombre'] . "</option>";
                                }
                            }
                            echo "</select>";
                            echo "</td>";
                            // campo oculto para la clave primaria (idAsignatura)
                            echo "<input type='hidden' name='asignatura_id[]' value='" . $row['idAsignatura'] . "'>";
                            echo "<td><a href='editar_asignatura.php?id=" . $row['idAsignatura'] . "'>Editar</a></td>";
                            echo "</tr>";
                        }

                        echo "</table>";
                        echo "</div>";
                        echo "<button type='submit' name='guardar_asignaturas'>Guardar Cambios</button>";
                        echo "</form>";
                    }

                    // Agregar nueva asignatura al curso seleccionado
                    echo "<h2>Agregar Nueva Asignatura</h2>";
                    echo "<form method='POST' action='agregar_asignatura.php'>";
                    echo "<label for='nueva_asignatura'>Nombre de la Asignatura:</label>";
                    echo "<input type='text' name='nueva_asignatura' required>";

                    // Lista de cursos para el menú desplegable
                    $queryCursos = "SELECT idCurso, nombre FROM curso";
                    $resultCursos = mysqli_query($conexion, $queryCursos);

                    echo "<label for='nuevo_curso'>Curso:</label>";
                    echo "<select name='nuevo_curso' required>";
                    if ($resultCursos) {
                        while ($curso = mysqli_fetch_assoc($resultCursos)) {
                            echo "<option value='" . $curso['idCurso'] . "'>" . $curso['nombre'] . "</option>";
                        }
                    }
                    echo "</select>";

                    echo "<label for='nuevo_profesor'>Profesor:</label>";
                    echo "<select name='nuevo_profesor' required>";

                    // Lista de profesores para el menú desplegable
                    $queryProfesores = "SELECT rut, nombre FROM profesor";
                    $resultProfesores = mysqli_query($conexion, $queryProfesores);
                    if ($resultProfesores) {
                        while ($profesor = mysqli_fetch_assoc($resultProfesores)) {
                            echo "<option value='" . $profesor['rut'] . "'>" . $profesor['nombre'] . "</option>";
                        }
                    }
                    
                    echo "</select>";
                    echo "<button type='submit' name='agregar_asignatura'>Agregar Asignatura</button>";
                    echo "</form>";
                }
                ?>
            </div>
        </div>
    </div>
</body>
</html>

