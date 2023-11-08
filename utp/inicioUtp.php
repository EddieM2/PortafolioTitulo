<?php include("../models/db.php") ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php

// Verifica si el usuario ha iniciado sesión como administrador
if (isset($_SESSION['rut']) && $_SESSION['rut'] != '') {
    $utp_rut = $_SESSION['rut'];

    // Ahora puedes utilizar $admin_rut para obtener el nombre y apellido paterno del usuario desde la base de datos
    // Realiza una consulta SQL para obtener el nombre y apellido paterno del usuario según su rut
    // Asumiendo que tienes una tabla llamada "usuarios" con campos "rut," "nombre," y "apellido_paterno"
    // Ejemplo de consulta SQL (sustituye esto con tu consulta real):
    $query = "SELECT nombre, apellidoP FROM utp WHERE rut = '$utp_rut'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $user_info = mysqli_fetch_assoc($result);
        $nombre = $user_info['nombre'];
        $apellido_paterno = $user_info['apellidoP'];

        $saludo = "Bienvenido, $nombre $apellido_paterno";
?>
    <link rel="stylesheet" href="../src/css/ventanas/presentacion.css">

    <div class="tarjeta-gris">
    <div class="tarjeta-bienvenida">
        <div class="imagen-usuario">
            <i class="fa-solid fa-user"></i>
        </div>
        <div class="contenido">
            <p><?php echo $saludo ?></p>
            <div class="hora-chile">Hora</div>
            <div class="fecha-hoy"><?php echo date('d/m/Y'); ?></div>
            <form action="../includes/logout.php" method="post">
                <button type="submit" name="logout" class="boton-l"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
            </form>
        </div>
    </div>
    </div>
        
        <div class="barra-alumnos">
            <a href="seleccionar_curso.php"><button>Ver Notas</button></a>
            <a href="asignaturas_asistencia.php"><button>Administrar Asistencia</button></a>
            <a href="asignaturas_curso.php"><button>Mensajes</button></a>
            
        </div>
        <div id="calendar">
    <div id="calendar-header">
        <button id="calendar-prev">Anterior</button>
        <h2 id="calendar-month-year">Octubre 2023</h2>
        <button id="calendar-next">Siguiente</button>
    </div>
    <div id="calendar-days">
        <div class="calendar-day">Dom</div>
        <div class="calendar-day">Lun</div>
        <div class="calendar-day">Mar</div>
        <div class="calendar-day">Mié</div>
        <div class="calendar-day">Jue</div>
        <div class="calendar-day">Vie</div>
        <div class="calendar-day">Sáb</div>
    </div>
    <div id="calendar-grid"></div>
    </div>
    <div class="asistencia-card">
    <h3>Asistencia</h3>
    <div class="grafico">
        <canvas id="asistencia-chart"></canvas>
    </div>
</div>

        <script src="../src/javas/calendar.js"></script>




    <script src="../src/javas/calendar.js"></script>

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

