<?php include("../db.php") ?>

<!DOCTYPE html>
<html>
<head>
    <title>Administración de Asignaturas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../src/css/profes.css">
</head>
<body>
    <div class="container mt-5">
        <div class="custom-card">
            <div class="custom-card-body">
                <h1 class="card-title">Administración de Asignaturas</h1>
                <form method="POST" action="guardar_asignaturas.php">
                    <div class="table-responsive">
                        <table class="table table-bordered mt-3">
                            <tr>
                                <th>Nombre de la Asignatura</th>
                                <th>Profesor</th>
                                <th>Acciones</th>
                            </tr>
                            <?php
             
                            // Consulta para obtener todas las asignaturas y sus profesores
                            $query = "SELECT a.idAsignatura, a.nombre, a.rutProfesor, p.nombre AS nombre_profesor
                                      FROM asignatura a
                                      LEFT JOIN profesor p ON a.rutProfesor = p.rut";
                            $result = mysqli_query($conexion, $query);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td><input type='text' name='asignatura_nombre[]' value='" . $row['nombre'] . "'></td>";
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
                                    echo "<td><a href='editar_asignatura.php?id=" . $row['idAsignatura'] . "'>Editar</a></td>";
                                    echo "</tr>";
                                }
                            }
                            ?>
                        </table>
                    </div>
                    <button type="submit" name="guardar_asignaturas">Guardar Cambios</button>
                </form>
                <h2>Agregar Nueva Asignatura</h2>
                <form method="POST" action="agregar_asignatura.php">
                    <label for="nueva_asignatura">Nombre de la Asignatura:</label>
                    <input type="text" name="nueva_asignatura" required>
                    <label for="nuevo_profesor">Profesor:</label>
                    <select name="nuevo_profesor" required>
                        <?php
                        // Lista de profesores para el menú desplegable
                        $queryProfesores = "SELECT rut, nombre FROM profesor";
                        $resultProfesores = mysqli_query($conexion, $queryProfesores);
                        if ($resultProfesores) {
                            while ($profesor = mysqli_fetch_assoc($resultProfesores)) {
                                echo "<option value='" . $profesor['rut'] . "'>" . $profesor['nombre'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                    <button type="submit" name="agregar_asignatura">Agregar Asignatura</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
