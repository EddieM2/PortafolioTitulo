<?php include("../includes/header.php") ?>
<?php include("../models/db.php") ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<?php

// Verifica si el usuario ha iniciado sesión como administrador
if (isset($_SESSION['rut']) && $_SESSION['rut'] != '') {
    $salud_rut = $_SESSION['rut'];


    $query = "SELECT nombre, apellidoP FROM salud_mental WHERE rut = '$salud_rut'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $user_info = mysqli_fetch_assoc($result);
        $nombre = $user_info['nombre'];
        $apellido_paterno = $user_info['apellidoP'];

        $saludo = "Bienvenido, $nombre $apellido_paterno";
?>
    <link rel="stylesheet" href="../src/css/ventanas/presentacion.css">

        <div class="tarjeta-bienvenida">
            <div class="imagen-usuario">
                <i class="fa-solid fa-user"></i>
            </div>
            <div class="contenido">
                <h2>Tarjeta de información</h2>
                <p><?php echo $saludo ?></p>
            </div>
        </div>
        
        <div class="botones-admin">
            <a href=""><button>Notas</button></a>
            <a href=""><button>Asistencia</button></a>
            <a href="../segPsicologico/verFormularios.php"><button>Seguimiento psicológico</button></a>
        </div>

<?php 
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

<?php include('../includes/footer.php') ?>