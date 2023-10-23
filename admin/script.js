document.addEventListener('DOMContentLoaded', function () {
    const generarGraficoBtn = document.getElementById('generar-grafico');
    const cursoSelect = document.getElementById('curso');
    const asignaturaSelect = document.getElementById('asignatura');
    const chartContainer = document.getElementById('chart-container');
    let myChart; // Variable para almacenar la instancia del gráfico

    generarGraficoBtn.addEventListener('click', function () {
        const idCurso = cursoSelect.value;
        const idAsignatura = asignaturaSelect.value;

        if (idCurso && idAsignatura) {
            fetch('grafico_controller.php', {
                method: 'POST',
                body: new URLSearchParams({ curso: idCurso, asignatura: idAsignatura }),
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Hubo un problema con la solicitud.');
                }
                return response.json();
            })
            .then(jsonData => {
                if (myChart) {
                    myChart.destroy();
                }

                const ctx = chartContainer.getContext('2d');
                console.log('Canvas creado:', ctx);
                myChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Calificación 1', 'Calificación 2', 'Calificación 3', 'Calificación 4'],
                        datasets: [
                            {
                                label: 'Promedios de Calificaciones',
                                data: [jsonData.promedio1, jsonData.promedio2, jsonData.promedio3, jsonData.promedio4],
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1,
                            },
                        ],
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                            },
                        },
                    },
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    });
});
