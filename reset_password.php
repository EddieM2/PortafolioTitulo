<?php
include("models/db.php");
include("includes/headerlogin.php");

// Verifica la conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Configura el conjunto de caracteres a UTF-8
mysqli_set_charset($conexion, "utf8");

// Verifica si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtén la nueva contraseña del formulario
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verifica que las contraseñas coincidan
    if ($new_password === $confirm_password) {
        // Obtén el token del formulario (pasado por el enlace)
        $token = $_GET['token'];

        // Busca el correo asociado al token en la tabla de tokens
        $token_query = "SELECT email FROM reset_password_tokens WHERE token = '$token' AND expiration_time > NOW()";
        $token_result = mysqli_query($conexion, $token_query);

        if (mysqli_num_rows($token_result) > 0) {
            // Obtén el correo del primer resultado
            $fila = mysqli_fetch_assoc($token_result);
            $correo_usuario = $fila['email'];

            // Busca el rut asociado al correo en las tablas de usuarios
            $tablas = array("profesor", "alumno", "apoderado", "admin", "salud_mental", "seguimiento_denuncia", "utp");
            $rut_usuario = "";

            foreach ($tablas as $tabla) {
                $rut_query = "SELECT rut FROM $tabla WHERE correo = '$correo_usuario'";
                $rut_result = mysqli_query($conexion, $rut_query);

                if (mysqli_num_rows($rut_result) > 0) {
                    // Obtén el rut del primer resultado
                    $fila_rut = mysqli_fetch_assoc($rut_result);
                    $rut_usuario = $fila_rut['rut'];
                    // Puedes detener el bucle si encuentras el rut en una tabla
                    break;
                }
            }

            if (!empty($rut_usuario)) {
                // Hashea la nueva contraseña
                $hashed_password = substr(hash('sha256', $new_password), 0, 12);

                // Actualiza la contraseña en la tabla login
                $update_query = "UPDATE login SET pass = '$hashed_password' WHERE rut = '$rut_usuario'";
                $update_result = mysqli_query($conexion, $update_query);

                if ($update_result) {
                    echo "Contraseña actualizada correctamente.";
                } else {
                    echo "Error al actualizar la contraseña: " . mysqli_error($conexion);
                }
            } else {
                echo "Error: No se pudo encontrar el usuario asociado al correo electrónico.";
            }
        } else {
            echo "Error: El token es inválido o ha expirado.";
        }
    } else {
        echo "Error: Las contraseñas no coinciden. Intenta nuevamente.";
    }
}

// Cierra la conexión a la base de datos
$conexion->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Restablecer Contraseña</title>
    <link rel="stylesheet" href="src/css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
    <div class="background-container"></div>
    <div class="login-container">
        <div class="login-card">
            <h2>Restablecer Contraseña</h2>
            <!-- Formulario de restablecimiento de contraseña -->
            <form method="post">
                <!-- Campo de entrada para la nueva contraseña -->
                <div class="form-group">
                    <label for="new_password">Nueva Contraseña:</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>
                <!-- Campo de entrada para confirmar la nueva contraseña -->
                <div class="form-group">
                    <label for="confirm_password">Confirmar Contraseña:</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
                <!-- Botón para enviar la solicitud -->
                <div class="form-group">
                    <button type="submit" class="login-button">Restablecer Contraseña</button>
                </div>
            </form>
        </div>
    </div>
    <?php include("includes/footer.php") ?>
</body>
</html>
