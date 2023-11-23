<?php include("../models/db.php") ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<?php

// Verifica si el usuario ha iniciado sesión como administrador
if (isset($_SESSION['rut']) && $_SESSION['rut'] != '') {
    $admin_rut = $_SESSION['rut'];


    $query = "SELECT nombre, apellidoP FROM admin WHERE rut = '$admin_rut'";
    $result = mysqli_query($conexion, $query);

    if ($result) {
        $user_info = mysqli_fetch_assoc($result);
        $nombre = $user_info['nombre'];
        $apellido_paterno = $user_info['apellidoP'];

        $saludo = "Bienvenido, $nombre $apellido_paterno";
?>
    <link rel="stylesheet" href="../src/css/ventanas/presentacion.css">
    <script src="../src/javas/alum.js"></script>
    <script src="../src/javas/hora.js"></script>

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
            <a href="../models/alumnosModels/vistaAlumnos.php"><button id="btnNotas">Administrar Alumnos</button></a>
            <a href="../models/apoderadosModels/vistaApoderados.php"><button id="btnAsistencias">Administrar Apoderados</button></a>
            <a href="../models/profesoresModels/vistaProfesores.php"><button id="btnAnotaciones">Administrar Profesores</button></a>
           
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
    <h3>Gráficos</h3>
    <div class="btn btn-primary">
        <a class="btn btn-primary" href="vista_grafico_asistencia.php">
            <i class="fas fa-chart-line"></i> Gráfico de Asistencia
        </a>
    </div>
    <div class="btn btn-primary">
        <a class="btn btn-primary" href="grafico_calificaciones.php">
            <i class="fas fa-chart-bar"></i> Gráfico de Calificaciones
        </a>
    </div>
</div>

        <script src="../src/javas/calendar.js"></script>

        

<?php 
    } else {
        // Manejo de errores si la consulta falla
        echo "Error al obtener la información del usuario.";
    }

   
} else {
    // Si el usuario no ha iniciado sesión como administrador, redirige o muestra un mensaje de error
    header("Location: ../login.php"); 
    exit();
}
?>

