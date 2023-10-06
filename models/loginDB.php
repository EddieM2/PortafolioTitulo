<?php include("db.php") ?>

<?php
session_start();

if (isset($_POST['validate_user'])) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $query = "SELECT l.*, p.nombre AS nombre_profesor FROM login l
              LEFT JOIN profesor p ON l.user = p.rut
              WHERE user='$user' and pass='$pass'";
    $result = mysqli_query($conexion, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($conexion));
    }

    $filas = mysqli_fetch_array($result);

    if ($filas) {
        if ($filas['cargo_id'] == 1) { // Administrador
            // Guarda la información del administrador en la sesión
            $_SESSION['user_id'] = $filas['idUser'];
            $_SESSION['user'] = $filas['nombre_profesor']; // Cambia esto al nombre del administrador si es apropiado

            // Consulta adicional para obtener el RUT del administrador
            $rut_query = "SELECT rut FROM login WHERE user='$user' and pass='$pass'";
            $rut_result = mysqli_query($conexion, $rut_query);
            $rut_row = mysqli_fetch_array($rut_result);
            $admin_rut = $rut_row['rut'];

            // Guarda el RUT del administrador en la sesión
            $_SESSION['rut'] = $admin_rut;

            // Redirige a la página de inicio de administrador
            header("Location: ../admin/inicioAdmin.php");
            exit();
        } else if ($filas['cargo_id'] == 2) { // Profesor
            // Guarda la información del profesor en la sesión
            $_SESSION['user_id'] = $filas['idUser'];
            $_SESSION['user'] = $filas['nombre_profesor'];

            // Consulta adicional para obtener el RUT del profesor
            $rut_query = "SELECT rut FROM login WHERE user='$user' and pass='$pass'";
            $rut_result = mysqli_query($conexion, $rut_query);
            $rut_row = mysqli_fetch_array($rut_result);
            $user_rut = $rut_row['rut'];

            // Guarda el RUT en la sesión
            $_SESSION['rut'] = $user_rut;

            // Redirige a la siguiente página
            header("Location: ../profesores/inicioProf.php");
            exit();
        } else if ($filas['cargo_id'] == 3) { // Alumno
            // Guarda la información del alumno en la sesión
            $_SESSION['user_id'] = $filas['idUser'];
            $_SESSION['user'] = $filas['nombre_profesor']; // Cambia esto al nombre del alumno si es apropiado
    
            // Consulta adicional para obtener el RUT del alumno
            $rut_query = "SELECT rut FROM login WHERE user='$user' and pass='$pass'";
            $rut_result = mysqli_query($conexion, $rut_query);
            $rut_row = mysqli_fetch_array($rut_result);
            $alumno_rut = $rut_row['rut'];
    
            // Guarda el RUT del alumno en la sesión
            $_SESSION['rut'] = $alumno_rut;
    
            // Redirige a la página de inicio de alumno
            header("Location: ../alumnos/inicioAlum.php");
            exit();
        } else if ($filas['cargo_id'] == 4) { // Apoderado
            $rut_query = "SELECT rut FROM login WHERE user='$user' and pass='$pass'";
            $rut_result = mysqli_query($conexion, $rut_query);
            $rut_row = mysqli_fetch_array($rut_result);
            $apoderado_rut = $rut_row['rut'];
 
             // Guarda el RUT del apoderado en la sesión
             $_SESSION['rut'] = $apoderado_rut;
            header("Location: ../apoderados/inicioApoderado.php");
            exit();
        } else {
            // Cargo desconocido
            header("Location: ../index.php");
        }
    } else {
        // Usuario no encontrado
        header("Location: ../index.php");
    }
}
?>