<?php
include("models/db.php");
include("includes/headerlogin.php");
// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén el correo electrónico del formulario
    $email = $_POST['email'];

    // Array con nombres de las tablas a verificar
    $tablas = array("profesor", "alumno", "apoderado", "admin", "salud_mental", "seguimiento_denuncia", "utp");

    // Variables para almacenar la información del usuario
    $usuario_encontrado = false;
    $rut_usuario = "";

    // Verifica la existencia del correo en las tablas
    foreach ($tablas as $tabla) {
        $query = "SELECT rut FROM $tabla WHERE correo = '$email'";
        $result = mysqli_query($conexion, $query);

        if (mysqli_num_rows($result) > 0) {
            $usuario_encontrado = true;
            // Obtén el rut del primer resultado
            $fila = mysqli_fetch_assoc($result);
            $rut_usuario = $fila['rut'];
            break;
        }
    }

    if ($usuario_encontrado) {
        // Genera un token único
        $token = bin2hex(random_bytes(32));

        // Almacena el token en la base de datos junto con la información del usuario
        $insert_query = "INSERT INTO reset_password_tokens (email, token, expiration_time) VALUES ('$email', '$token', NOW() + INTERVAL 1 HOUR)";
        mysqli_query($conexion, $insert_query);

        // Envia el correo electrónico con el enlace de restablecimiento
        $reset_link = "http://proyectocolaborativo.cl/reset_password_page.php?token=$token";
        $subject = "Restablecimiento de Contraseña";
        $message = "Para restablecer tu contraseña, haz clic en el siguiente enlace:\n$reset_link";
        $headers = "From: tu-correo@dominio.com";

        // Envía el correo
        if (mail($email, $subject, $message, $headers)) {
            echo "Se ha enviado un enlace de restablecimiento a tu correo electrónico.";
        } else {
            echo "Error al enviar el correo.";
        }
    } else {
        echo "El correo electrónico no está registrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Recuperar Contraseña</title>
    <link rel="stylesheet" href="src/css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="background-container"></div>
    <div class="login-container">
        <div class="login-card">
            <h2>Recuperar Contraseña</h2>
            <!-- Formulario de solicitud de cambio de contraseña -->
            <form method="post">
                <!-- Campo para el correo electrónico -->
                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="Correo Electrónico" required>
                </div>
                <!-- Botón para enviar la solicitud -->
                <div class="form-group">
                    <button type="submit" class="login-button">Enviar Solicitud</button>
                </div>
            </form>
        </div>
    </div>
    <?php include("includes/footer.php") ?>
</body>
</html>
