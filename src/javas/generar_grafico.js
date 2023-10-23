document.addEventListener("DOMContentLoaded", function () {
    // Función para obtener los datos del gráfico a través de una solicitud AJAX
    function obtenerDatosGrafico(cursoID, asignaturaID) {
        // Realiza una solicitud AJAX para obtener los datos de la base de datos
        fetch("obtener_datos.php", {
            method: "POST",
            body: JSON.stringify({ curso: cursoID, asignatura: asignaturaID }),
            headers: {
                "Content-Type": "application/json",
            },
        })
        .then((response) => response.json())
        .then((data) => {
            // Llama a la función para crear o actualizar el gráfico con los datos obtenidos
            crearActualizarGrafico(data);
        })
        .catch((error) => {
            console.error("Error al obtener los datos del gráfico: " + error);
        });
    }

    // Función para crear o actualizar el gráfico
    function crearActualizarGrafico(data) {
        // Elimina el gráfico anterior si existe
        if (myChart) {
            myChart.destroy();
        }

        // Obtén el contexto del lienzo
        var ctx = document.getElementById("graficoPromedioCalificaciones").getContext("2d");

        // Crea un nuevo gráfico con los datos y opciones
        myChart = new Chart(ctx, {
            type: "bar",
            data: data, // No es necesario incluir "data" nuevamente
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10,
                    },
                },
            },
        });
    }

    // Evento para manejar el cambio en los campos de selección de curso y asignatura
    document.getElementById("curso").addEventListener("change", function () {
        var cursoID = this.value;
        var asignaturaID = document.getElementById("asignatura").value;

        // Llama a la función para obtener los datos del gráfico
        obtenerDatosGrafico(cursoID, asignaturaID);
    });

    document.getElementById("asignatura").addEventListener("change", function () {
        var cursoID = document.getElementById("curso").value;
        var asignaturaID = this.value;

        // Llama a la función para obtener los datos del gráfico
        obtenerDatosGrafico(cursoID, asignaturaID);
    });

    // Evento para manejar el clic en el botón "Crear gráfico"
    document.getElementById("crearGrafico").addEventListener("click", function () {
        var cursoID = document.getElementById("curso").value;
        var asignaturaID = document.getElementById("asignatura").value;

        // Llama a la función para obtener los datos del gráfico
        obtenerDatosGrafico(cursoID, asignaturaID);
    });

    // Inicializa una variable para el gráfico
    var myChart = null;
});
