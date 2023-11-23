<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    $to = "consultas@proyectocolaborativo.cl";
    $subject = "Nuevo mensaje de contacto";
    $headers = "From: $email";

    $mailBody = "Nombre: $name\nCorreo electrónico: $email\nMensaje:\n$message";

    // Envía el correo electrónico
    mail($to, $subject, $mailBody, $headers);
}
?>
