<?php include("../models/db.php") ?>

<?php

// Verifica si el usuario ha iniciado sesión como administrador
if (isset($_SESSION['rut']) && $_SESSION['rut'] != '') {
    $admin_rut = $_SESSION['rut'];

    // Ahora puedes utilizar $admin_rut para obtener el nombre y apellido paterno del usuario desde la base de datos
    // Realiza una consulta SQL para obtener el nombre y apellido paterno del usuario según su rut
    // Asumiendo que tienes una tabla llamada "usuarios" con campos "rut," "nombre," y "apellido_paterno"
    // Ejemplo de consulta SQL (sustituye esto con tu consulta real):
    $query = "SELECT nombre, apellidoP FROM admin WHERE rut = '$admin_rut'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $user_info = mysqli_fetch_assoc($result);
        $nombre = $user_info['nombre'];
        $apellido_paterno = $user_info['apellidoP'];

        // Ahora tienes el nombre y apellido paterno del usuario
        echo "Bienvenido, $nombre $apellido_paterno";

        // Agrega los botones para administrar Alumnos, Apoderados y Asignaturas
        echo '<br><br>';
        echo '<a href="../models/alumnosModels/vistaAlumnos.php"><button>Administrar Alumnos</button></a>';
        echo '<a href="../models/apoderadosModels/vistaApoderados.php"><button>Administrar Apoderados</button></a>';
        echo '<a href="../models/profesoresModels/vistaProfesores.php"><button>Administrar Profesores</button></a>';
    } else {
        // Manejo de errores si la consulta falla
        echo "Error al obtener la información del usuario.";
    }

    // Aquí puedes mostrar el contenido adicional de la página "inicioAdmin.php"
} else {
    // Si el usuario no ha iniciado sesión como administrador, redirige o muestra un mensaje de error
    header("Location: ../login.php"); // Cambia "login.php" al archivo de inicio de sesión real o muestra un mensaje de error
    exit();
}
?>
