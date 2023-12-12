<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST["name"]) ? $_POST["name"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $message = isset($_POST["message"]) ? $_POST["message"] : "";

    // Verifica si los campos obligatorios est��n presentes
    if (empty($name) || empty($email) || empty($message)) {
        die("Por favor, complete todos los campos del formulario.");
    }

    $to = "consultas@proyectocolaborativo.cl";
    $subject = "Nuevo mensaje de contacto";
    $headers = "From: $email";

    $mailBody = "Nombre: $name\nCorreo electr��nico: $email\nMensaje:\n$message";

    // Intenta enviar el correo electr��nico
    if (mail($to, $subject, $mailBody, $headers)) {
        echo "�0�3Correo electr��nico enviado con ��xito!";
    } else {
        echo "Error al enviar el correo electr��nico. Por favor, int��ntelo de nuevo m��s tarde.";
    }
} else {
    echo "Acceso no autorizado.";
}
?>

