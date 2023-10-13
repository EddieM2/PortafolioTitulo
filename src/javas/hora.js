function mostrarHoraChile() {
    const ahora = new Date();
    const horaChile = new Date(ahora.toLocaleString("en-US", { timeZone: "America/Santiago" }));
    const hora = horaChile.toLocaleTimeString("es-CL", { hour: "2-digit", minute: "2-digit", second: "2-digit" });

    const horaChileElement = document.querySelector('.hora-chile');
    horaChileElement.textContent = `reloj: ${hora}`;
}

setInterval(mostrarHoraChile, 1000); // Actualiza la hora cada segundo
mostrarHoraChile(); // Muestra la hora al cargar la página
