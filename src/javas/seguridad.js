function validarLogin() {
    var user = document.getElementById('user').value;
    var pass = document.getElementById('pass').value;
    
    var userValido = /^[A-Za-z0-9._]+$/.test(user) && !/[<>]/.test(user);
    if (!userValido) {
        alert('El Usuario ingresado no es válido.');
        return false;
    }
    
    var passValido = /^[\s\S]*$/.test(pass);
    if (!passValido) {
        alert('La contraseña ingresada no es valida.');
        return false;
    }
    
    return true;
}

function validarFormularioAlumno() {
    var rut = document.getElementById('rut').value;
    var correo = document.getElementById('correo').value;
    var nombre = document.getElementById('nombre').value;
    var apellidoM = document.getElementById('apellidoM').value;
    var apellidoP = document.getElementById('apellidoP').value;
    var idCargo = document.getElementById('idCargo').value;
    var fechaNacimiento = document.getElementById('fechaNacimiento').value;
    var direccion = document.getElementById('direccion').value;
    var telefono = document.getElementById('telefono').value;
    var genero = document.getElementById('genero').value;
    var estadoAcademico = document.getElementById('estadoAcademico').value;

    
    var rutValido = /^[\d]{7,8}-[0-9Kk]$/.test(rut);
    if (!rutValido) {
        alert('El RUT ingresado no es válido.');
        return false;
    }

    var correoValido = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(correo) && !/[<>]/.test(correo);
    if (!correoValido) {
        alert('El correo electrónico ingresado no es válido.');
        return false;
    }

    // Falta agregar los demás campos

    return true;
}

function validarFormularioApoderado() {
    var rut = document.getElementById('rut').value;
    var correo = document.getElementById('correo').value;
    var nombre = document.getElementById('nombre').value;
    var apellidoM = document.getElementById('apellidoM').value;
    var apellidoP = document.getElementById('apellidoP').value;
    var idCargo = document.getElementById('idCargo').value;
    var fechaNacimiento = document.getElementById('fechaNacimiento').value;
    var direccion = document.getElementById('direccion').value;
    var telefono = document.getElementById('telefono').value;
    var genero = document.getElementById('genero').value;
    var estadoAcademico = document.getElementById('estadoAcademico').value;

    
    var rutValido = /^[\d]{7,8}-[0-9Kk]$/.test(rut);
    if (!rutValido) {
        alert('El RUT ingresado no es válido.');
        return false;
    }

    var correoValido = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/.test(correo) && !/[<>]/.test(correo);
    if (!correoValido) {
        alert('El correo electrónico ingresado no es válido.');
        return false;
    }

    // Falta agregar los demás campos

    return true;
}