<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $message = isset($_POST["message"]) ? $_POST["message"] : "";

    // Verifica si los campos obligatorios están presentes
    if (empty($name) || empty($email) || empty($message)) {
        die("Por favor, complete todos los campos del formulario.");
    }

    $to = "consultas@proyectocolaborativo.cl";
    $subject = "Nuevo mensaje de contacto";
    $headers = "From: $email";

    $mailBody = "Nombre: $name\nCorreo electrónico: $email\nMensaje:\n$message";

    // Intenta enviar el correo electrónico
    if (mail($to, $subject, $mailBody, $headers)) {
        echo "¡Correo electrónico enviado con éxito!";
    } else {
        echo "Error al enviar el correo electrónico. Por favor, inténtelo de nuevo más tarde.";
    }
} else {
    echo "Acceso no autorizado.";
}
?>

