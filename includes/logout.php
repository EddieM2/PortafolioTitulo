<?php
session_start();

// Destruye todas las sesiones
session_destroy();

// Redirige al usuario a la página de inicio de sesión
header("Location: ../index.php"); // Cambia "login.php" al archivo de inicio de sesión real
exit();
?>
